<?php

interface ComWxparamsModelBehaviorConfigurationInterface {
    
    public function buildQueryColumns(KDatabaseQuery $query);
    
    public function buildQueryJoins(KDatabaseQuery $query);
    
}