<?php
/**
 * @version 1.0 $Id$
 * @package com_wxparams
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 */

/**
 * Session helper class.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsHelperSession
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
		return KRequest::get('session.com://admin/wxparams.model.' . $config->view . '.' . $config->action, 'cmd', array());
	}

}