<?php
/**
 * @version 1.0 $Id$
 * @package com_wxparams
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 */

/**
 * Configuration controller.
 *
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsControllerConfiguration extends ComDefaultControllerDefault
{
	public function __construct(KConfig $config = null)
	{
		if(!$config) {
			$config = new KConfig();
		}
		
		parent::__construct($config);
		
		// Form behaviors are only injected on singular views.
		if(KInflector::isSingular($this->getView()
			->getName()) && $model_state = ComWxparamsHelperSession::getModelState()) {
			// Get the form
			$form = ComWxparamsFactory::getForm(array(
				'package' => $model_state['package'], 
				'type' => $model_state['type']));
			if($behaviors = $form->getBehaviors()) {
				// Inject behaviors.
				$this->addBehavior($behaviors);
			}
		}
	}
	
	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'persistable' => true, 
			'behaviors' => array('com://admin/wextend.controller.behavior.editable', 'processable')));
		parent::_initialize($config);
	}
}