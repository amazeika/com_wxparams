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
 * Menus table class.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsDatabaseTableMenus extends KDatabaseTableDefault
{
	
	protected function _initialize(KConfig $config)
	{
		$config->append(array('base' => 'menu', 'name' => 'menu'));
		parent::_initialize($config);
	}

}