<?php
class ComWxparamsControllerBehaviorProcessable extends ComWextendControllerBehaviorProcessable
{
	protected function _processParams()
	{
		// Parameters are JSON encoded for DB storage.
		$this->params = json_encode($this->params->toArray());
		// Remove Line Feed (LF) and Return Carriage (RC) chars.
		$this->params = str_replace(array('\n', '\r'), '', $this->params);
	}
}