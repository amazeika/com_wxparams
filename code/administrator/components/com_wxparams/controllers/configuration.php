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
	
	public function __construct(KConfig $config = null)
	{
		
		if(!$config) {
			$config = new KConfig();
		}
		
		parent::__construct($config);
		
		$command_chain = $this->getCommandChain();
		// Pre-processor needs to be executed prior validation
		$command_chain->enqueue(KFactory::tmp('admin::com.wxparams.command.preprocessor'), KCommand::PRIORITY_HIGH);
		$command_chain->enqueue(KFactory::tmp('admin::com.wxparams.command.validator'));
		
		// Enqueue validators, pre and post data processors if necessary. Commands are dinamically enqueued
		// using the available information in the request data.
		if($data = $this->getCommandContext()->data) {
			$needles = array('validator', 'preprocessor', 'postprocessor');
			foreach($needles as $needle) {
				if($identifier = $data->$needle) {
					// Enqueue the command
					$command_chain->enqueue(KFactory::tmp($identifier));
				}
			}
		}
	
	}
	
	protected function _actionBrowse(KCommandContext $context)
	{
		// While the plural view makes use of the model state for determining the package context,
		// other views/classes make use of the package session variable.
		$session_package = KRequest::get('session.com.wxparams.package', 'cmd');
		$state_package = $this->getModel()
			->getState()->package;
		if($session_package != $state_package) {
			// Update the package session variable
			KRequest::set('session.com.wxparams.package', $state_package);
		}
		return parent::_actionBrowse($context);
	}

}