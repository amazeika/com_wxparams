<?php

class ComWxparamsModelConfigurations extends KModelDefault {
	
	protected function _initialize(KConfig $config) {
		$config->append( array ('table_behaviors' => array ('admin::com.wxparams.database.behavior.configurationsdefaultable' ) ) );
		parent::_initialize( $config );
	}

}