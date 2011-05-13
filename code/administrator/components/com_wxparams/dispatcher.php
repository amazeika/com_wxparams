<?php
/**
 * @version 1.0 $Id$
 * @package com_wxparams
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 * 
 */

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