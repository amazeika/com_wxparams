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

// Variable definitions
$database = JFactory::getDBO();
$source = $this->parent->getPath('source');
$manifest = simplexml_load_file($this->parent->getPath('manifest'));
$package = strtolower((string) $manifest->name);
$type = JVersion::isCompatible('1.6.0') ? 'joomla' : 'legacy';

// Move framework folders to their corresponding locations
foreach($manifest->framework->folder as $folder) {
	$from = isset($folder['src']) ? $folder['src'] : $folder;
	JFolder::copy($source . $from, JPATH_ROOT . $folder, false, true);
}

// Move framework files to their corresponding locations
foreach($manifest->framework->file as $file) {
	$folder = JPATH_ROOT . dirname($file);
	if(!JFolder::exists($folder)) JFolder::create($folder);
	JFile::copy($source . $file, JPATH_ROOT . $file);
}

//Run platform specific procedures
require JPATH_ROOT . '/administrator/components/com_' . $package . '/install/install.' . $type . '.php';