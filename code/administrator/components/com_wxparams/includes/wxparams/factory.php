<?php

class WxparamsFactory {
	
	static $_config;
	
	/**
	 * Constructor.
	 * 
	 * Method declared final private to avoid instances of this class.
	 * 
	 */
	final private function __construct() {
	
	}
	
	/**
	 * Prevent clonning.
	 */
	final private function __clone() {
	
	}
	
	/**
	 * Returns the form
	 *
	 * @param SimpleXMLElement $xml
	 * @return mixed ComWxparamsFormDefault or ComWxparamsFormTabbed depending on the passed
	 * XML data.
	 */
	static public function getForm($params = null) {
		
		// Get the package from the session variable
		$package = KRequest::get( 'session.com.wxparams.package', 'cmd' );
		
		$xml = new SimpleXMLElement( file_get_contents( JPATH_ROOT . '/media/' . $package . '/config/' . $package . '.xml' ) );
		
		foreach ( $xml->children() as $name => $element ) {
			// A form is considered as tabbed if every root element is a tab element.
			if ($name != 'tab') {
				return KFactory::tmp( 'admin::com.wxparams.form.default' )->importXml( $xml, $params );
			}
		}
		return KFactory::tmp( 'admin::com.wxparams.form.tabbed' )->importXml( $xml, $params );
	}
	
	static public function getConfig($package = null, $item_id = null) {
		
		if (! $package) {
			$package = KRequest::get( 'get.option', 'cmd' );
		}
		
		if (! $item_id) {
			// If the item_id is not set, com_params attemps to get this value from the request on
			// frontend applications. On backend applications, this value is forced to 0, which is
			// the item_id value used for backend configuration rows. 
			if (KFactory::get( 'lib.joomla.application' )->isSite()) {
				$item_id = KRequest::get( 'get.Itemid', 'int', null );
			} else {
				$item_id = 0;
			}
		}
		
		// Cache
		if (self::$_config instanceof WxparamsConfig) {
			if (! $row = self::$_config->getRow()) {
				// No row attached to the configuration object, no way to know if package and item_id
				// changed. We force the re-generation of the configuration object.
				self::$_config = null;
			} elseif (! ($row->package == $package && $row->item_id == $item_id)) {
				// A different configuration object is being requested. We force the re-generation of
				// the configuration object.
				self::$_config = null;
			}
		}
		
		if (! self::$_config) {
			
			$model = KFactory::tmp( 'admin::com.wxparams.model.configurations' );
			
			if (! is_null( $item_id )) {
				// An item_id was provided/determined, attempt to get a corresponding configuration object.
				$row = $model->set( array ('package' => $package, 'item_id' => $item_id ) )->getItem();
				if ($row->id) {
					self::$_config = new WxparamsConfig( new KConfig( array ('row' => $row, 'params' => $row->getParams() ) ) );
					return self::$_config;
				}
			}
			
			// Default configuration fallback. getList must be used as the state is not unique.
			$rowset = $model->reset()->set( array ('package' => $package, 'default' => 1 ) )->getList();
			foreach ( $rowset as $row ) {
				self::$_config = new WxparamsConfig( new KConfig( array ('row' => $row, 'params' => $row->getParams() ) ) );
				return self::$_config;
			}
			
			// Configuration not found. Return a configuration default object (containing the default
			// values in the form XML file).
			self::$_config = new WxparamsConfig( new KConfig( array ('params' => WxparamsFactory::getForm()->getDefaults() ) ) );
		}
		return self::$_config;
	}
	
	/**
	 * 
	 * SPL custom autoload function. 
	 * 
	 * @param string $class
	 */
	public static function autoload($class) {
		
		// 3rd party libraries
		switch ($class) {
			/*case 'Toto' :
				require_once (dirname( __FILE__ ) . DS . '..' . DS . '..' . DS . 'toto' . DS . 'toto.php');
				break;*/
		}
		
		$path = array ();
		
		// Split pascal cased strings
		$results = preg_split( '#(?<!^)(?=[A-Z])#', $class );
		
		// Map the current prefix to the corresponding directory
		switch ($results [0]) {
			case 'Wxparams' :
				$path [] = 'wxparams';
				// Remove the prefix
				array_shift( $results );
				break;
		}
		
		while ( 1 ) {
			
			$class_dir = WXPARAMS_INCLUDES . DS . implode( DS, $path );
			
			if (! empty( $results )) {
				// For a class like WxMediaAbstract, it will check for wextend/mediaabstract.php,
				// and wextend/media/abstract.php on two iterations
				$class_file_name = strtolower( implode( '', $results ) ) . '.php';
				$class_path = $class_dir . DS . $class_file_name;
				
				// Checks if the current class path exists, loading the class if it does
				if (file_exists( $class_path )) {
					require_once ($class_path);
					break;
				}
			} else {
				// As a last attempt to load the class, check if a class with the same name as the
				// last item in the path exists, i.e. wextend/file/file.php for WxFile class
				$class_file_name = strtolower( end( $path ) ) . '.php';
				$class_path = $class_dir . DS . $class_file_name;
				if (file_exists( $class_path )) {
					require_once ($class_path);
				}
				break;
			}
			
			$path [] = strtolower( array_shift( $results ) );
		}
	
	}

}