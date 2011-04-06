<?php

class ComWxparamsToolbarButtonNew extends KToolbarButtonNew {
	
	public function getLink() {
		
		$link = parent::getLink();
		
		$state = KFactory::get( 'admin::com.wxparams.model.configurations' )->getState();
		
		if ($state->package) {
			// Push the state to the singular view.
			$link .= '&package=' . $state->package;
		}
		
		if (KRequest::get( 'get.tmpl', 'cmd', '' ) == 'component') {
			// Push the template as well as the layout to the singular view.
			$link .= '&tmpl=component&layout=component';
		}
		
		return $link;
	
	}

}