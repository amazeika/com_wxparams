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

class ComWxparamsViewConfigurationsHtml extends ComWxparamsViewHtml
{
	
	public function display()
	{
		// Determine the title for the view
		$type = $this->getModel()
			->getState()->type;
		$title = WxText::_('WXPARAMS_CONFIGURATIONS');
		if($pos = strpos($type, '.')) {
			// View config
			$title .= ' - ' . WxText::_('WXPARAMS_VIEW') . ': ' . ucfirst(substr($type, $pos + 1));
		} else {
			// Global config
			$title .= ' - ' . WxText::_('WXPARAMS_GLOBAL');
		}
		
		$toolbar = KFactory::get('admin::com.wxparams.toolbar.configurations')->setTitle($title)
			->append('edit');
				
		return parent::display();
	
	}

}