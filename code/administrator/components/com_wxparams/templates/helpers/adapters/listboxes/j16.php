<?php

class ComWxparamsTemplateHelperAdapterListboxJ16 extends ComWxparamsTemplateHelperAdapterListboxAbstract {

	public function menuitems($config = array()) {
		
		$config = new KConfig($config);
		
		$config->append( array ('text' => 'title' ) );
		
		return parent::menuitems( $config );
		
	}
	
}