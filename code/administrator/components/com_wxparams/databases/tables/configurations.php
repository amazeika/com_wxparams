<?php

class ComWxparamsDatabaseTableConfigurations extends KDatabaseTableDefault
{
	
	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'behaviors' => array(
				'com://admin/wxparams.database.behavior.configuration.defaultable', 
				'com://admin/wxparams.database.behavior.configuration.validatable', 
				'lockable')));
		parent::_initialize($config);
	}

}