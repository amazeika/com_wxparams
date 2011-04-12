<?php
/**
 * @version 1.0 $Id$
 * @package com_wxparams
 * @copyright Copyright (C) 2011 Arunas Mazeika. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v3+ (GNU GPLv3) <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.wextend.com
 * 
 */

class ComWxparamsDispatcher extends ComDefaultDispatcher {
	
	public function __construct(KConfig $config = null) {
		if (! $config) {
			$config = new KConfig();
		}
		
		parent::__construct( $config );
		
		// Enqueue validators, pre and post data processors if necessary. Commands are dinamically enqueued
		// using the available information in the request data.
		$data = $this->getData();
		$needles = array ('validator', 'preprocessor', 'postprocessor' );
		foreach ( $needles as $needle ) {
			if (in_array( $needle, $data )) {
				// Enqueue the command
				$this->getCommandChain()->enqueue( KFactory::tmp( $data [$needle] ) );
			}
		}
	
	}
}