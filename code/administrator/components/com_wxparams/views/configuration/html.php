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
 * Configuration HTML view.
 *
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsViewConfigurationHtml extends ComWxparamsViewHtml
{
	public function display()
	{
		$model = $this->getModel();
		// Get package and type information from the session.
		$session = ComWxparamsHelperSession::getModelState();
		$this->assign('package', $session['package']);
		$this->assign('type', $session['type']);
		$this->assign('form', ComWxparamsFactory::getForm(array(
			'package' => $this->package, 
			'type' => $this->type, 
			'params' => $model->getItem()
				->getParams())));
		
		// Load the language file
		JFactory::getLanguage()->load($this->package);
		
		return parent::display();
	}

}