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
 * J!1.6 listbox template helper class.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsTemplateHelperListboxJ16 extends ComWxparamsTemplateHelperListboxAbstract
{
	
	public function menuitems($config = array())
	{
		
		$config = new KConfig($config);
		
		$config->append(array('text' => 'title'));
		
		return parent::menuitems($config);
	
	}

}