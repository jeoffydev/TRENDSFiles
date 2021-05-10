<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(0);
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package     CodeIgniter
 * @author      Ankit
 * @copyright   Copyright (c) 2016, Ankit.
 * @license     
 * @link        http://
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Ankit email class
 *
 * @package     CodeIgniter
 * @subpackage          Libraries
 * @category           Ankit 
 * @author      Ankit
 * @link        http://
 */

class Custom_email {
      
      var $CI; 
      public function __construct(){

        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->config->item('base_url');
        $this->CI->load->database();
      
      }

      public function test(){
          $transport = Swift_MailTransport::newInstance();
          return $transport;
      }
      
      public function sendMail($emailsubject,$dataMessage,$mailid){
      	           //   Create the transport
                      $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com',587,tls)
                      ->setUsername('abc@gmail.com')
                      ->setPassword('xxxxxxxxx');
                      
                    // Create the mailer
                      $mailer = Swift_Mailer::newInstance($transport);
                      $messages = Swift_Message::newInstance('Subject')
                        ->setFrom (array('abc@gmail.com' => 'Subject'))
                        ->setTo (array($mailid => 'Add Recipients'))
                        ->setSubject ($emailsubject)
                        ->setBody ($dataMessage, 'text/html');
                        
                       //    Send the message
                       $result = $mailer->send($messages);
                       // $message = '';
                       if($result){
                                   return "success";
                         }
               
             }
                    
}