<?php

class ComWxparamsControllerToolbarConfigurations extends ComDefaultControllerToolbarDefault
{
	
	public function __construct(KConfig $config)
	{
		if(!$config) {
			$config = new KConfig();
		}
		
		$title = WxText::_('WXPARAMS_CONFIGURATIONS');
		// Determine the toolbar title
		$type = KRequest::get('get.type', 'cmd', '');
		if($pos = strpos($type, '.')) {
			// View config
			$title .= ' - ' . WxText::_('WXPARAMS_VIEW') . ': ' . ucfirst(substr($type, $pos + 1));
		} else {
			// Global config
			$title .= ' - ' . WxText::_('WXPARAMS_GLOBAL');
		}
		
		$this->setTitle($title);
	}
	
	protected function _commandSettings(KControllerToolbarCommand $command, $config = array())
	{
		
		$config = new KConfig($config);
		
		$config->append(array(
			'package' => KRequest::get('get.option', 'cmd'), 
			'type' => 'view.' . KRequest::get('get.view', 'cmd')));
		
		$command->append(array(
			
			'attribs' => array(
				
				'href' => 'index.php?option=com_wxparams&view=configurations&package=' . $config->package . '&type=' . $config->type, 
				'onclick' => 'wxjq(this).colorbox({width: \'95%\', height: \'95%\', iframe: true}); return false;')));
		
		$document = JFactory::getDocument();
		$document->addStyleSheet(WxHelperUri::absolutize('media/com_wxparams/css/admin.css'));
	}

}