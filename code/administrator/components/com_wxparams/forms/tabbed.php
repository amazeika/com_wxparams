<?php

class ComWxparamsFormTabbed extends ComWxparamsFormDefault {
	
	/**
	 * Render the form as a DOM object
	 *
	 * @return	DOMDocument
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