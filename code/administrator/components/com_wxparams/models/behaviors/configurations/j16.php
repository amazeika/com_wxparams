<?php

class ComWxparamsModelBehaviorConfigurationJ15 implements ComWxparamsModelBehaviorConfigurationInterface
{
	
	public function buildQueryColumns(KDatabaseQuery $query)
	{
		$query->select(array('tbl.*','jtbl.title AS item_id_title'));
	}
	
	public function buildQueryJoins(KDatabaseQuery $query)
	{
		$query->join('LEFT', 'menu AS jtbl', 'jtbl.id = tbl.item_id');
	}

}