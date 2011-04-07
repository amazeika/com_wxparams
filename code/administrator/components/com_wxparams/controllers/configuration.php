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
		// the singular view makes use of the session.
		$model = $this->getModel();
		// Using the model identifier as both, controllers and views are aware of it.
		$identifier = ( string ) $model->getIdentifier();
		$session_package = KRequest::get( "session.{$identifier}.package", 'cmd' );
		$state_package = $model->getState()->package;
		if ($session_package != $state_package) {
			// Update the package session variable
			KRequest::set( "session.{$identifier}.package", $state_package );
		}
		return parent::_actionBrowse( $context );
	}

}