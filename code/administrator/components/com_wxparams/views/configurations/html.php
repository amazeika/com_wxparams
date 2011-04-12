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

class ComWxparamsViewConfigurationsHtml extends ComWxparamsViewHtml {
	
	public function display() {
		
		$toolbar = KFactory::get('admin::com.wxparams.toolbar.configurations')->append('edit');
		
		$this->assign('toolbar',$toolbar);
		
		return parent::display();
		
	}
	
}