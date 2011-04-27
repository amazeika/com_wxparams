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

/**
 * Hidden form element
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsFormElementHidden extends KFormElementAbstract
{
	
	/**
	 * Valid attributes for the element
	 *
	 * @var array	Array of strings
	 */
	protected $_validAttribs = array('id'
	);
	
	public function renderDomElement(DOMDocument $dom)
	{
		
		$elem = $dom->createElement('input');
		$elem->setAttribute('name', $this->getName());
		$elem->setAttribute('value', $this->getValue());
		$elem->setAttribute('type', 'hidden');
		$elem->setAttribute('id', $this->getName() . '_id');
		
		foreach($this->getAttributes() as $key => $val) {
			$elem->setAttribute($key, $val);
		}
		
		return $elem;
	
	}
	
	public function renderDomLabel(DOMDocument $dom)
	{
		// No labels
		return false;
	}

}