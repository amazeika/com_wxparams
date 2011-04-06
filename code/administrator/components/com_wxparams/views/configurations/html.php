<?php

class ComWxparamsViewConfigurationsHtml extends ComWxparamsViewHtml {
	
	public function display() {
		
		$toolbar = KFactory::get('admin::com.wxparams.toolbar.configurations')->append('edit');
		
		$this->assign('toolbar',$toolbar);
		
		return parent::display();
		
	}
	
}