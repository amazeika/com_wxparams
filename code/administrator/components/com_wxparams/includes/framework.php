<?php

define( 'WXPARAMS_INCLUDES', dirname( __FILE__ ) );

require_once (WXPARAMS_INCLUDES . DS . 'wxparams' . DS . 'factory.php');

// SPL Autoload
if (spl_autoload_functions() === false) {
	if (function_exists( '__autoload' )) {
		spl_autoload_register( '__autoload', false );
	}
}

// Checking if .php makes part of the current autoload extensions list adding it if necessary
$autoload_extensions = spl_autoload_extensions();
$autoload_extensions = str_replace( ' ', '', $autoload_extensions );
if (! in_array( '.php', explode( ',', $autoload_extensions ) )) {
	spl_autoload_extensions( $autoload_extensions . ',.php' );
}

// Registering the custom autoload function
spl_autoload_register( array ('WxparamsFactory', 'autoload' ) ); 