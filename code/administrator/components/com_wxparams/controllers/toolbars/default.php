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
 * Default toolbar.
 *
 * To be extended by any toolbar exposing setting buttons. The button can be
 * configured by passing and associative array with a key named config
 * containing the settings, e.g.
 * $this->addSettings(array('config'=>array('type'=>'global').
 *
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsControllerToolbarDefault extends ComDefaultControllerToolbarDefault
{
	
	protected function _commandSettings(KControllerToolbarCommand $command)
	{
		// Grab config from command object.
		$config = $command->config;
		
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