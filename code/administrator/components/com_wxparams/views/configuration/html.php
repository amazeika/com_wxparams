<?php

class ComWxparamsViewConfigurationHtml extends ComWxparamsViewHtml {
	
	public function display() {
		
		$xml = new SimpleXMLElement( file_get_contents( dirname( __FILE__ ) . '/test.xml' ) );

		$model = $this->getModel();
		$state = $model->getState();

		if ($state->isUnique()) {
			$row = $model->getItem();
			$package = $row->package;
			$form = WxparamsFactory::getForm($xml, json_decode($row->params));
		} elseif ($state->package) {
			$package = $state->package;
			$form = WxparamsFactory::getForm($xml);
		} else {
			throw new KViewException('Unable to determine the package name.');
		}

		$this->assign('package',$state->package);
		$this->assign( 'form', $form );
		
		return parent::display();
	}

}