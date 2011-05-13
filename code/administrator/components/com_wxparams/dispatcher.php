<?php

class ComWxparamsDispatcher extends ComDefaultDispatcher
{
	
	protected function _initialize(KConfig $config)
	{
		// Force model state persistency. This is required so that the config type and package information
		// gets automatically stored the first time the component is accessed, i.e. browsing configuration rows.
		$config->append(array('request_persistent' => true));
		parent::_initialize($config);
	}

}