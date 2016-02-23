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
class Message extends AppModel {
    
    public $name = 'Message';
    //public $uploadDir = 'files/schools/';
    public $validate = array(
        
    );
    public $hasMany = array(
        'MessageReceiver' => array(
            'className' => 'MessageReceiver',
            'foreignKey' => 'message_id',
            'conditions' => array('MessageReceiver.row_status' => '1')
        ),
        'MessageAttachment' => array(
            'className' => 'MessageAttachment',
            'foreignKey' => 'message_id',
            'conditions' => array('MessageAttachment.row_status' => '1')
        )
    );
    
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
    public function saveMessage($data = array()) {
        try {
            $emails = explode(",", $data["Message"]['to_mail']);
            $data['Message']['sender_id'] = $_SESSION['Auth']['User']['id'];
            $data['Message']['institute_id'] = $_SESSION['Auth']['User']['institute_id'];
            $data['Message']['time_created'] = date("Y-m-d H:m:i");
            $data['Message']['status'] = 2001;
            return $this->save($data);
        } catch (Exception $e) {
            //pr($e);
            //log_message('error', $this->db->_error_message()); //error message when query is wrong
            return false;
        }
        
    }
    
    /**
     * Retrieve the messages that sent by the user
     * @param userdata array
     * @return array result of messages array
     */
    public function fetchSentMessages($userdata = array()) {
        try {
            $conditions = array(
                'Message.row_status' => 1,
                'Message.sender_id' => $userdata['id'],
                'Message.institute_id' => $userdata['institute_id']
            );
            $result = $this->find("all", array(
                'fields' => array(
                    'Message.*',
                    'Users.*'
                ),
                'conditions' => $conditions,
                'recursive' => 0,
                'joins' => array(
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'left',
                        'conditions' => array('Message.sender_id = Users.id')
                    )
                )
            ));
            return (!empty($result))?$result:array();
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Retrieve the messages that sent by the user
     * @param messageid int
     * @return array result of messages array
     */
    public function fetchMessageDetailsById($mtype = "", $mid = 0) {
        try {
            $conditions = array(
                'Message.row_status' => 1,
                'Message.id' => $mid,
                'Message.institute_id' => AuthComponent::user('institute_id')
            );
            if ($mtype == "inbox") {
                $this->hasMany['MessageReceiver']['conditions']['MessageReceiver.type'] = 12002;
            } else if ($mtype == "outbox") {
                $this->hasMany['MessageReceiver']['conditions']['MessageReceiver.type'] = 12001;
            } else if ($mtype == "trash") {
                $this->hasMany['MessageReceiver']['conditions']['MessageReceiver.type'] = 12003;
            }
            $result = $this->find("all", array(
                'conditions' => $conditions,
                'recursive' => 2
            ));
            //pr($result);exit;
            return (!empty($result))?array_shift($result):array();
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Fetch Message details
     * @param messageid
     * @return array messagedata
     */
    public function fetchMessageDetails($id) {
        try {
            $conditions = array(
                'Message.row_status' => 1,
                'Message.id' => $id,
                'Message.institute_id' => AuthComponent::user('institute_id')
            );
            $result = $this->find("all", array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            //pr($result);exit;
            return (!empty($result))?array_shift($result):array();
        } catch (Exception $e) {
            return false;
        }
    }
}
