<?php

class ComWxparamsFactory
{
	
	final private function __construct()
	{
	}
	
	/**
	 * Returns a form object.
	 *
	 * @param array $config Optional configuration array.
	 * @return mixed ComWxparamsFormDefault or ComWxparamsFormTabbed depending on the XML form.
	 */
	public static function getForm($config = array())
	{
		$config = new KConfig($config);
		
		$xml = new SimpleXMLElement(file_get_contents(JPATH_ROOT . '/media/' . $config->package . '/config/' . str_replace('.', '/', $config->type) . '/form.xml'));
		
		$config = $config->toArray();
		foreach($xml->children() as $name => $element) {
			// A form is considered as tabbed if every root element is a tab element.
			if($name != 'tab') {
				return KService::get('com://admin/wxparams.form.default', $config)->importXml($xml);
			}
		}
		return KService::get('com://admin/wxparams.form.tabbed', $config)->importXml($xml);
	}

}