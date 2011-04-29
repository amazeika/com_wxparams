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

defined('KOOWA') or die('Restricted access');

// Load the WeXtend framework
define('WXPATH_ADMINISTRATOR', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_wextend');
require_once WXPATH_ADMINISTRATOR . DS . 'framework' . DS . 'framework.php';
// Load the component framework
require_once dirname(__FILE__) . '/includes/framework.php';

// Forcing component rendering only
KRequest::set('get.tmpl', 'component');

echo KFactory::get('admin::com.wxparams.dispatcher', array('controller' => 'configuration'))->dispatch();