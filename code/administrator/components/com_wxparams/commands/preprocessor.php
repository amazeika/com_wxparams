<?php

class ComWxparamsCommandPreprocessor extends ComWextendCommandProcessorAbstract {
	
	protected function processData(KCommandContext $context) {
		// Parameters are JSON encoded for DB storage.
		$context->data->params = json_encode($context->data->form->toArray());	
	}
	
	
}