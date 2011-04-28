<?php
class  ComWxparamsFormElementChecklist extends KFormElementChecklist
{
	/**
	 * Override for wraping element names in an array for avoiding naming conflicts.
	 *
	 * @return string The element name.
	 */
	public function getName()
	{
		return 'params[' . $this->_name . ']';
	}
}