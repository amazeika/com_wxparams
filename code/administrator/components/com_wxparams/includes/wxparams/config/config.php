<?php

class WxparamsConfig extends KObjectArray {
	
	protected $_row = null;
	
	public function __construct(KConfig $config = null) {
		
		if (! $config) {
			$config = new KConfig();
		}
		
		parent::__construct( $config );
		
		$state = array ('package' => $config->package );
		
		$model = KFactory::tmp( 'admin::com.wxparams.model.configurations' );
		
		if (! is_null( $config->item_id )) {
			// There must be an item_id, attempt to get a corresponding configuration object.
			$state ['item_id'] = $config->item_id;
			$row = $model->set( $state )->getItem();
			if ($row->id) {
				$this->_row = $row;
				// Set the data
				$this->setData( $row );
				return $this;
			}
			unset( $state ['item_id'] );
		}
		
		// Default configuration fallback.
		$state ['default'] = 1;
		// getList must be used as the state is not unique.
		$rowset = $model->reset()->set( $state )->getList();
		
		foreach ( $rowset as $row ) {
			$this->_row = $row;
			// Set the data
			$this->setData( $row );
			return $this;
		}
		
		// Configuration not found. Return a configuration default object (containing the default
		// values in the form XML file).
		$this->_data = WxparamsFactory::getForm()->getDefaults();
		return $this;
	}
	
	protected function setData(ComWxparamsDatabaseRowConfiguration $row) {
		$this->_data = json_decode( $row->params, true );
	}
	
	public function save() {
		// The configuration can only be saved if a row for this configuration object exists.
		if ($this->_row instanceof ComWxparamsDatabaseRowConfiguration) {
			$this->_row->params = json_encode( $this->toArray() );
			if ($this->_row->save()) {
				$this->setData( $this->_row );
				return true;
			}
		}
		return false;
	}
	
	public function getRow() {
		return $this->_row;
	}
	
	protected function _initiliaze(KConfig $config) {
		$config->append( array ('item_id' => KRequest::get( 'get.Itemid', 'int' ), 'package' => KRequest::get( 'get.option', 'cmd' ) ) );
		parent::_initialize( $config );
	}

}