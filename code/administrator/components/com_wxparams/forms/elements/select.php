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
 * Select form element.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */

class ComWxparamsFormElementSelect extends KFormElementSelect
{
	
	/**
	 * Overrided method that allows for automatic options generation using a pre-defined
	 * model. The following attributes must be set:
	 * 1. options_model: A valid model identifier.
	 * 2. options_label: A row column name to be used as the option label.
	 * 3. options_value: A row column name to be used as the option value.
	 * 
	 * @param SimpleXMLElement $xml
	 */
	public function importXml(SimpleXMLElement $xml)
	{
		$attributes = $xml->attributes();
		
		// See if the options must be generated using a pre-defined model.
		if($options_model = (string) $attributes->options_model) {
			parent::importXml($xml);
			$identifier = clone $this->getIdentifier();
			$identifier->name = 'option';
			$rowset = KFactory::tmp($options_model)->getList();
			$options_label = (string) $attributes->options_label;
			$options_value = (string) $attributes->options_value;
			// Default option
			$option = new SimpleXMLElement('<option />');
			$option->addAttribute('label', ' - ' . WxText::_('WXPARAMS_SELECT') . ' - ');
			$option->addAttribute('value', '');
			$this->addOption(KFactory::tmp($identifier)->importXml($option));
			foreach($rowset as $row) {
				$option = new SimpleXMLElement('<option />');
				$option->addAttribute('label', $row->$options_label);
				$option->addAttribute('value', $row->$options_value);
				$this->addOption(KFactory::tmp($identifier)->importXml($option));
			}
			return $this;
		}
		
		return parent::importXml($xml);
	}

}