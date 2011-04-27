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

abstract class ComWxparamsTemplateHelperAdapterListboxAbstract extends ComDefaultTemplateHelperListbox implements 
	ComWxparamsTemplateHelperListbox
{
	
	public function packages($config = array())
	{
		
		$config = new KConfig($config);
		
		$config->append(array(
			'model' => 'configurations', 
			'name' => 'package', 
			'value' => 'package', 
			'text' => 'package'));
		
		return parent::_listbox($config);
	
	}
	
	public function menuitems($config = array())
	{
		
		$config = new KConfig($config);
		
		$config->append(array('model' => 'menus', 'name' => 'item_id', 'value' => 'id', 'deselect' => false));
		
		return parent::_listbox($config);
	
	}
	
	public function optionlist($config = array())
	{
		
		$config = new KConfig($config);
		
		if($config->name == 'item_id') {
			// Append the Backend option to the list
			$config->options->append(array(
				$this->option(array('text' => '- ' . WxText::_('WXPARAMS_BACKEND') . ' -', 'value' => 0))));
		}
		
		return parent::optionlist($config);
	
	}

}