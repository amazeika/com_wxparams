<?php
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