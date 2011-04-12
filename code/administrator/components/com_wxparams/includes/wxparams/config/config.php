<?php

class WxparamsConfig extends KObjectArray {
	
	protected $_row = null;
	
	public function __construct(KConfig $config = null) {
		
		if (! $config) {
			$config = new KConfig();
		}
		
		parent::__construct( $config );
		
		if ($config->row) {
			$this->_row = $config->row;
		}
		
		$this->_data = KConfig::toData($config->params);
	
	}
	
	public function save() {
		// The configuration can only be saved if a row for this configuration object exists.
		if ($this->_row instanceof ComWxparamsDatabaseRowConfiguration) {
			$this->_row->params = json_encode( $this->toArray() );
			if ($this->_row->save()) {
				$this->_data = $this->_row->getParams();
				return true;
			}
		}
		return false;
	}
	
	public function getRow() {
		return $this->_row;
	}
	
	protected function _initialize(KConfig $config) {
		$config->append( array ('row' => null, 'params' => array () ) );
		parent::_initialize( $config );
	}

}