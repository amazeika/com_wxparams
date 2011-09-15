<?php
/**
 * @version     $Id: koowa.php 3678 2011-07-10 11:36:25Z johanjanssens $
 * @category	Nooku
 * @package     Nooku_Plugins
 * @subpackage  System
 * @copyright   Copyright (C) 2007 - 2010 Johan Janssens. All rights reserved.
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.nooku.org
 */

/**
 * Koowa System plugin
 *
 * @author      Johan Janssens <johan@nooku.org>
 * @category    Nooku
 * @package     Nooku_Plugins
 * @subpackage  System
 */
defined('_JEXEC') or die('Restricted access');

class plgSystemWxparams extends JPlugin
{
	public function __construct($subject, $config = array())
	{
		// Load the WxParams framework
		require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_wxparams' . DS . 'includes' . DS . 'loader.php');
		parent::__construct($subject, $config);
	}
}