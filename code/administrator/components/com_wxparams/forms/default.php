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
 * Default form class.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsFormDefault extends KFormDefault
{
	
	protected $_package;
	protected $_type;
	protected $_values;
	
	public function __construct(KConfig $config = null)
	{
		if(!$config) {
			$config = new KConfig();
		}
		parent::__construct($config);
		
		$this->_package = $config->package;
		$this->_type = $config->type;
		$this->_values = $config->params;
	}
	
	protected function _initialize(KConfig $config)
	{
		$config->append(array('package' => null, 'type' => null, 'params' => null));
		parent::_initialize($config);
	}
	
	public function getPackage()
	{
		return $this->_package;
	}
	
	public function getType()
	{
		return $this->_type;
	}
	
	/**
	 * Returns the form behaviors.
	 * 
	 * @return array A list of controller behavior identifiers.
	 */
	public function getBehaviors()
	{
		$attributes = $this->_xml->attributes();
		if(!empty($attributes['behaviors'])) {
			return explode(',', $attributes['behaviors']);
		}
		return null;
	}
	
	/**
	 * Process the XML form for use with com_wxparams. An optional params variable can be provided for
	 * changing default values of the form elements.
	 * 
	 * @param SimpleXMLElement $xml The XML form.
	 */
	protected function processXml(SimpleXMLElement $xml)
	{
		
		foreach($xml->xpath('//*[@name]') as $element) {
			$attributes = $element->attributes();
			if($this->_values && $this->_values->{(string) $attributes->name}) {
				// Bind parameter value
				$value = KConfig::unbox($this->_values->{(string) $attributes->name});
				// Array values are imploded using commas.
				$value = is_array($value) ? implode(',', $value) : $value;
				$element->addAttribute('value', $value);
			}
		}
	}
	
	/**
	 * Imports the XML form.
	 * 
	 * @return ComWxparamsFormDefault The form object.
	 */
	public function importXml(SimpleXMLElement $xml)
	{
		
		$this->processXml($xml);
		
		return parent::importXml($xml);
	}
	
	/**
	 * Returns the default values.
	 * 
	 * @return array Associative array containing the name and the default value of each element.
	 */
	public function getDefaults()
	{
		
		$defaults = array();
		
		foreach($this->_xml->xpath('//*[@default]') as $element) {
			$attributes = $element->attributes();
			$default = (string) $attributes->default;
			if($attributes->multiple == 'multiple') {
				// Return an array of values
				$default = explode(',', $default);
			}
			$defaults[(string) $attributes->name] = $default;
		}
		
		return $defaults;
	
	}
	
	/**
	 * Render the form as a DOM object
	 *
	 * @return DOMDocument The DOM document.
	 */
	public function renderDom()
	{
		
		$dom = new DOMDocument();
		
		foreach($this as $element) {
			
			if($dom_label = $element->renderDomLabel($dom)) {
				$dom->appendChild($dom_label);
			}
			
			if($dom_element = $element->renderDomElement($dom)) {
				$dom->appendChild($dom_element);
			}
		
		}
		
		return $dom;
	}
	
	/**
	 * Render the form as HTML.
	 *
	 * @return string The HTML document.
	 */
	public function renderHtml()
	{
		
		$dom = $this->renderDom();
		
		$string = $dom->saveHTML();
		
		return str_replace('<', PHP_EOL . '<', $string);
	}

}