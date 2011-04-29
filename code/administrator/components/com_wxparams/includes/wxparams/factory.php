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
class WxparamsFactory
{
	
	/**
	 * Configuration object.
	 * 
	 * @var WxparamsConfig 
	 */
	static $_config;
	
	/**
	 * Constructor.
	 * 
	 * Method declared final private to avoid instances of this class.
	 * 
	 */
	final private function __construct()
	{
	
	}
	
	/**
	 * Prevent clonning.
	 */
	final private function __clone()
	{
	
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
			
			$session_state = self::getSessionState();
			
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

		$xml = new SimpleXMLElement(file_get_contents(JPATH_ROOT . '/media/' . $config->package . '/config/' .
			 str_replace('.', '/', $config->type) . '/form.xml'));
		
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
	 * Returns the session state variable which corresponds to the configurations view model state.
	 * This variable provides information about the pre-selected package and view to be used to create
	 * configuration rows.
	 * 
	 * 
	 */
	static public function getSessionState()
	{
		return KRequest::get('session.admin::com.wxparams.model.configurations.', 'cmd', array());
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
		
		// Default values:
		// 1. If the package is not set we take it directly from the request.
		// 2. If the item_id is not set, com_params attemps to get this value from the request.
		// 3. If the type is not set, the component attemps to get this value from the request 
		// (the view) on frontend applications. On the backend, this value is forced to global.
		$config->append(array(
			'package' => KRequest::get('get.option', 'cmd'), 
			'item_id' => KRequest::get('get.Itemid', 'int', null), 
			'type' => KFactory::get('lib.joomla.application')->isSite() ? 'view.' .
				 KRequest::get('get.view', 'cmd') : 'global'));
		
		// Cache
		if(self::$_config instanceof WxparamsConfig) {
			if(!$row = self::$_config->getRow()) {
				// No row attached to the configuration object, no way to know if package and item_id
				// changed. We force the re-generation of the configuration object.
				self::$_config = null;
			} elseif(!($row->package == $config->package && $row->item_id == $config->item_id &&
				 $row->type == $config->type)) {
					// A different configuration object is being requested. We force the re-generation of
					// the configuration object.
					self::$_config = null;
				}
			}
			
			if(!self::$_config) {
				
				$model = KFactory::tmp('admin::com.wxparams.model.configurations');
				
				if(!is_null($item_id)) {
					// An item_id was provided/determined, attempt to get a corresponding configuration object.
					$row = $model->set(array(
						'package' => $config->package, 
						'item_id' => $config->item_id, 
						'type' => $config->type))
						->getItem();
					if($row->id) {
						self::$_config = new WxparamsConfig(new KConfig(array(
							'row' => $row, 
							'params' => $row->getParams())));
						return self::$_config;
					}
				}
				
				// Default configuration fallback. getList must be used as the state is not unique.
				$rowset = $model->reset()
					->set(array('package' => $config->package, 'type' => $config->type, 'default' => 1))
					->getList();
				foreach($rowset as $row) {
					self::$_config = new WxparamsConfig(new KConfig(array(
						'row' => $row, 
						'params' => $row->getParams())));
					return self::$_config;
				}
				
				// Configuration not found. Return a configuration default object (containing the default
				// values in the form XML file).
				self::$_config = new WxparamsConfig(new KConfig(array(
					'params' => WxparamsFactory::getForm(array(
						'package' => $config->package, 
						'type' => $config->type))->getDefaults())));
			}
			return self::$_config;
		}
		
		/**
		 * SPL custom autoload function. 
		 * 
		 * @param string $class The class.
		 */
		public static function autoload($class)
		{
			
			// 3rd party libraries
			switch($class){
				/*case 'Toto' :
				require_once (dirname( __FILE__ ) . DS . '..' . DS . '..' . DS . 'toto' . DS . 'toto.php');
				break;*/
			}
			
			$path = array();
			
			// Split pascal cased strings
			$results = preg_split('#(?<!^)(?=[A-Z])#', $class);
			
			// Map the current prefix to the corresponding directory
			switch($results[0]){
				case 'Wxparams':
					$path[] = 'wxparams';
					// Remove the prefix
					array_shift($results);
					break;
			}
			
			while(1) {
				
				$class_dir = WXPARAMS_INCLUDES . DS . implode(DS, $path);
				
				if(!empty($results)) {
					// For a class like WxMediaAbstract, it will check for wextend/mediaabstract.php,
					// and wextend/media/abstract.php on two iterations
					$class_file_name = strtolower(implode('', $results)) .
						 '.php';
						$class_path = $class_dir . DS . $class_file_name;
						
						// Checks if the current class path exists, loading the class if it does
						if(file_exists($class_path)) {
							require_once ($class_path);
							break;
						}
					} else {
						// As a last attempt to load the class, check if a class with the same name as the
						// last item in the path exists, i.e. wextend/file/file.php for WxFile class
						$class_file_name = strtolower(end($path)) .
							 '.php';
							$class_path = $class_dir . DS . $class_file_name;
							if(file_exists($class_path)) {
								require_once ($class_path);
							}
							break;
						}
						
						$path[] = strtolower(array_shift($results));
					}
				
				}
			
			}