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
 * Editor form element.
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
	protected $_validAttribs = array('id', 'editor', 'width', 'height', 'cols', 'rows', 'buttons', 'options'
	);
	
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
		$this->_attribs = KConfig::toData($config->options);
	
	}
	
	protected function _initialize(KConfig $config)
	{
		$config->append(
			array(
				'options' => array(
					'editor' => null, 
					'width' => '750', 
					'height' => '100', 
					'cols' => '75', 
					'rows' => '20', 
					'buttons' => true, 
					'options' => array()
				)
			));
		parent::_initialize($config);
	}
	
	public function renderDomElement(DOMDocument $dom)
	{
		
		$elem = $dom->createElement('div');
		$elem->setAttribute('class', 'editor');
		
		$fragment = $dom->createDocumentFragment();
		
		$config = new KConfig($this->getAttributes());
		
		$editor = KFactory::get('lib.joomla.editor', array($config->editor
		));
		
		$html = $editor->display($this->getName(), $this->getDefault(), $config->width, $config->height, 
			$config->cols, $config->rows, $config->buttons, $config->options);
		
		// Input filtering.
		$patterns = array('/<!--.*?-->/', '/id="params\[(.*?)\]"/'
		);
		$replacements = array('', 'id="$1"'
		);
		$html = preg_replace($patterns, $replacements, $html);
		
		$fragment->appendXML($html);
		
		$elem->appendChild($fragment);
		
		return $elem;
	}
}