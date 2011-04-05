<?php

class ComWxparamsFormDefault extends KFormDefault {
	
	protected function processXml(SimpleXMLElement $xml, $params) {

		foreach ($params as $key => $value) {
			// Look for the corresponding XML element
			$element = $xml->xpath('//*[@name="form['.$key.']"]');
			// Insert the current value as the default
			$element[0]['default'] = $value;
		}
			
	}
	
	public function importXml(SimpleXMLElement $xml, $params = null) {
		
		if ($params) {
			// Bind params
			$this->processXml( $xml, $params );
		}
		return parent::importXml( $xml );
	}
	
	/**
	 * Render the form as a DOM object
	 *
	 * @return	DOMDocument
	 */
	public function renderDom() {
		
		$dom = new DOMDocument();
		
		foreach ( $this as $element ) {
			
			if ($dom_label = $element->renderDomLabel( $dom )) {
				$dom->appendChild( $dom_label );
			}
			
			if ($dom_element = $element->renderDomElement( $dom )) {
				$dom->appendChild( $dom_element );
			}
		
		}
		
		return $dom;
	}
	
	/**
	 * Render the form as HTMl
	 *
	 * @return	string	Html
	 */
	public function renderHtml() {
		
		$dom = $this->renderDom();
		
		// Setting validators, pre and post data processors
		foreach ( $this->_xml->attributes() as $key => $value ) {
			switch ($key) {
				case 'validator' :
				case 'preprocessor' :
				case 'postprocessor' :
					$element = $dom->createElement( 'input' );
					$element->setAttribute( 'type', 'hidden' );
					$element->setAttribute( 'name', $key );
					$element->setAttribute( 'value', $value );
					$dom->appendChild( $element );
					break;
			}
		}
		
		$form = $dom->getElementsByTagName( 'form' )->item( 0 );
		$string = $dom->saveXml( $form );
		
		return str_replace( '<', PHP_EOL . '<', $string );
	}

}