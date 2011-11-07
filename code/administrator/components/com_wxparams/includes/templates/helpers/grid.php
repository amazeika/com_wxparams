<?php
/**
 * @version 1.0 $Id: defaultable.php 297 2011-11-07 09:40:54Z amazeika $
 * @package com_wextend
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 */
class ComWxparamsIncludeTemplateHelperGrid extends KTemplateHelperGrid
{
	/**
	 * Returns one or more grid layouts at once. Useful to groupe different actions in one unique container.
	 * 
	 * @param array $config The configuration array.
	 */
	public function actions($config = array())
	{
		
		$config = new KConfig($config);
		$html = '<div class="wx-actions">';
		foreach($config->actions as $action) {
			if(is_callable(array($this, $action))) {
				$html .= $this->$action($config);
			}
		}
		$html .= '</div>';
		return $html;
	}
	
	public function edit($config = array())
	{
		$config = new KConfig($config);
		
		$option = KRequest::get('get.option', 'cmd');
		$view = KInflector::singularize(KRequest::get('get.view', 'cmd'));
		$url = 'index.php?option=' . $option . '&view=' . $view . '&id=' . $config->row->id;
		
		return '<a title="' . WxText::_('WX_EDIT') . '" href="' . $url . '"><span class="icon-16-edit"/></a>';
	
	}
	
	public function defaultable($config = array())
	{
		
		$config = new KConfig($config);
		
		$html = '';
		
		if($config->row->default) {
			$html .= '<a title="' . WxText::_('WX_DEFAULT') . '"><span class="icon-16-default"></span></a>';
		
		} else {
		    $title = WxText::_('WX_SET_DEFAULT');
		    $data = '{default: 1}';
		    $html .= '<a class="wx-cursor" title="'.$title.'" data-action="edit" data-data="'.$data.'"><span class="icon-16-setdefault"></span></a>';
		    	
		}
		
		return $html;
	
	}

}