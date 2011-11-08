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
 * Configurations toolbar.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsControllerToolbarConfigurations extends ComDefaultControllerToolbarDefault
{
	
	public function __construct(KConfig $config)
	{
		if(!$config) {
			$config = new KConfig();
		}
		
		$title = JText::_('WXPARAMS_CONFIGURATIONS');
		// Determine the toolbar title
		$type = KRequest::get('get.type', 'cmd', '');
		if($pos = strpos($type, '.')) {
			// View config
			$title .= ' - ' . JText::_('WXPARAMS_VIEW') . ': ' . ucfirst(substr($type, $pos + 1));
		} else {
			// Global config
			$title .= ' - ' . JText::_('WXPARAMS_GLOBAL');
		}
		
		$this->setTitle($title);
		
		$this->setIcon('configurations');
	}
	
	protected function _commandSettings(KControllerToolbarCommand $command, $config = array())
	{
		
		$config = new KConfig($config);
		
		$config->append(array(
			'package' => KRequest::get('get.option', 'cmd'), 
			'type' => 'view.' . KRequest::get('get.view', 'cmd')));
		
		$command->append(array(
			
			'attribs' => array(
				
				'href' => 'index.php?option=com_wxparams&view=configurations&package=' . $config->package . '&type=' . $config->type, 
				'onclick' => 'wxjq(this).colorbox({width: \'95%\', height: \'95%\', iframe: true}); return false;')));
		
		$document = JFactory::getDocument();
		$document->addStyleSheet(WxHelperUri::absolutize('media/com_wxparams/css/wxparams.css'));
	}

}
