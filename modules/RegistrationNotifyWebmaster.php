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
 * Run in a custom namespace, so the class can be replaced
 */
namespace MCupic;

/**
 * Class RegistrationNotifyWebmaster 
 *
 * @copyright  Marko Cupic 2013 
 * @author     Marko Cupic 
 * @package    RegistrationNotifyWebmaster
 */
class RegistrationNotifyWebmaster extends \Frontend
{
       /**
        * Notifiy webmaster
        * @param integer
        * @param array
        * @param object 
        */
       public function notifyWebmaster($intId, $arrData, $objModule)
       {
              // Inform admin 
              if ($objModule->reg_notifyWebmaster && strlen(trim($objModule->reg_notifyWebmasterEmail)))
              {
                     $this->sendWebmasterNotification($intId, $arrData, $objModule);
              }
       }

       /**
        * Send webmaster notification
        * @param integer
        * @param array
        * @param object
        */
       protected function sendWebmasterNotification($intId, $arrData, $objModule)
       {
              $objEmail = new \Email();
              
              // Get the email recipients
              $arrRecipients = explode(',', trim($objModule->reg_notifyWebmasterEmail));
              
              // Set the sender 
              if ($objModule->reg_notifyWebmasterSender == 'administrator')
              {
                     $objEmail->from = $GLOBALS['TL_CONFIG']['adminEmail'];
                     $objEmail->fromName = $GLOBALS['TL_LANG']['MSC']['regNotifyWebmasterAdminName'];
              }
              else 
              {
                     $objEmail->from = strlen($arrData['email']) ? $arrData['email'] : $GLOBALS['TL_ADMIN_EMAIL'];
                     $objEmail->fromName = (strlen($arrData['firstname']) && strlen($arrData['lastname'])) ?  $arrData['firstname'] . ' ' . $arrData['lastname'] : $arrData['username'];
              }
              
              // Set the subject
              $objEmail->subject = sprintf($GLOBALS['TL_LANG']['MSC']['adminSubject'], \Environment::get('host'));
              
              // Set the text
              $strData = chr(13) . chr(10) . chr(13) . chr(10);
              
              // Add user details
              foreach ($arrData as $k=>$v)
              {
                     if ($k == 'password' || $k == 'tstamp' || $k == 'activation')
                     {
                            continue;
                     }
                     
                     $v = deserialize($v);
                     
                     // Get title from tl_newsletter_channel
                     if ($k == 'newsletter' && is_array($v))
                     {
                            foreach ($v as $key => $newsletterId)
                            {
                            $v[$key] = $this->getTitleFromId($newsletterId, 'newsletter_channel');
                            }
                     }
              
                     if ($k == 'dateOfBirth' && strlen($v))
                     {
                            $v = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $v);
                     }
                     
                     if (!strlen($GLOBALS['TL_LANG']['tl_member'][$k][0])) continue;
                     $strData .= $GLOBALS['TL_LANG']['tl_member'][$k][0] . ': ' . (is_array($v) ? implode(', ', $v) : $v) . chr(13) . chr(10);
              }
              
              // Set the email body
              $objEmail->text = sprintf($GLOBALS['TL_LANG']['MSC']['adminText'], $intId, $strData . chr(13) . chr(10)) . chr(13) . chr(10);
              
              // Send the email
              $objEmail->sendTo($arrRecipients);
              
              // Write to the system-log
              $this->log('A webmaster notification e-mail has been sent.', 'RegistrationNotifyWebmaster sendWebmasterNotification()', TL_ACCESS);
       }
       
       /**
        * get title from id
        * @param integer
        * @param string
        * @return string|int
        */
       protected function getTitleFromId($intId, $strTable)
       {
              switch ($strTable)
              {
                     case 'newsletter_channel':
                            $objDb = \NewsletterChannelModel::findByPk($intId);
                            if ($objDb !== null)
                            {
                                   return $objDb->title;
                            }
                            break;
                     
                     default:
                            return $intId;
              }
              return $intId;
       }
}
