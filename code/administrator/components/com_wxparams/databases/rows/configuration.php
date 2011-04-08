<?php

class ComWxparamsDatabaseRowConfiguration extends KDatabaseRowDefault {
	
	public function getParams() {
		return json_decode( $this->params, true );
	}

}