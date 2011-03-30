<?php

defined('KOOWA') or die('Restricted access');

// Load the WeXtend framework
define( 'WXPATH_ADMINISTRATOR', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_wextend' );
require_once WXPATH_ADMINISTRATOR . DS . 'framework' . DS . 'framework.php';
// Load the component framework
require_once dirname(__FILE__).'/includes/framework.php'; 

echo KFactory::get('admin::com.wxparams.dispatcher')->dispatch(KRequest::get('get.view','cmd','configurations'));