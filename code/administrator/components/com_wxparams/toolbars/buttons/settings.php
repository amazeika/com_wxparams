<?php

class ComWxparamsToolbarButtonSettings extends KToolbarButtonAbstract {
	
	public function getOnClick() {
		
		return 'wxjq(\'#wxparams_launcher\').colorbox({width: \'80%\', height: \'80%\', iframe: true}); wxjq(\'#wxparams_launcher\').click(); return false;';
	
	}
	
	public function render() {
		
		// Get the caller's package
		$package = KRequest::get( 'get.option', 'cmd', '' );
		
		$html = parent::render();
		
		$html = preg_replace( '/<span(.*?)class=".*?"/', '<span$1style="background-image: url(\'' . KRequest::root() . '/media/com_wxparams/images/icon-32-settings.png\')"', $html );
		
		$html .= '<a id="wxparams_launcher" href="index.php?option=com_wxparams&package=' . $package . '&tmpl=component&layout=component"></a>';
		
		return $html;
	}

}