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
class MessageAttachment extends AppModel {
    
    public $name = 'MessageAttachment';
    //public $uploadDir = 'files/schools/';
    public $validate = array(
        
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
     * Function to save the user attachments
     * @param file data array
     * @param array $filearray Description
     */
    public function saveUserAttachments($filedata = array()) {
        try {
            return $this->saveAll($filedata['MessageAttachment']);
        } catch (Exception $e) {
            return FALSE;
        }
    }
    
    /**
     * Function to get all the filenames to download all
     * @param file data array
     * @param array $filearray Description
     */
    public function getAllFileNames($id = "") {
        try {
            $conditions = array(
                'MessageAttachment.row_status' => 1,
                'MessageAttachment.message_id' => $id
            );
            $result = $this->find("all", array(
                'fields' => array(
                    'MessageAttachment.filename'
                ),
                'conditions' => $conditions
            ));
            return (!empty($result))?$result:array();
        } catch (Exception $e) {
            return FALSE;
        }
    }
}
