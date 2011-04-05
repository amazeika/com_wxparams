<?php

class ComWxparamsControllerConfiguration extends KControllerDefault {
	
	public function __construct(KConfig $config = null) {
		
		if (!$config) {
			$config = new KConfig();
		}
		
		parent::__construct($config);
		
		$this->getCommandChain()->enqueue(KFactory::tmp('admin::com.wxparams.command.preprocessor'));
		
	}
	
}