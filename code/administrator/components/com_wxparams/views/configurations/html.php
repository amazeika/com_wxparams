<?php

class ComWxparamsViewConfigurationsHtml extends ComWxparamsViewHtml {
	
	public function display() {
		
		KFactory::get('admin::com.wxparams.toolbar.configurations')->append('edit');
		
		return parent::display();
		
	}
	
}