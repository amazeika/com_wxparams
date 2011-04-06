<?php

class ComWxparamsCommandValidator extends ComWextendCommandValidatorAbstract {
	
	protected function _initialize(KConfig $config) {
		$config->append( array ('mandatory_fields' => array ('title', 'package', 'item_id' ) ) );
		parent::_initialize( $config );
	}
	
	protected function validateInput(KCommandContext $context, &$errors) {
		// Nothing to do here.
	}

}