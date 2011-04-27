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

class ComWxparamsCommandValidator extends ComWextendCommandValidatorAbstract
{
	
	protected function _initialize(KConfig $config)
	{
		$config->append(array('mandatory_fields' => array('title', 'package')));
		parent::_initialize($config);
	}
	
	protected function validateInput(KCommandContext $context, &$errors)
	{
		
		$data = $context->data;
		
		// Check if a configuration for the provided package and item_id already exists
		$row = $context->caller->getModel()
			->getTable()
			->getRow();
		
		$row->setData(array('package' => $data->package, 'item_id' => $data->item_id));
		
		if($row->load() && KRequest::get('get.id', 'int') != $row->id) {
			$errors[] = WxText::_('WXPARAMS_CONFIGURATION_EXISTS');
			return false;
		}
	}

}