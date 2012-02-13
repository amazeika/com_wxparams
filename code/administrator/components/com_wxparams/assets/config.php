<?php
/**
 * @version 1.0 $Id$
 * @package com_wxparams
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
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
	 * @param $config KConfig
	 *       	 Optional configuration object.
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
	 * @param $config KConfig
	 *       	 The configuration object.
	 */
	protected function _initialize(KConfig $config)
	{
		$config->append(array('row' => null, 'params' => array()));
		parent::_initialize($config);
	}
	
	/**
	 * Instantiation logic.
	 *
	 * @param
	 *       	 KConfigInterface Configuration object.
	 * @param
	 *       	 KServiceInterface The service container.
	 */
	public static function getInstance(KConfigInterface $config, KServiceInterface $container)
	{
		// Append default values.
		$config->append(array(
			'package' => KRequest::get('get.option', 'cmd'), 
			'type' => 'view.' . KRequest::get('get.view', 'cmd')))
			->append(array(
			'item_id' => $config->type == 'global' ? '0' : KRequest::get('get.Itemid', 'int', 0)));
		
		$signature = $config->package . '.' . $config->type . '.' . $config->item_id;
		
		$identifier = $config->service_identifier . '.' . $signature;
		
		// Check if a configuation object with the current identifier already
		// exists in the service container.
		if(call_user_func(array($container, 'has'), $identifier)) {
			return call_user_func(array($container, 'get'), $identifier);
		}
		
		$row = call_user_func(array($container, 'get'), 'com://admin/wxparams.database.row.configuration');
		
		if($config->item_id) {
			// An item_id was provided/determined, attempt to get a
			// corresponding configuration row.
			$row->setData(array(
				'package' => $config->package, 
				'item_id' => $config->item_id, 
				'type' => $config->type))
				->load();
		}
		
		if($row->isNew()) {
			$row->reset();
			// Default row fallback.
			$row->setData(array(
				'package' => $config->package, 
				'type' => $config->type, 
				'default' => 1))
				->load();
		}
		
		$form = ComWxparamsFactory::getForm(array(
			'package' => $config->package, 
			'type' => $config->type, 
			'params' => $row->getParams()));
		
		$config->params = $form->getData();
		
		if(!$row->isNew()) {
			// Append the row to the configuration object.
			$config->row = $row;
		}
		
		// Instantiate the object
		$instance = new self($config);
		
		// Set the object in the container for further use.
		call_user_func(array($container, 'set'), $identifier, $instance);
		
		return $instance;
	}
	
	/**
	 * Saves the current set of parameteres to the corresponding configuration
	 * row (if any).
	 *
	 * @return boolean True if successfully saved, false otherwise.
	 */
	public function save()
	{
		// The configuration can only be saved if a row for this configuration
		// object exists.
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