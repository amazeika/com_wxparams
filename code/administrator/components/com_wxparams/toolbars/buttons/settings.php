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

class ComWxparamsToolbarButtonSettings extends KToolbarButtonAbstract
{
	
	public function getOnClick()
	{
		
		return 'wxjq(\'#wxparams_launcher\').colorbox({width: \'95%\', height: \'95%\', iframe: true}); wxjq(\'#wxparams_launcher\').click(); return false;';
	
	}
	
	public function render()
	{
		
		// Get the caller's package
		$package = KRequest::get('get.option', 'cmd', '');
		
		$html = parent::render();
		
		$html = preg_replace('/<span(.*?)class=".*?"/', '<span$1style="background-image: url(\'' .
			 KRequest::root() . '/media/com_wxparams/images/icon-32-settings.png\')"', $html);
		
		$html .= '<a id="wxparams_launcher" href="index.php?option=com_wxparams&package=' . $package . '"></a>';
		
		return $html;
	}

}