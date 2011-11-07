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
 * Configurations model.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsModelConfigurations extends KModelDefault
{
	
	public function __construct(KConfig $config = null)
	{
		
		if(!$config) {
			$config = new KConfig();
		}
		
		parent::__construct($config);
		
		$state = $this->getState();
		$state->insert('default', 'int');
		$state->insert('package', 'cmd');
		$state->insert('type', 'cmd');
	
	}
	
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		
		$state = $this->getState();
		
		if(is_numeric($state->default)) {
			$query->where('default', '=', $state->default);
		}
		
		if($state->package) {
			$query->where('package', '=', $state->package);
		}
		
		if($state->type) {
			$query->where('type', '=', $state->type);
		}
		
		parent::_buildQueryWhere($query);
	}

}