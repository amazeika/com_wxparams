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
	
	protected function _actionBrowse(KCommandContext $context) {
		// While the plural view makes use of the model state for determining the package context,
		// other views/classes make use of the package session variable.
		$session_package = KRequest::get( 'session.com.wxparams.package', 'cmd' );
		$state_package = $this->getModel()->getState()->package;
		if ($session_package != $state_package) {
			// Update the package session variable
			KRequest::set( 'session.com.wxparams.package', $state_package );
		}
		return parent::_actionBrowse( $context );
	}

}