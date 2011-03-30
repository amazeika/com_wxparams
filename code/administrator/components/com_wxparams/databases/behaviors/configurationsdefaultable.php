<?php

class ComWxparamsDatabaseBehaviorConfigurationsdefaultable extends ComWextendDatabaseBehaviorDefaultable {
	
	public function _buildQueryWhere(KDatabaseQuery $query) {
		
		// Sub-class by package
		$query->where( 'package', '=', $this->package );
	
	}

}