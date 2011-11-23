<?php

class ComWxparamsModelMenus extends ComDefaultModelDefault
{
	protected $_behavior;
	
	public function __construct(KConfig $config = null)
	{
		
		if(!$config) {
			$config = new KConfig();
		}
		parent::__construct($config);
		
		$this->_behavior = ComWxparamsFactory::getModelBehavior(array('model' => 'menus'));
		
		$this->_state->insert('package', 'cmd');
	}
	
	protected function _buildQueryWhere(KDatabaseQuery $query)
	{
		// Avoid listing deleted items.
		$query->where('published', '>', 0);
		
		$state = $this->getState();
		
		if($state->package) {
			$this->_behavior->buildQueryWhere($query, $state);
		}
		
		parent::_buildQueryColumns($query);
	}
	
	protected function _buildQueryJoins(KDatabaseQuery $query)
	{
		$state = $this->getState();
		
		if($state->package) {
			$this->_behavior->buildQueryJoins($query);
		}
		parent::_buildQueryJoins($query);
	}

}