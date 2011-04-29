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

class ComWxparamsToolbarButtonSettings extends KToolbarButtonAbstract
{
	protected $_config_package;
	protected $_config_type;
	
	public function __construct(KConfig $config = null)
	{
		if(!$config) {
			$config = new KConfig();
		}
		parent::__construct($config);
		
		$this->_config_package = $config->config_package;
		$this->_config_type = $config->config_type;
	}
	
	protected function _initialize(KConfig $config)
	{
		// By default, both the package and type are taken from the request. The type is always singularized
		// by default. If another view (plural for example) is required, this value can be overriden at the
		// time the button is instantiated.
		$config->append(array(
			'config_package' => KRequest::get('get.option', 'cmd'), 
			'config_type' => 'view.' . KInflector::singularize(KRequest::get('get.view', 'cmd'))));
		parent::_initialize($config);
	}
	
	public function getOnClick()
	{
		
		return 'wxjq(\'#wxparams_launcher\').colorbox({width: \'95%\', height: \'95%\', iframe: true}); wxjq(\'#wxparams_launcher\').click(); return false;';
	
	}
	
	public function render()
	{
		
		$html = parent::render();
		
		// Replace class by for style to avoid having to include the com_wxparams CSS file in the client code.
		$html = preg_replace('/<span(.*?)class=".*?"/', '<span$1style="background-image: url(\'' .
		 KRequest::root() . '/media/com_wxparams/images/icon-32-settings.png\')"', $html);
		
		$html .= '<a id="wxparams_launcher" href="index.php?option=com_wxparams&package=' .
		 $this->_config_package . '&type=' . $this->_config_type . '"></a>';
		
		return $html;
	}
}