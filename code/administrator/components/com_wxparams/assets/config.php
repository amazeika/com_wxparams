<?php
/**
 * @version 1.0 $Id$
 * @package com_wxparams
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 * 
 */

/**
 * Configuration object.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsAssetConfig extends KObjectArray implements KServiceInstantiatable
{
	
	/**
	 * Configuration row.
	 * 
	 * @var mixed ComWxparamsDatabaseRowConfiguration or null.
	 */
	protected $_row;
	
	/**
	 * Constructor.
	 * 
	 * @param KConfig $config Optional configuration object.
	 */
	public function __construct(KConfig $config = null)
	{
		
		if(!$config) {
			$config = new KConfig();
		}
		
		parent::__construct($config);
		
		$this->_row = $config->row;
		
		$this->_data = KConfig::unbox($config->params);
	
	}
	
	/**
	 * Initializes the options for the object.
	 * 
	 * @param KConfig $config The configuration object.
	 */
	protected function _initialize(KConfig $config)
	{
		$config->append(array('row' => null, 'params' => array()));
		parent::_initialize($config);
	}
	
	public static function getInstance(KConfigInterface $config, KServiceInterface $container)
	{
		// Append default values.
		$config->append(array(
			'package' => KRequest::get('get.option','cmd'), 
			'type' => 'view.' . KRequest::get('get.view','cmd'), 
			'item_id' => KRequest::get('get.Itemid', 'int', 0)));

		$signature = $config->package . '.' . $config->type . '.';
		$signature .= $config->type == 'global' ? '0' : $config->item_id;
		
		$identifier = 'com://admin/wxparams.asset.config.' . $signature;

		// Check if a configuation object with the current identifier already exists in the service container.
		if(KService::has($identifier)) {
			return $this->getService($identifier);
		}
		
		$row = $this->getService('com://admin/wxparams.database.row.configuration');
		
		if($config->item_id) {
			// An item_id was provided/determined, attempt to get a corresponding configuration row.
			$row->setData(array(
				'package' => $config->package, 
				'item_id' => $config->item_id, 
				'type' => $config->type))
				->load();
		} else {
			// Default row fallback.
			$row->setData(array(
				'package' => $config->package, 
				'type' => $config->type, 
				'default' => 1))
				->load();
		}
		
		$form = ComWxparamsFactory::getForm(array(
			'package' => $config->package, 
			'type' => $config->type));
		
		if(!$row->isNew()) {
			$config->row = $row;
			$config->params = $row->getParams();
			// Merge form params (useful after upgrade when configuration rows are not yet synced with latest
			// config form changes).
			$config->params = array_merge($config->params, $form->getDefaults());
		} else {
			// Configuration row not found. Return a default configuration object (containing the default values in
			// the config form file).
			$config->params = $form->getDefaults();
		}
		
		// Instantiate the object
		$instance = new self($config);
		
		// Set the object in the container for further use.
		KService::set($identifier, $instance);
		
		return $instance;
	}
	
	/**
	 * Saves the current set of parameteres to the corresponding configuration row (if any).
	 * 
	 * @return boolean True if successfully saved, false otherwise.
	 */
	public function save()
	{
		// The configuration can only be saved if a row for this configuration object exists.
		if($this->_row instanceof ComWxparamsDatabaseRowConfiguration) {
			$this->_row->params = json_encode($this->toArray());
			if($this->_row->save()) {
				$this->_data = $this->_row->getParams();
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Row getter.
	 * 
	 * @return mixed ComWxparamsDatabaseRowConfiguration or null. 
	 */
	public function getRow()
	{
		return $this->_row;
	}
}