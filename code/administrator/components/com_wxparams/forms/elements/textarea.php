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
 * Textarea form element.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsFormElementTextarea extends KFormElementAbstract {
	
	/**
	 * Valid attributes for the element
	 *
	 * @var array	Array of strings
	 */
	protected $_validAttribs = array ('disabled', 'maxlength', 'placeholder', 'readonly', 'size', 'accesskey', 'class', 'dir', 'id', 'lang', 'style', 'tabindex', 'title', 'xml:lang' );
	
	public function renderDomElement(DOMDocument $dom) {
		$elem = $dom->createElement( 'textarea' );
		$elem->setAttribute( 'name', $this->getName() );
		$elem->appendChild( $dom->createTextNode( $this->getValue() ) );
		$elem->setAttribute( 'id', $this->getName() . '_id' );
		$elem->setAttribute( 'class', 'value' );
		
		foreach ( $this->getAttributes() as $key => $val ) {
			$elem->setAttribute( $key, $val );
		}
		
		return $elem;
	}

}