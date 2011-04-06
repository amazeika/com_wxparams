<?php

class ComWxparamsTemplateHelperAdapterListboxJ16 extends ComWxparamsTemplateHelperAdapterListboxAbstract {

	public function menuitems($config = array()) {
		
		$config = new KConfig($config);
		
		$config->append( array ('model' => 'menus', 'name' => 'item_id', 'value' => 'id', 'text' => 'title' ) );
		
		return parent::_listbox( $config );
		
	}
	
}