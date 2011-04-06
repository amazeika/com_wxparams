<?php

class ComWxparamsViewConfigurationHtml extends ComWxparamsViewHtml {
	
	public function display() {
		
		$toolbar = KFactory::get( 'admin::com.wxparams.toolbar.configuration' )->setTitle( WxText::_( 'WXPARAMS_CONFIGURATION' ) );
		
		$xml = new SimpleXMLElement( file_get_contents( dirname( __FILE__ ) . '/test.xml' ) );
		
		$model = $this->getModel();
		$state = $model->getState();
		
		if ($state->isUnique()) {
			$row = $model->getItem();
			$package = $row->package;
			$form = WxparamsFactory::getForm( $xml, json_decode( $row->params ) );
		} elseif ($state->package) {
			$package = $state->package;
			$form = WxparamsFactory::getForm( $xml );
		} else {
			throw new KViewException( 'Unable to determine the package name.' );
		}
		
		$this->assign( 'package', $package );
		$this->assign( 'form', $form );
		$this->assign( 'toolbar', $toolbar );
		
		return parent::display();
	}

}