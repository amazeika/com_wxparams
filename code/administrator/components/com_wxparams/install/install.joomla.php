<?php
/**
 * @version 1.0 $Id$
 * @package com_wxparams
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 */

defined('_JEXEC') or die('Restricted access');

// Disable com_wxparams so that menu doesn't show in the backend.
$query = "UPDATE `#__extensions` SET `enabled` = '0' WHERE type = 'component' AND element = 'com_wxparams'";
$database->setQuery($query);
$database->query();