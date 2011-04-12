<?php

class ComWxparamsViewConfigurationHtml extends ComWxparamsViewHtml {
	
	public function display() {
		
		$toolbar = KFactory::get( 'admin::com.wxparams.toolbar.configuration' )->setTitle( WxText::_( 'WXPARAMS_CONFIGURATION' ) );
		
		$model = $this->getModel();
		$state = $model->getState();
		
		// Get the package name
		if ($state->isUnique()) {
			$row = $model->getItem();
			$package = $row->package;
		} else {
			// Get the package value from the session
			if (! $package = KRequest::get( 'session.com.wxparams.package', 'cmd' )) {
				throw new KViewException( 'Unable to determine the package name.' );
			}
		}
		
		if ($state->isUnique()) {
			// Bind the parameters and render the form.
			$form = WxparamsFactory::getForm( $row->getParams() );
		} else {
			// Just render the form.
			$form = WxparamsFactory::getForm();
		}
		
		$this->assign( 'package', $package );
		$this->assign( 'form', $form );
		$this->assign( 'toolbar', $toolbar );
		
		return parent::display();
	}

}