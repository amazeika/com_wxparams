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
		parent::__construct($config);
		
		$title = WxText::_('WXPARAMS_CONFIGURATIONS');
		// Determine the toolbar title
		$type = KRequest::get('get.type', 'cmd', '');
		if($pos = strpos($type, '.')) {
			// View config
			$title .= ' - ' . WxText::_('WXPARAMS_VIEW') . ': ' . ucfirst(substr($type, $pos + 1));
		} else {
			// Global config
			$title .= ' - ' . WxText::_('WXPARAMS_GLOBAL');
		}
		
		$this->setTitle($title);
		
		$this->setIcon('configurations');
	}
}