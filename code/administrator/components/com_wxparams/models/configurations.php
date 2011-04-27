<?php
/**
 * @version 1.0 $Id$
 * @package com_wxparams
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 * 
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
	
	}
	
	protected function _initialize(KConfig $config)
	{
		$config->append(
			array(
				'table_behaviors' => array(
					'admin::com.wxparams.database.behavior.configurationsdefaultable', 
					'lockable'
				)
			));
		parent::_initialize($config);
	}
	
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		
		$state = $this->getState();
		
		if(is_numeric($state->default)) {
			$query->where('default', '=', $state->default);
		}
		
		parent::_buildQueryWhere($query);
	
	}

}