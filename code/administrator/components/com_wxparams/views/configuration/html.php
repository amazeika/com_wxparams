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
			$identifier = ( string ) $model->getIdentifier();
			if (! $package = KRequest::get( "session.{$identifier}.package", 'cmd' )) {
				throw new KViewException( 'Unable to determine the package name.' );
			}
		}

		$xml = new SimpleXMLElement( file_get_contents( JPATH_ROOT . '/media/' . $package . '/config/' . $package . '.xml' ) );
		
		if ($state->isUnique()) {
			// Bind the parameters and render the form.
			$form = WxparamsFactory::getForm( $xml, json_decode( $row->params ) );
		} else {
			// Just render the form.
			$form = WxparamsFactory::getForm( $xml );
		}
		
		$this->assign( 'package', $package );
		$this->assign( 'form', $form );
		$this->assign( 'toolbar', $toolbar );
		
		return parent::display();
	}

}