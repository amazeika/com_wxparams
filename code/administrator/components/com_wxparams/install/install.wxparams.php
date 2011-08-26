<?php

// Variable definitions
$database = JFactory::getDBO();
$source     = $this->parent->getPath('source');
$manifest = simplexml_load_file($this->parent->getPath('manifest'));
$package = (string) $manifest->name;
$jversion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';

// Move framework files to their corresponding locations
foreach($manifest->framework->file as $file) {
	$folder = JPATH_ROOT . dirname($file);
	if(!JFolder::exists($folder)) JFolder::create($folder);
	JFile::copy($source . $file, JPATH_ROOT . $file);
}

//Run platform specific procedures
require JPATH_ROOT . '/administrator/components/com_' . $package . '/install/install.' . $jversion . '.php';