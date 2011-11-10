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
 * Checkbox form element class.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsFormElementCheckbox extends KFormElementCheckbox
{
	/**
	 * Override for wraping element names in an array for avoiding naming conflicts.
	 *
	 * @return string The element name.
	 */
	public function getName()
	{
		return 'params[' . $this->_name . ']';
	}
	
	/**
	 * Method override for option name cleanup on checklist context.
	 * 
	 * @see KFormElementAbstract::setName()
	 */
	public function setName($name)
	{
		if(preg_match('/params\[(.*?)\]/', $name, $result)) {
			$name = $result[1];
		}
		return parent::setName($name);
	}
}