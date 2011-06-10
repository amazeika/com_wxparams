<?php
class ComWxparamsDatabaseBehaviorValidatable extends ComWextendDatabaseBehaviorValidatable
{
	protected function _validateItemid()
	{
		// Check if there's no other configuration row for the same package and itemid
		$row = $this->getTable()
			->getRow()
			->setData(array('item_id' => $this->item_id, 'package' => $this->package));
		if($row->load() && $row->id != $this->id) {
			$this->_setError(WxText::_('WXPARAMS_ALREADY_EXISTS'));
			return false;
		}
		return true;
	}
}