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
 * Tabbed form.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsFormTabbed extends ComWxparamsFormDefault {
	
	/**
	 * Render the form as a DOM object
	 *
	 * @return DOMDocument The DOM document.
	 */
	public function renderDom() {
		
		$dom = new DOMDocument();
		
		$outer_div = $dom->createElement( 'div' );
		$outer_div->setAttribute( 'id', 'tabs' );
		$dom->appendChild( $outer_div );
		$ul = $dom->createElement( 'ul' );
		$outer_div->appendChild( $ul );
		
		$i = 1;

		foreach ( $this as $element ) {
			// Each fieldset represents a tab that groups elements inside of it
			$li = $dom->createElement( 'li' );
			$a = $dom->createElement( 'a' );
			$a->setAttribute( 'href', '#tabs-' . $i );
			$label = $element->getLabel();
			$a->appendChild( $dom->createTextNode( $label ['label'] ) );
			$li->appendChild( $a );
			$ul->appendChild( $li );
					
			if ($dom_element = $element->renderDomElement( $dom )) {
				$dom_element->setAttribute( 'id', 'tabs-' . $i );
				$outer_div->appendChild( $dom_element );
			}
			
			$i ++;
		
		}
		
		return $dom;
	}

}