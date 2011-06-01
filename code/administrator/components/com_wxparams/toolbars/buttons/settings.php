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
		
		// Push the jQuery & Colorbox libs, and the CSS file of com_wxparams to the document. Right now the only way
		// is using JDocument, after the toolbar re-factoring this should be possible using Nooku only. TODO.
		$document = KFactory::get('lib.joomla.document');
		if($config->jquery) {
			// Add jQuery
			$document->addScript(WxHelperUri::absolutize('media/com_wextend/js/libraries/jquery/jquery.js'));
		}
		if($config->colorbox) {
			// Add colorbox
			$document->addScript(WxHelperUri::absolutize('media/com_wextend/js/libraries/colorbox/jquery.colorbox-min.js'));
			$document->addStyleSheet(WxHelperUri::absolutize('media/com_wextend/js/libraries/colorbox/style1/colorbox.css'));
		}
		$document->addStyleSheet(WxHelperUri::absolutize('media/com_wxparams/css/admin.css'));
	}
	
	protected function _initialize(KConfig $config)
	{
		// By default, both the package and type are taken from the request. The type is always singularized
		// by default. If another view (plural for example) is required, this value can be overriden at the
		// time the button is instantiated.
		$config->append(array(
			'config_package' => KRequest::get('get.option', 'cmd'), 
			'config_type' => 'view.' . KInflector::singularize(KRequest::get('get.view', 'cmd')), 
			'jquery' => true, 
			'colorbox' => true));
		parent::_initialize($config);
	}
	
	public function getAttribs()
	{
		if($onlick = $this->getOnClick()) {
			$this->_options->attribs->append(array('onclick' => $onlick));
		}
		
		if($link = $this->getLink()) {
			$this->_options->attribs->append(array('href' => $link));
		}
		
		return parent::getAttribs();
	}
	
	public function getOnClick()
	{
		
		return 'wxjq(this).colorbox({width: \'95%\', height: \'95%\', iframe: true}); return false;';
	
	}
	
	public function getLink()
	{
		return 'index.php?option=com_wxparams&package=' . $this->_config_package . '&type=' . $this->_config_type;
	}
}