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
 * Processable behavior.
 * 
 * @author Arunas Mazeika
 * @package com_wxparams
 */
class ComWxparamsControllerBehaviorProcessable extends ComWextendControllerBehaviorProcessable
{
	protected function _processParams()
	{
		// Parameters are JSON encoded for DB storage.
		$this->params = json_encode($this->params->toArray());
		// Remove Line Feed (LF) and Return Carriage (RC) chars.
		$this->params = str_replace(array('\n', '\r'), '', $this->params);
	}
}