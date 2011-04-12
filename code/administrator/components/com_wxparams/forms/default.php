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
 * Default form.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsFormDefault extends KFormDefault {
	
	/**
	 * Process the XML form for use with com_wxparams. Form elements are enclosed in an array
	 * for avoiding naming conflicts. An optional params variable can be provided for changing
	 * the default values of the form elements.
	 * 
	 * @param SimpleXMLElement $xml The XML form.
	 * @param Array $params An associative array with data to be binded with the XML form.
	 */
	protected function processXml(SimpleXMLElement $xml, $params = null) {
		
		foreach ( $xml->xpath( '//*[@name]' ) as $element ) {
			$attributes = $element->attributes();
			if ($params) {
				// Bind params
				$attributes->default = $params [( string ) $attributes->name];
			}
			// Change the element's name
			$attributes->name = 'params[' . ( string ) $attributes->name . ']';
		}
	}
	
	/**
	 * Imports the XML form.
	 * 
	 * @return ComWxparamsFormDefault The form object.
	 */
	public function importXml(SimpleXMLElement $xml, $params = null) {
		
		$this->processXml( $xml, $params );
		
		return parent::importXml( $xml );
	}
	
	/**
	 * Returns the default values.
	 * 
	 * @return array Associative array containing the name and the default value of each element.
	 */
	public function getDefaults() {
		
		$defaults = array ();
		
		foreach ( $this->_xml->xpath( '//*[@default]' ) as $element ) {
			$attributes = $element->attributes();
			preg_match( '/params\[(.*?)\]/', $attributes->name, $results );
			$name = $results [1];
			$defaults [$name] = ( string ) $attributes->default;
		}
		
		return $defaults;
	
	}
	
	/**
	 * Render the form as a DOM object
	 *
	 * @return DOMDocument The DOM document.
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
	 * Render the form as HTML.
	 *
	 * @return string The HTML document.
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