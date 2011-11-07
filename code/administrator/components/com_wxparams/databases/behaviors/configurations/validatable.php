<?php
/**
 * @version 1.0 $Id$
 * @package com_wxparams
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 */

/**
 * Validatable behavior.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsDatabaseBehaviorConfigurationValidatable extends ComWextendDatabaseBehaviorValidatable
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