<?php

interface ComWxparamsModelBehaviorMenuInterface {
    
    public function buildQueryWhere(KDatabaseQuery $query, KConfigState $state);
    
    public function buildQueryJoins(KDatabaseQuery $query);
    
}