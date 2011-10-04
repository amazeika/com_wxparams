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

define('WXPARAMS_INCLUDES', dirname(__FILE__));
define('WXPARAMS', 1);

require_once (WXPARAMS_INCLUDES . '/wxparams/loader/loader.php');
$loader = new WxparamsLoader(array(
	'class_prefix' => 'Wxparams', 
	'lib_path' => WXPARAMS_INCLUDES . '/wxparams/'));
$loader->setAutoload();
