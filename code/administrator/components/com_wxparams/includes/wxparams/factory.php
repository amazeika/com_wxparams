<?php

class WxparamsFactory {
	
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
			
			$class_dir = WXINVOICES_INCLUDES . DS . implode( DS, $path );
			
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