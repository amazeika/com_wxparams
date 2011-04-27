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
class WxparamsConfig extends KObjectArray
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
		
		$this->_data = KConfig::toData($config->params);
	
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
	
	/**
	 * Initializes the options for the object.
	 * 
	 * @param KConfig $config The configuration object.
	 */
	protected function _initialize(KConfig $config)
	{
		$config->append(array('row' => null, 'params' => array()
		));
		parent::_initialize($config);
	}

}