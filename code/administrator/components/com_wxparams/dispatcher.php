<?php

class ComWxparamsDispatcher extends ComDefaultDispatcher {
	
	public function __construct(KConfig $config = null) {
		if (! $config) {
			$config = new KConfig();
		}
		
		parent::__construct( $config );
		
		// Enqueue validators, pre and post data processors if necessary. Commands are dinamically enqueued
		// using the available information in the request data.
		$data = $this->getData();
		$needles = array ('validator', 'preprocessor', 'postprocessor' );
		foreach ( $needles as $needle ) {
			if (in_array( $needle, $data )) {
				// Enqueue the command
				$this->getCommandChain()->enqueue( KFactory::tmp( $data [$needle] ) );
			}
		}
	
	}
}