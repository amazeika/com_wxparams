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
		$this->assign('toolbar', KFactory::get('admin::com.wxparams.toolbar.configuration')->setTitle('WXPARAMS_CONFIGURATION'));
		
		$model = $this->getModel();
		$config = ($model->getState()
			->isUnique()) ? array('params' => $model->getItem()
			->getParams()) : array();
		$this->assign('form', WxparamsFactory::getForm($config));
		
		// Load the language file
		KFactory::get('lib.joomla.language')->load($this->form->getPackage());
		
		return parent::display();
	}

}