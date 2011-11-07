<?php

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