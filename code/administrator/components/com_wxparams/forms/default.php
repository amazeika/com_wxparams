<?php
class ComWxparamsFormDefault extends WxForm
{
	protected $_behaviors;
	
	/**
	 * Returns the form behaviors to be injected in the controller.
	 * 
	 * @return array An array containing controller behavior identifiers.
	 */
	public function getBehaviors()
	{
		if(!$this->_behaviors) {
			$xmlIterator = $this->getXmlIterator();
			$xmlIterator->rewind();
			$behaviors = array();
			$form_attribs = (array) $xmlIterator->attributes();
			if(in_array('behaviors', array_keys($form_attribs))) {
				$behaviors = explode(',', $form_attribs['behaviors']);
			}
			$this->_behaviors = $behaviors;
		}
		return $this->_behaviors;
	}

}