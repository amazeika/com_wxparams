<?php

class ComWxparamsTemplateHelperAdapterListboxJ15 extends KTemplateHelperListbox implements ComWxparamsTemplateHelperListbox {
	
	public function menuitems($config = array()) {
		
		$config = new KConfig( $config );
		
		$config->append( array ('model' => 'menus', 'name' => 'item_id', 'value' => 'id', 'text' => 'name' ) );
		
		return parent::_listbox( $config );
	
	}

}