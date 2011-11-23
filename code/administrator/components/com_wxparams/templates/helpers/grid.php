<?php

class ComWxparamsTemplateHelperGrid extends KTemplateHelperGrid {
    
    public function itemid($config = array()) {
        
        $config = new KConfig($config);

        $row = $config->row;
        if (!$row->item_id) {
            return WxText::_('DOES_NOT_APPLY');
        }
                
        $html = $row->item_id.' ('.htmlspecialchars($row->item_id_title,ENT_QUOTES).')';
        return $html;
    }
    
}