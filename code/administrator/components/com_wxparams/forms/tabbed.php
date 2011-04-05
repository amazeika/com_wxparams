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
			
			$inner_div = $dom->createElement( 'div' );
			$outer_div->appendChild( $inner_div );
			if ($element instanceof ComWxparamsFormElementTab) {
				// Each fieldset represents a tab that groups elements inside of it
				$li = $dom->createElement( 'li' );
				$a = $dom->createElement( 'a' );
				$a->setAttribute( 'href', '#tabs-' . $i );
				$label = $element->getLabel();
				$a->appendChild( $dom->createTextNode( $label ['label'] ) );
				$li->appendChild( $a );
				$ul->appendChild( $li );
				$inner_div->setAttribute( 'id', 'tabs-' . $i );
			}
			
			if ($dom_label = $element->renderDomLabel( $dom )) {
				$inner_div->appendChild( $dom_label );
			}
			
			if ($dom_element = $element->renderDomElement( $dom )) {
				$inner_div->appendChild( $dom_element );
			}
			
			$i ++;
		
		}
		
		return $dom;
	}

}