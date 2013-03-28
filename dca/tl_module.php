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
 *  Fields
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['reg_notifyWebmasterEmail'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['reg_notifyWebmasterEmail'],
	'exclude'                 => true,
	'inputType'               => 'text',
       'sql'                     => "text NOT NULL",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['reg_notifyWebmasterSender'] = array
(
       'label'                   => &$GLOBALS['TL_LANG']['tl_module']['reg_notifyWebmasterSender'],
	'exclude'                 => true,
	'inputType'               => 'radio',
       'options'                 => array('member','administrator'),
       'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
       'sql'                     => "text NOT NULL",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['reg_notifyWebmaster'] = array
(
       'label'                   => &$GLOBALS['TL_LANG']['tl_module']['reg_notifyWebmaster'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => "char(1) NOT NULL default ''",
);

/**
 * palettes
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['registration'] = str_replace('{template_legend', '{notify_webmaster_legend:hide},reg_notifyWebmaster;{template_legend', $GLOBALS['TL_DCA']['tl_module']['palettes']['registration']);

/**
 * add a new selector
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'reg_notifyWebmaster';

/**
 * add a new sub palette
 */
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['reg_notifyWebmaster'] = 'reg_notifyWebmasterEmail,reg_notifyWebmasterSender';


