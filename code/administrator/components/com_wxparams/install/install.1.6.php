<?php
/**
 * @version     $Id: install.1.6.php 49 2011-03-28 23:04:49Z stiandidriksen $
 * @category    Koowa
 * @package     Koowa_Components
 * @subpackage  Extensions
 * @copyright   Copyright (C) 2010 Timble CVBA and Contributors. (http://www.timble.net)
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */

defined('_JEXEC') or die('Restricted access');

// Prevent the plugin row to be inserted more than once
$query = "SELECT COUNT(*) FROM `#__extensions` WHERE type = 'plugin' AND folder = 'system' AND element = 'wxparams'";
$database->setQuery($query);
if(!$database->loadResult())
{
    // Insert and publish the plugin
    $database->setQuery("INSERT INTO `#__extensions` (`extension_id`, `name`, `type`, `element`, `folder`, `enabled`) VALUES (NULL, 'System - WxParams', 'plugin', 'wxparams', 'system', 1);");
    if (!$database->query()) {
        // Install failed, roll back
        $this->parent->abort(JText::_('Plugin').' '.JText::_('Install').': '.$database->stderr(true));
        return false;
    }
}