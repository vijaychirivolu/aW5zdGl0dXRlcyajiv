<?php

/**
 * NotificationEmail Component
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    NotificationEmailComponent
 * @package     Components
 * @author      Pushkar <pushkar@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 * @dateCreated 07/21/2015  MM/DD/YYYY
 * @dateUpdated 07/21/2015  MM/DD/YYYY 
 * @functions   2
 */
App::uses('CakeEmail', 'Network/Email');

/**
 * Notification Email Component
 *
 * @category    NotificationEmail
 * @package     Components
 * @author      Pushkar <pushkar@vendus.com>
 * @fileName    NotificationEmailComponent.php
 * @description Used for email notification
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class NotificationEmailComponent extends Component {

    /**
     * Construct method
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function __construct() {
        
    }

    /**
     * GetFromEmail
     * @return array From email with site name
     */
    public function getFromEmail() {
        return array('noreply@vendus.com' => 'CACS');
    }

    /**
     * Sending Forgot Password Email
     * @param array  $user         User Session data
     * @param string $new_password Newly generated password
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function sendForgotPasswordEmail($user = array(), $new_password = '') {
        if (!empty($user) && $new_password != '') {
            $Email = new CakeEmail();
            $subject = 'CACS - Reset Password Mail';
            $heading = 'CACS - Reset Password Mail';
            $Email->template('send_forgot_password_email',null);
            $Email->viewVars(array('user' => $user, 'new_password' => $new_password, 'heading' => $heading));
            $Email->from(array('noreply@vendus.com' => 'CACS'));
            $Email->to($user['User']['email']);
            $Email->subject('Password Reset Request - DO NOT REPLY');
            $Email->emailFormat('html');
            //$Email->sendAs('both');
            $Email->send();
            return true;
        }
        return false;
    }

    /**
     * Registration Mail
     * @param type $userData
     * @return type Description
     */
    public function registrationMail($userData) {
        $from = $this->getFromEmail();
        $to = $userData['User']['email'];
        $subject = 'CACS - Registration Mail';
        $email = new CakeEmail();
        $email->from($from);
        $email->to($to);
        $heading = 'CACS - Registration Mail';
        $email->template('registration_mail', null);
        $email->viewVars(array('userData' => $userData,'heading' => $heading)); //set User details to template to display the user details
        $email->emailFormat('html');
        $email->subject($subject);
        if ($response = $email->send()) {
            $body = (isset($response['message'])) ? $response['message'] : "";
            $emailStatus = 0;
        } else {
            $body = (isset($response['message'])) ? $response['message'] : "";
            $emailStatus = 1;
        }
        //$requestedBy = $userData['User']['requested_by'];
        //$this->saveMailHistory($purpose, $from, $to, $subject, $body, $emailStatus, $requestedBy, $clientID);
    }

}

?>