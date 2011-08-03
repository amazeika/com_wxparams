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

class ComWxparamsControllerConfiguration extends ComDefaultControllerDefault
{
	protected function _initialize(KConfig $config)
	{
		$config->append(array('persistable' => true, 'behaviors' => array('validatable', 'processable')));
		parent::_initialize($config);
	}
	
	public function execute($action, KCommandContext $context)
	{
		// Enqueue validators, pre and post data processors if necessary. Commands are dinamically enqueued
		// using the available information in the request data.
		if($data = $context->data) {
			$needles = array('validator', 'preprocessor', 'postprocessor');
			foreach($needles as $needle) {
				if($identifier = $data->$needle) {
					// Enqueue the command
					$this->getCommandChain()
						->enqueue(KFactory::tmp($identifier));
				}
			}
		}
		return parent::execute($action, $context);
	}

}