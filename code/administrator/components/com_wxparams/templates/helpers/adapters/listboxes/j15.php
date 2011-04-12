<?php

class ComWxparamsTemplateHelperAdapterListboxJ15 extends ComWxparamsTemplateHelperAdapterListboxAbstract  {
	
	public function menuitems($config = array()) {
		
		$config = new KConfig( $config );
		
		$config->append( array ('text' => 'name' ) );
		
		return parent::menuitems( $config );
	
	}

}