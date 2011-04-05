<?php

class ComWxparamsFormElementHidden extends KFormElementAbstract {
	/**
	 * Valid attributes for the element
	 *
	 * @var array	Array of strings
	 */
	protected $_validAttribs = array ('id' );
	
	public function renderDomElement(DOMDocument $dom) {
		
		$elem = $dom->createElement( 'input' );
		$elem->setAttribute( 'name', $this->getName() );
		$elem->setAttribute( 'value', $this->getValue() );
		$elem->setAttribute( 'type', 'hidden' );
		$elem->setAttribute( 'id', $this->getName() . '_id' );
		
		foreach ( $this->getAttributes() as $key => $val ) {
			$elem->setAttribute( $key, $val );
		}
		
		return $elem;
	
	}
	
	public function renderDomLabel(DOMDocument $dom) {
		// No labels
		return false;
	}

}