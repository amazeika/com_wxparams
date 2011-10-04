<?php

class WxparamsHelperSession
{
	
	/**
	 * Returns the session state variable containing the requested model state.
	 * 
	 * @param array An optional configuration array.
	 * @return array The session variable containing the requested model state.
	 */
	static public function getModelState($config = array())
	{
		$config = new KConfig($config);
		$config->append(array('view' => 'configurations', 'action' => 'browse'));
		return KRequest::get('session.admin::com.wxparams.model.' . $config->view . '.' . $config->action, 'cmd', array());
	}

}