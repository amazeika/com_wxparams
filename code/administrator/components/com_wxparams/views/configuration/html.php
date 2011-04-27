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

class ComWxparamsViewConfigurationHtml extends ComWxparamsViewHtml
{
	
	public function display()
	{
		
		$toolbar = KFactory::get('admin::com.wxparams.toolbar.configuration')->setTitle(
			'WXPARAMS_CONFIGURATION');
		
		$model = $this->getModel();
		$state = $model->getState();
		
		// Get the package name
		if($state->isUnique()) {
			$row = $model->getItem();
			$package = $row->package;
		} else {
			// Get the package value from the session
			if(!$package = KRequest::get('session.com.wxparams.package', 'cmd')) {
				throw new KViewException('Unable to determine the package name.');
			}
		}
		
		$config = array();
		
		if($state->isUnique()) {
			// Bind the parameters to the form data
			$config['params'] = $row->getParams();
		} 
		
		$form = WxparamsFactory::getForm($config);
		
		$this->assign('package', $package);
		$this->assign('form', $form);
		$this->assign('toolbar', $toolbar);
		
		// Load the language file
		KFactory::get('lib.joomla.language')->load($package);
		
		return parent::display();
	}

}