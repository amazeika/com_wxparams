<?php
/**
 * @version $Id: validatable.php 136 2011-08-18 12:52:00Z amazeika $
 * @category WeXtend
 * @package WeXtend_Database
 * @subpackage Behavior
 * @copyright Copyright (C) 2010 Arunas Mazeika. All rights reserved.
 * @license GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 */

/**
 * WeXtend validatable database behavior.
 * 
 * This behavior allows for input validation at a data layer level. When used along ComWextendControllerBehaviorValidatable,
 * the latest detects if the validation process performed by this class fails and re-directs to the referrer with un-validated
 * input and error message on dispatched save/apply actions.
 * 
 * @author Arunas Mazeika <amazeika@wextend.com>
 * @category WeXtend
 * @package WeXtend_Database
 * @subpackage Behavior
 */
abstract class ComWxparamsIncludeDatabaseBehaviorValidatable extends KDatabaseBehaviorAbstract
{
	/**
	 * @var string An error message.
	 */
	protected $_error;
	
	/**
	 * Row status
	 */
	const STATUS_REJECTED = 'rejected';
	
	/**
	 * The constructor.
	 * 
	 * @param KConfig $config
	 */
	public function __construct(KConfig $config = null)
	{
		if(!$config) {
			$config = new KConfig();
		}
		parent::__construct($config);
		
		$this->_error = '';
	}
	
	/**
	 * A method for determining if the current data that's about to be saved (via update or insert)
	 * is valid.
	 * 
	 * @return boolean True is the data is valid, false otherwise.
	 */
	public function isValid()
	{
		foreach($this->getData() as $name => $value) {
			$method_name = '_validate' . ucfirst($name);
			if(method_exists($this, $method_name)) {
				if(!call_user_func(array($this, $method_name))) {
					return false;
				}
			}
		}
		return true;
	}
	
	protected function _beforeTableUpdate(KCommandContext $context)
	{
		// Same as insert.
		$this->_beforeTableInsert($context);
	}
	
	protected function _beforeTableInsert(KcommandContext $context)
	{
		// Validate row.
		if(!$this->isValid()) {
			$this->setStatus(ComWextendDatabaseBehaviorValidatable::STATUS_REJECTED);
			$this->setStatusMessage($this->getValidationError());
			return false;
		}
		return true;
	}
	
	public function setValidationError($error)
	{
		$this->_error = $error;
	}
	
	public function getValidationError()
	{
		return $this->_error;
	}
}