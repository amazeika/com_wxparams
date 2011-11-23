<?php

class ComWxparamsModelBehaviorMenuJ16 implements ComWxparamsModelBehaviorMenuInterface
{
	
	public function buildQueryWhere(KDatabaseQuery $query, KConfigState $state)
	{
		$query->where('jtbl.name', '=', $state->package);
	}
	
	public function buildQueryJoins(KDatabaseQuery $query)
	{
		$query->join('INNER', 'extensions AS jtbl', 'jtbl.extension_id = tbl.component_id');
	}

}