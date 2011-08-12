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

// Forcing component rendering only
KRequest::set('get.tmpl', 'component');

echo KFactory::get('admin::com.wxparams.dispatcher')->dispatch();