<?php

class ComWxparamsViewHtml extends ComDefaultViewHtml {
	
	public function __construct(KConfig $config) {
		$config->views = array ('configurations' => WxText::_( 'WXPARAMS_CONFIGURATIONS' ) );
		
		parent::__construct( $config );
	}

}