<?php 

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * @link http://www.contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 *
 * PHP version 5
 * @copyright  Marko Cupic 2013 
 * @author     Marko Cupic 
 * @package    RegistrationNotifyWebmaster
 * @license    LGPL 
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'MCupic',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'MCupic\RegistrationNotifyWebmaster' => 'system/modules/registration_notify_webmaster/modules/RegistrationNotifyWebmaster.php',
));
