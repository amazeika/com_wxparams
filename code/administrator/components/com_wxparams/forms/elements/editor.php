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
 * Editor form element class.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsFormElementEditor extends KFormElementAbstract
{
	
	/**
	 * Valid attributes for the element
	 *
	 * @var array	Array of strings
	 */
	protected $_validAttribs = array();
	
	/**
	 * Constructor.
	 * 
	 * @param KConfig An option configuration object.
	 */
	public function __construct(KConfig $config = null)
	{
		if(!$config) {
			$config = new KConfig();
		}
		
		parent::__construct($config);
		
		// Default attribute values
		$this->_attribs = KConfig::unbox($config->options);
	
	}
	
	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'options' => array(
				'editor' => null, 
				'width' => '750', 
				'height' => '100', 
				'cols' => '75', 
				'rows' => '20', 
				'buttons' => true, 
				'options' => array())));
		parent::_initialize($config);
	}
	
	/**
	 * Override for wraping element names in an array for avoiding naming conflicts.
	 *
	 * @return string The element name.
	 */
	public function getName()
	{
		return 'params[' . $this->_name . ']';
	}
	
	public function renderDomElement(DOMDocument $dom)
	{
		
		$elem = $dom->createElement('div');
		$elem->setAttribute('class', 'editor');
		
		$fragment = $dom->createDocumentFragment();
		
		$config = new KConfig($this->getAttributes());
		
		$editor = JFactory::getEditor($config->editor);
		
		$html = $editor->display($this->getName(), htmlspecialchars($this->getValue(), ENT_QUOTES), $config->width, $config->height, $config->cols, $config->rows, $config->buttons, $config->options);
		
		// Input filtering and setting of id and name attributes.
		$patterns = array('/<!--.*?-->/', '/id="(.*?)"/');
		$id = (string) isset($this->_xml['id']) ? $this->_xml['id'] : '$1';
		$replacements = array('', 'id="' . $id . '"');
		$html = preg_replace($patterns, $replacements, $html);
		
		$fragment->appendXML($html);
		
		$elem->appendChild($fragment);
		
		return $elem;
	}
}