<?php
class ComWxparamsControllerBehaviorValidatable extends ComWextendControllerBehaviorValidatable
{
	protected function _initialize(KConfig $config)
	{
		$config->append(array('mandatory_fields' => array('title', 'package', 'type')));
		parent::_initialize($config);
	}
}