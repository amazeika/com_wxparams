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
 * Commandable behavior.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsControllerBehaviorCommandable extends ComDefaultControllerBehaviorCommandable
{

    protected function _beforeGet(KCommandContext $context)
    {
        parent::_beforeGet($context);
        $this->getView()->setToolbar($this->getToolbar());
    }

    public function _afterGet(KCommandContext $context)
    {
        // Do not assign the toolbar to the document (this is useless on tmp=component views), and at the same time prevent
    // the rendering of the toolbar which automatically modifies the content of some commands attributes (like classes).
    // Rendering the toolbar twice causes the toolbar template helper to fail rendering some commands.
    }
}