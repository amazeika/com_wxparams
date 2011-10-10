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
 * Tab form element. Wraps child elements inside a div.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsFormElementTab extends KFormElementAbstract
{
	
	/**
	 * Valid attributes for the element
	 *
	 * @var array	Array of strings
	 */
	protected $_validAttribs = array();
	
	protected $_label = array('label', 'description');
	
	public function renderDomElement(DOMDocument $dom)
	{
		
		$div = $dom->createElement('div');
		
		foreach($this->_xml->children() as $name => $xmlElem) {
			
			if($name != 'element') {
				$identifier = clone $this->getIdentifier();
				$identifier->name = $name;
			} else {
				$identifier = (string) $xmlElem['type'];
			}
			
			$element = $this->getService($identifier)->importXml($xmlElem);
			
			// Add the label
			if($dom_label = $element->renderDomLabel($dom)) {
				$div->appendChild($dom_label);
			}
			// Add the element
			if($dom_element = $element->renderDomElement($dom)) {
				$div->appendChild($dom_element);
			}
			// Insert a line break after each element
			$div->appendChild($dom->createElement('br'));
		}
		
		foreach($this->getAttributes() as $key => $val) {
			$div->setAttribute($key, $val);
		}
		
		return $div;
	}
	
	public function renderDomLabel(DOMDocument $dom)
	{
		return false;
	}
}