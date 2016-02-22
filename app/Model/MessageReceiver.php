<?php

/**
 * Message Model
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    MessageModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 * @dateCreated 07/17/2015  MM/DD/YYYY
 * @dateUpdated 07/17/2015  MM/DD/YYYY 
 * @functions   2
 */
App::uses('AppModel', 'Model');

/**
 * Message Model
 *
 * @category    MessageModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @fileName    InstituteModel.php
 * @description Used for user queies and validations
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class MessageReceiver extends AppModel {
    
    public $name = 'MessageReceiver';
    //public $uploadDir = 'files/schools/';
    
    
    /**
     * Before Validation Callback
     * @param array $options
     * @return boolean
     */
    public function beforeValidate($options = array()) {
        // ignore empty file - causes issues with form validation when file is empty and optional
        if (!empty($this->data[$this->alias]['logo']['error']) && $this->data[$this->alias]['logo']['error'] == 4 && $this->data[$this->alias]['logo']['size'] == 0) {
            unset($this->data[$this->alias]['logo']);
        }
        return parent::beforeValidate($options);
    }
    
    /**
     * Before Save Insert or Update
     * @param array $options Request Arguments
     * @return boolean true false
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function beforeSave($options = array()) {
        //pr($this->data);exit;
        if (isset($this->data[$this->alias]['id']) && $this->data[$this->alias]['id'] == '') {
            $this->data[$this->alias]['time_created'] = date('Y-m-d H:i:s');
        }
        $userId = AuthComponent::user('id');
        $this->data[$this->alias]['requested_by'] = ($userId != "") ? $userId : 0;
        return parent::beforeSave($options);
    }
    
    /**
     * Save message
     */
    public function saveMessageReceiver($data = array()) {
        try {
            $to_array = explode(",", $data['Message']['toid']);
            $insertdata['MessageReceiver'] = array();
            $i = 0;
            foreach ($to_array as $key => $value) {
                $insertdata['MessageReceiver'][$key]['message_id'] = $data['Message']['message_id'];
                $insertdata['MessageReceiver'][$key]['receiver_id'] = $value;
                $insertdata['MessageReceiver'][$key]['status'] = 10002;
                $insertdata['MessageReceiver'][$key]['type'] = 12001;
                $insertdata['MessageReceiver'][$key]['time_created'] = date("Y-m-d H:m:i");
                $i = $key;
            }
                $insertdata['MessageReceiver'][$i+1]['message_id'] = $data['Message']['message_id'];
                $insertdata['MessageReceiver'][$i+1]['receiver_id'] = AuthComponent::user('id');
                $insertdata['MessageReceiver'][$i+1]['status'] = 10002;
                $insertdata['MessageReceiver'][$i+1]['type'] = 12002;
                $insertdata['MessageReceiver'][$i+1]['time_created'] = date("Y-m-d H:m:i");
            return $this->saveAll($insertdata['MessageReceiver']);
        } catch (Exception $e) {
            //pr($e);
            //log_message('error', $this->db->_error_message()); //error message when query is wrong
            return false;
        }
    }
    
    /**
     * Retrieve user messages based on userid
     * @param userdata array
     * @return resultarray array
     */
    public function fetchUserMessages($userdata = array()) {
        try {
            $conditions = array(
                'MessageReceiver.row_status' => 1,
                'MessageReceiver.receiver_id' => $userdata['id'],
                'Messages.institute_id' => $userdata['institute_id']
            );
            $result = $this->find("all", array(
                'fields' => array(
                    'Messages.*',
                    'MessageReceiver.*',
                    'Users.*'
                ),
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'table' => 'messages',
                        'alias' => 'Messages',
                        'type' => 'left',
                        'conditions' => array('MessageReceiver.message_id = Messages.id')
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'left',
                        'conditions' => array('MessageReceiver.receiver_id = Users.id')
                    )
                )
            ));
            return (!empty($result))?$result:array();
        } catch(Exception $e) {
            return FALSE;
        }
    }
    
    /**
     * function to update the message read status
     * @param id int messageid
     * @return boolean
     */
    public function updateMessageStatus($updateData, $conditions) {
        try {
            return $this->updateAll($updateData, $conditions);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * function to update the message trash status
     * @param id int messageid
     * @return boolean
     */
    public function moveMessageTrash($updateData, $conditions) {
        try {
            return $this->updateAll($updateData, $conditions);
        } catch (Exception $e) {
            return false;
        }
    }
}
