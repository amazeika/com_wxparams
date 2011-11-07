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
 * Validatable behavior.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsControllerBehaviorValidatable extends ComWxparamsIncludeControllerBehaviorValidatable
{
	protected function _initialize(KConfig $config)
	{
		$config->append(array('mandatory_fields' => array('title', 'package', 'type')));
		parent::_initialize($config);
	}
}