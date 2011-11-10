<?php
/**
 * @version 1.0 $Id: defaultable.php 297 2011-11-07 09:40:54Z amazeika $
 * @package com_wextend
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 */

/**
 * Database defaultable behavior.
 * 
 * Requires a column named default capable of storing integer values (0: not default, 1: default).
 *  
 * @author Arunas Mazeika
 * @package com_wextend
 */
class ComWxparamsIncludeDatabaseBehaviorDefaultable extends KDatabaseBehaviorAbstract
{
	
	/**
	 * Override this method for adding a customized WHERE clause.
	 * 
	 * @param KDatabaseQuery KDatabaseQuery object.
	 */
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
	}
	
	public function _beforeTableInsert(KCommandContext $context)
	{
	    $row = $context->data;
		if($row->default) {
			// Before inserting a new row as the default one, we need to remove the default
			// property from any other concerned row
			$this->_resetDefaults($context);
		} else {
			// A default row must exists !. We should check if at least one row is set as default
			$table = $context->caller;
			$db = $table->getDatabase();
			$query = $db->getQuery();
			// Build the where clause
			$this->_buildQueryWhere($query);
			$select = 'SELECT COUNT(*) FROM `#__' . $context->table . '`';
			$select .= (string) $query;
			$result = (int) $db->select($select, KDatabase::FETCH_FIELD);
			if($result === 0) {
				// Setting the current row as the default one
				$row->default = 1;
			}
		}
	}
	
	protected function _beforeTableUpdate(KCommandContext $context)
	{
		$row = $context->data;
		if(in_array('default', $row->getModified()) && $row->default) {
			// Before updating a row and setting it as the default one, we need to remove the default
			// property from any other concerned row
			$this->_resetDefaults($context);
		}
	}
	
	/**
	 * Reset the default state on every row.
	 * 
	 * @param KCommandContext The command context object.
	 */
	protected function _resetDefaults(KCommandContext $context)
	{
		$table = $context->caller;
		$db = $table->getDatabase();
		$query = $db->getQuery();
		// Build the where clause
		$this->_buildQueryWhere($query);
		// Making the query a little bit more specific
		$query->where('default', '=', 1);
		$db->update($context->table, array('default' => 0), $query);
	}
	
	protected function _afterTableDelete(KCommandContext $context)
	{
		$row = $context->data;
		if($row->default) {
			// A new row should be set as the default one.
			$this->_setDefault($context);
		}
	}
	
	/**
	 * Sets an arbitrary row as default.
	 * 
	 * @param KCommandContext The command context object.
	 */
	protected function _setDefault(KCommandContext $context)
	{
		$table = $context->caller;
		$db = $table->getDatabase();
		$query = $db->getQuery();
		// Build the where clause
		$this->_buildQueryWhere($query);
		$select = 'SELECT * FROM `#__' . $context->table . '`';
		$select .= (string) $query;
		// Check for a result
		if($result = $db->select($select, KDatabase::FETCH_ROW)) {
			// Initialize the query object
			$query = $db->getQuery();
			foreach($result as $key => $value) {
				$query->where($key, '=', $value);
			}
			// Set the resulting row as the default one
			$db->update($context->table, array('default' => 1), $query);
		}
	}
}

