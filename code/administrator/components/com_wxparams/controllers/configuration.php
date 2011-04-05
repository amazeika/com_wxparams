<?php

class ComWxparamsControllerConfiguration extends KControllerDefault {
	
	public function __construct(KConfig $config = null) {
		
		if (! $config) {
			$config = new KConfig();
		}
		
		parent::__construct( $config );
		
		$command_chain = $this->getCommandChain();
		// Pre-processor needs to be executed prior validation
		$command_chain->enqueue( KFactory::tmp( 'admin::com.wxparams.command.preprocessor' ), KCommand::PRIORITY_HIGH );
		$command_chain->enqueue( KFactory::tmp( 'admin::com.wxparams.command.validator' ) );
	
	}

}