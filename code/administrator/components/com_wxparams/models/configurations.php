<?php

class ComWxparamsModelConfigurations extends KModelDefault {
	
	public function __construct(KConfig $config = null) {
		
		if (! $config) {
			$config = new KConfig();
		}
		
		parent::__construct( $config );
		
		$state = $this->getState();
		$state->insert( 'package', 'cmd' );
		$state->insert( 'default', 'int' );
	
	}
	
	protected function _initialize(KConfig $config) {
		$config->append( array ('table_behaviors' => array ('admin::com.wxparams.database.behavior.configurationsdefaultable', 'lockable' ) ) );
		parent::_initialize( $config );
	}
	
	protected function _buildQueryWhere(KDatabaseQuery $query) {
		
		$state = $this->getState();
		
		if ($state->package) {
			$query->where( 'package', '=', $state->package );
		}
		
		if ($state->default == 1) {
			$query->where( 'default', '=', 1 );
		}
		
		parent::_buildQueryWhere( $query );
	
	}

}