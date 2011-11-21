<?php
/**
 * @version $Id: validatable.php 223 2011-10-10 13:08:11Z amazeika $
 * @category WeXtend
 * @package WeXtend_Controller
 * @subpackage Behavior
 * @copyright Copyright (C) 2010 Arunas Mazeika. All rights reserved.
 * @license GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 */

/**
 * Abstract validatable controller behavior.
 * 
 * It provides a base class for performing data validation before
 * add/edit controller actions. If validation fails on dispatched save/apply actions, the
 * behavior performs a re-direction to the referer with the corresponding error messages and the
 * un-validated data. On add/edit actions, errors are set, but no forced re-direction with
 * un-validated data is performed.
 * 
 * @author Arunas Mazeika <amazeika@wextend.com>
 * @category    WeXtend
 * @package        WeXtend_Controller
 * @subpackage Behavior
 */
abstract class ComWxparamsIncludeControllerBehaviorValidatable extends KControllerBehaviorAbstract
{
	/**
	 * @var array A list of fields that must be present.
	 */
	protected $_mandatory_fields;
	
	/**
	 * @var array A list of error messages.
	 */
	protected $_errors;
	
	/**
	 * @var KCommandContext The command context passed at execution time.
	 */
	protected $_context;
	
	/**
	 * @param array A list of DISPATCHED actions for which a re-direction with un-validated data will be set.
	 */
	protected $_redirectable_actions;
	
	public function __construct(KConfig $config = null)
	{
		if(!$config) {
			$config = new KConfig();
		}
		
		parent::__construct($config);
		
		$this->_errors = array();
		
		$this->_mandatory_fields = $config->mandatory_fields;
		
		$this->_redirectable_actions = $config->redirectable_actions->toArray();
	}
	
	/**
	 * Overrided method for setting the current context.
	 * 
	 * @see KControllerBehaviorAbstract::execute()
	 */
	public function execute($name, KCommandContext $context)
	{
		$this->_context = $context;
		return parent::execute($name, $context);
	}
	
	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'auto_mixin' => true, 
			'mandatory_fields' => array(), 
			'redirectable_actions' => array('save', 'apply'), 
			'priority' => KCommand::PRIORITY_NORMAL));
		parent::_initialize($config);
	}
	
	protected function _afterAdd(KCommandContext $context)
	{
		if($context->result->getStatus() == ComWextendDatabaseBehaviorValidatable::STATUS_REJECTED) {
			// Validatable behavior prevented a row save action from being executed. Clear 
			// the context error variable to prevent the controller from throwing an exception
			// so that error handling is performed by this behavior.
			$context->setError();
			$this->_handleErrors(array($context->result->getStatusMessage()));
		}
	}
	
	/**
	 * Error handler. This method decides if we should a referrer re-direction or an exception throw should be performed
	 * depending on the request.
	 */
	protected function _handleErrors($errors = array())
	{
		if($this->isDispatched() && KRequest::type() == 'HTTP' && !empty($this->_context->data->action)) {
			$this->_enqueueErrors($errors);
			// Forced referrer re-direction with un-validated data session storage
			$events = array();
			foreach($this->_redirectable_actions as $action) {
				$events[] = 'after.' . $action;
			}
			$this->registerCallback($events, array($this, 'setReferrerRedirect'));
			return;
		}
		
		// Non-dispatched non-redirectable actions => Set the context so that an exception is thrown.
		$this->_context->setError(new KControllerException(json_encode($errors), KHttpResponse::BAD_REQUEST));
	}
	
	protected function _afterEdit(KCommandContext $context)
	{
		// Same as add.
		$this->_afterAdd($context);
	}
	
	/**
	 * Enqueue errors.
	 */
	protected function _enqueueErrors($errors = array())
	{
		// Enqueue error messages
		$application = JFactory::getApplication();
		foreach($errors as $error) {
			$application->enqueueMessage($error, 'error');
		}
	}
	
	/**
	 * Error setter.
	 * 
	 * @param string $error The error message.
	 */
	public function setValidationError($error)
	{
		$this->_errors[] = $error;
	}
	
	/**
	 * Errors getter.
	 * 
	 * @return array An array of error messages.
	 */
	public function getValidationErrors()
	{
		return $this->_errors;
	}
	
	/**
	 * Sets a re-direction to the referrer containing the un-validated dara in a session variable.
	 */
	public function setReferrerRedirect()
	{
		// Keep a record of the current data. This data will be loaded during the next
		// read action and presented to the user for rectification.
		$identifier = (string) $this->getIdentifier();
		KRequest::set("session.{$identifier}", serialize($this->_context->data));
		// Re-direct to the referrer
		$this->setRedirect(KRequest::referrer());
	}
	
	protected function _afterRead(KCommandContext $context)
	{
		
		$identifier = (string) $this->getIdentifier();
		
		// Get the session validation data for the current controller
		$data = KRequest::get("session.{$identifier}", 'raw');
		
		if($data) {
			$data = unserialize($data);
			// Get a row for the current state and replace its content with
			// the validation data
			$context->caller->getModel()
				->getItem()
				->setData($data->toArray());
			// Remove the data from the session
			KRequest::set("session.{$identifier}", null);
		}
	
	}
	
	protected function _beforeEdit(KCommandContext $context)
	{
		// Proceed to data validation.
		if(!$this->validate()) {
			$this->_handleErrors($this->getValidationErrors());
			return false;
		}
		return true;
	}
	
	protected function _beforeSave(KCommandContext $context)
	{
		// Same as Apply.
		return $this->_beforeApply($context);
	}
	
	protected function _beforeApply(KCommandContext $context)
	{
		// Proceed to check mandatory fields.
		if(!$this->checkMandatoryFields()) {
			$this->_handleErrors($this->getValidationErrors());
			return false;
		}
	}
	
	protected function _beforeAdd(KCommandContext $context)
	{
		// For the rest of the process, same as edit.
		return $this->_beforeEdit($context);
	}
	
	/**
	 * Checks if the mandatory fields are set in the request data. This method is only
	 * triggered on save/apply actions as it's under these conditions that a full dataset is
	 * expected from the user.
	 * 
	 * @return boolean True on success, false othewise.
	 */
	public function checkMandatoryFields()
	{
		$pass = true;
		$package = strtoupper($this->getIdentifier()->package);
		
		foreach($this->_mandatory_fields as $field) {
			// Remove extra white spaces
			$value = trim($this->_context->data->$field);
			// Mandatory inputs should not be empty
			if(empty($value) && !is_numeric($value)) {
				// Report the input as not acceptable
				$this->setValidationError(JText::_($package . '_' . strtoupper($field) . '_EMPTY'));
				$pass = false;
			}
		}
		
		return $pass;
	
	}
	
	/**
	 * Trigger the data validation process. A method for validating each variable that requires
	 * validation must be implemented in the concrete validatable class. Each method will be called
	 * iif the corresponding data value is set in the request data. The naming convention for 
	 * these validation methods is _validate followed by the data name (first letter uppercased).
	 * 
	 * @return boolean True on success, false otherwise.
	 */
	public function validate()
	{
		$valid = true;
		// We just validate the provided data.
		foreach($this->_context->data as $input => $value) {
			// Construct the validation method for each input
			$method_name = '_validate' . ucfirst($input);
			// Check if such a method exists. If it doesn't, we assume that no validation should
			// be performed over the current input.
			if(method_exists($this, $method_name)) {
				$valid &= call_user_func(array($this, $method_name));
			}
		}
		return (bool) $valid;
	}
	
	public function __get($property)
	{
		$data = $this->_context->data;
		return isset($data->$property) ? $data->$property : null;
	}

}