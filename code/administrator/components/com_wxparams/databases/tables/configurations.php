<?php

class ComWxparamsDatabaseTableConfigurations extends KDatabaseTableDefault
{
	
	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'behaviors' => array(
				'admin::com.wxparams.database.behavior.configuration.defaultable', 
				'admin::com.wxparams.database.behavior.configuration.validatable', 
				'lockable')));
		parent::_initialize($config);
	}

}