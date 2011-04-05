<?php

class ComWxparamsDatabaseTableMenus extends KDatabaseTableDefault {
	
	protected function _initialize(KConfig $config) {
		$config->append( array ('base' => 'menu', 'name' => 'menu' ) );
		parent::_initialize( $config );
	}

}