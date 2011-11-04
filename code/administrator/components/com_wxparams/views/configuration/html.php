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
		$model = $this->getModel();
		// Get package and type information from the session.
		$session = ComWxparamsHelperSession::getModelState();
		$this->assign('form', ComWxparamsFactory::getForm(array(
			'package' => $session['package'], 
			'type' => $session['type'], 
			'params' => $model->getItem()
				->getParams())));
		
		// Load the language file
		JFactory::getLanguage()->load($this->form->getPackage());
		
		return parent::display();
	}

}