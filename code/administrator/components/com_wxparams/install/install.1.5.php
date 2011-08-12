<?php
/**
 * @version     $Id: install.1.5.php 49 2011-03-28 23:04:49Z stiandidriksen $
 * @category    Koowa
 * @package     Koowa_Components
 * @subpackage  Extensions
 * @copyright   Copyright (C) 2010 Timble CVBA and Contributors. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */
defined('_JEXEC') or die('Restricted access');

// Prevent the plugin row to be inserted more than once
$query = "SELECT COUNT(*) FROM `#__plugins` WHERE element = 'wxparams' AND folder = 'system'";
$database->setQuery($query);
if(!$database->loadResult()) {
	// Insert and publish the plugin
	$plugin = JTable::getInstance('plugin');
	$plugin->name = 'System - WxParams';
	$plugin->folder = 'system';
	$plugin->element = 'wxparams';
	$plugin->published = 1;
	if(!$plugin->store()) {
		// Install failed, roll back
		$this->parent->abort(JText::_('Plugin') . ' ' . JText::_('Install') . ': ' . $database->stderr(true));
		return false;
	}
}