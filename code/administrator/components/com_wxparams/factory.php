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
 * Factory class.
 *
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsFactory
{
	
	final private function __construct()
	{
	}
	
	/**
	 * Returns a form object.
	 *
	 * @param $config array
	 *       	 Optional configuration array.
	 * @return WxForm The form object.
	 */
	public static function getForm($config = array())
	{
		$config = new KConfig($config);
		
		$form = WxHelperApplication::getPath('admin') . '/components/' . $config->package . '/configs/' . str_replace('.', '/', $config->type) . '/form.xml';
		
		return KService::get('com://admin/wxparams.form.default', array(
			'form' => $form, 
			'data' => $config->params, 
			'container' => 'params'));
	}
	
	/**
	 * Returns a model behavior object based on the application being used.
	 *
	 * @param
	 *       	 array An optional configuration array.
	 * @return object The model behavior object.
	 */
	public static function getModelBehavior($config = array())
	{
		$config = new KConfig($config);
		$class_name = 'ComWxparamsModelBehavior' . ucfirst(KInflector::singularize($config->model)) . WxHelperApplication::getName();
		return new $class_name();
	}

}