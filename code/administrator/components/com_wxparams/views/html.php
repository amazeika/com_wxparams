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
 * Default HTML view.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsViewHtml extends ComDefaultViewHtml
{
    protected $_toolbar;
    
    public function setToolbar($toolbar) {
        $this->_toolbar = $toolbar;
    }
    
    public function getToolbar() {
        return $this->_toolbar;
    }

}