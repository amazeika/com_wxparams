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
		//KFactory::get('admin::com.wxparams.toolbar.configuration')->setTitle('WXPARAMS_CONFIGURATION');
		
		$model = $this->getModel();
		$this->assign('form', WxparamsFactory::getForm(array(
			'params' => $model->getItem()
				->getParams())));
		
		// Load the language file
		KFactory::get('lib.joomla.language')->load($this->form->getPackage());
		
		return parent::display();
	}

}