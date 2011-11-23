<?php

class ComWxparamsModelBehaviorMenuJ15 implements ComWxparamsModelBehaviorMenuInterface
{
	
	public function buildQueryWhere(KDatabaseQuery $query, KConfigState $state)
	{
		$query->where('jtbl.option', '=', $state->package);
	}
	
	public function buildQueryJoins(KDatabaseQuery $query)
	{
		$query->join('INNER', 'components AS jtbl', 'jtbl.id = tbl.componentid');
	}

}