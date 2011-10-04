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
 * The factory.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class WxparamsFactory extends WxFactoryAbstract
{
	
	/**
	 * @var WxparamsConfig  Configuration object.
	 */
	protected static $_config;
	
	/**
	 * @var WxparamsFactory The factory instance.
	 */
	protected static $_instance;
	
	public static function getInstance()
	{
		if(!self::$_instance instanceof self) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * Returns a form object. If a package is provided in the configuration array, a form for the
	 * requested package will be returned. Otherwise the session package information will be used.
	 *
	 * @param array $config Optional configuration array.
	 * @return mixed ComWxparamsFormDefault or ComWxparamsFormTabbed depending on the XML form.
	 */
	static public function getForm($config = array())
	{
		$config = new KConfig($config);
		
		// Default values
		$config->append(array('params' => null, 'package' => null, 'type' => null));
		
		if(KFactory::tmp('lib.joomla.application')->isAdmin()) {
			
			$session_state = WxparamsHelperSession::getModelState();
			
			if(!$config->package) {
				// Get the package from the session state variable
				$config->package = $session_state['package'];
			}
			
			if(!$config->type) {
				// Get type from the session state variable:
				// * global: for global configuration sets.
				// * view.VIEW_NAME: for view based confifgurations.
				$config->type = $session_state['type'];
			}
		} else {
			//TODO 
		}
		
		$xml = new SimpleXMLElement(file_get_contents(JPATH_ROOT . '/media/' . $config->package . '/config/' . str_replace('.', '/', $config->type) . '/form.xml'));
		
		$config = $config->toArray();
		foreach($xml->children() as $name => $element) {
			// A form is considered as tabbed if every root element is a tab element.
			if($name != 'tab') {
				return KFactory::tmp('admin::com.wxparams.form.default', $config)->importXml($xml);
			}
		}
		return KFactory::tmp('admin::com.wxparams.form.tabbed', $config)->importXml($xml);
	}
	
	/**
	 * Returns a configuration object.
	 * 
	 * If the package is not provided, the method will get its value from the request.
	 * 
	 * If the menu item id is not provided the following sequences apply for providing a configuration
	 * object:
	 * 
	 * Frontend: -> If an Itemid variable is available in the request, use it for getting the corresponding
	 * configuration row.
	 * -> Look for a default configuration row for the current package.
	 * -> Return a default configuration object containing the default values from the XML form.
	 * 
	 * Backend: -> Look for a configuration row with menu item id of zero (0). Backend configuration
	 * rows have their item_id set to zero.
	 * -> Look for a default configuration row for the current package.
	 * -> Return a default configuration object containing the default values from the XML form.
	 * 
	 * @param array $config An option configuration array.
	 */
	static public function getConfig($config = array())
	{
		$config = new KConfig($config);
		
		// Package and type are mandatory
		if(!$config->package || !$config->type) {
			throw new KException('Package and/or type missing.');
		}
		
		// If the item_id is not set, the component attemps to get this value from the request.
		$config->append(array('item_id' => KRequest::get('get.Itemid', 'int', null)));
		
		// Cache
		if(self::$_config instanceof WxparamsConfig) {
			if(!$row = self::$_config->getRow()) {
				// No row attached to the configuration object, no way to know if package, item_id
				//  and type changed. We force the re-generation of the configuration object.
				self::$_config = null;
			} elseif(!($row->package == $config->package && $row->item_id == $config->item_id && $row->type == $config->type)) {
				// A different configuration object is being requested. We force the re-generation of
				// the configuration object.
				self::$_config = null;
			}
		}
		
		if(!self::$_config) {
			
			$row = KFactory::tmp('admin::com.wxparams.database.row.configuration');
			
			if(!is_null($config->item_id)) {
				// An item_id was provided/determined, attempt to get a corresponding configuration object.
				$row->setData(array(
					'package' => $config->package, 
					'item_id' => $config->item_id, 
					'type' => $config->type));
				if($row->load()) {
					self::$_config = new WxparamsConfig(new KConfig(array(
						'row' => $row, 
						'params' => $row->getParams())));
					return self::$_config;
				}
			}
			
			// Default configuration fallback.
			$row->reset();
			$row->setData(array(
				'package' => $config->package, 
				'type' => $config->type, 
				'default' => 1));
			if($row->load()) {
				self::$_config = new WxparamsConfig(new KConfig(array(
					'row' => $row, 
					'params' => $row->getParams())));
				return self::$_config;
			}
			
			// Configuration not found. Return a configuration default object (containing the default
			// values in the form XML file).
			self::$_config = new WxparamsConfig(new KConfig(array(
				'params' => WxparamsFactory::getInstance()->get('form', array(
					'package' => $config->package, 
					'type' => $config->type))
					->getDefaults())));
		}
		return self::$_config;
	}
}