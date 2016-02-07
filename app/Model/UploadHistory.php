<?php

/**
 * UploadHistory Model
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    UploadHistoryModel
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
 * UploadHistory Model
 *
 * @category    UploadHistoryModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @fileName    UploadHistoryModel.php
 * @description Used for user queies and validations
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class UploadHistory extends AppModel {
    
    public $name = 'UploadHistory';
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
     * Update query based on condtions
     * @param array $updateData which data has been updated
     * @param array $conditions which id we need to update
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function updateUploadHistoryDetails($updateData, $conditions) {
        try {
            return $this->updateAll($updateData, $conditions);
        }
        //try method ends
        //catch method starts
        catch (Exception $e) {
            //log_message('error', $this->db->_error_message()); //error message when query is wrong
            return false;
        }
        //catch method ends
    }
    
    /**
     * Query to fetch CAFR Upload History Data
     * @param Int $type Upload Type
     * @return array
     */
    public function getUploadHistoryListByType($type) {
        $result = $this->find("all", array(
            'fields' => array(
              'UploadHistory.id',
              'UploadHistory.original_filename',
              'UploadHistory.uploaded_filename',
              'UploadHistory.error_filename',
              'UploadHistory.error_message',
              'UploadHistory.row_status',
              'UploadHistory.time_created',
              'User.id',
              'User.first_name',
              'User.last_name'  
            ),
            'conditions' => array(
                'UploadHistory.row_status' => 1
            ),
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'conditions' => array('UploadHistory.requested_by = User.id AND User.row_status = 1')
                ),
            ),
            'order' => 'UploadHistory.id desc'
        ));
        if (!empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

}
