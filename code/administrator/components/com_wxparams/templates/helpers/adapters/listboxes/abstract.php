<?php

abstract class ComWxparamsTemplateHelperAdapterListboxAbstract extends ComDefaultTemplateHelperListbox implements ComWxparamsTemplateHelperListbox {
	
	public function packages($config = array()) {
		
		$config = new KConfig( $config );

		$config->append( array ('model' => 'configurations', 'name' => 'package', 'value' => 'package', 'text' => 'package' ) );
		
		return parent::_listbox( $config );
	
	}

}