<?php
/**
 * @version 1.0 $Id: processable.php 298 2011-11-07 09:49:49Z amazeika $
 * @package com_wextend
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 */

/**
 * Abstract processable behavior.
 * 
 * Handles data processing which includes but it's not limited to filtering and data formatting prior add/edit actions.
 * Data processing can be performed before and/or after validation actions by stablishing the priority.
 * 
 * @author Arunas Mazeika
 * @package com_wextend
 */
abstract class ComWxparamsIncludeControllerBehaviorProcessable extends KControllerBehaviorAbstract
{
	/**
	 * @var KCommandContext The command context passed at execution time.
	 */
	protected $_context;
	
	protected function _initialize(KConfig $config)
	{
		// By default, processors are declared with high priority.
		$config->append(array('priority' => KCommand::PRIORITY_HIGH));
		parent::_initialize($config);
	}
	
	/**
	 * Overrided method for setting the current context.
	 * 
	 * @see KControllerBehaviorAbstract::execute()
	 */
	public function execute($name, KCommandContext $context)
	{
		$this->_context = $context;
		return parent::execute($name, $context);
	}
	
	protected function _beforeEdit(KCommandContext $context)
	{
		$this->process();
	}
	
	protected function _beforeAdd(KCommandContext $context)
	{
		// Same as edit
		$this->_beforeEdit($context);
	}
	
	/**
	 * Data processing method.ÊHandles the data processing task by calling a processing method
	 * for each available data value. The processing method will only be called if a processing
	 * method (following a naming convention) and it's corresponding data value are present in
	 * the request data. Each processing method declared in the concrete processable class start
	 * by _process followed by the data name (first letter uppercased).
	 * 
	 */
	public function process()
	{
		foreach($this->_context->data as $input => $value) {
			$method_name = '_process' . ucfirst($input);
			if(method_exists($this, $method_name)) {
				call_user_func(array($this, $method_name));
			}
		}
	}
	
	public function __get($property)
	{
		$data = $this->_context->data;
		return isset($data->$property) ? $data->$property : null;
	}
	
	public function __set($property, $value)
	{
		// Set the property in the context data object.
		$this->_context->data->$property = $value;
	}

}