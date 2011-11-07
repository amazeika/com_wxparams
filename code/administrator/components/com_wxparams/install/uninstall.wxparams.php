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
$jversion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';

//Run platform specific procedures
require JPATH_ROOT . '/administrator/components/com_' . $package . '/install/uninstall.' . $jversion . '.php';

// Delete framework folders
foreach ($manifest->framework->folder as $folder)
{
    if(JFolder::exists(JPATH_ROOT.$folder)) JFolder::delete(JPATH_ROOT.$folder);
}
// Delete framework files
foreach ($manifest->framework->file as $file)
{
    if(JFile::exists(JPATH_ROOT.$file)) JFile::delete(JPATH_ROOT.$file);
}