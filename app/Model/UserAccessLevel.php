<?php

/**
 * UserAccessLevel Model
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    UserAccessLevelModel
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
 * UserAccessLevel Model
 *
 * @category    UserAccessLevelModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @fileName    UserAccessLevelModel.php
 * @description Used for user queies and validations
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class UserAccessLevel extends AppModel {
    
    public $name = 'UserAccessLevel';
    public $belongsTo = array(
        'Institute' => array(
            'className' => 'Institute',
            'conditions' => array('Institute.row_status' => 1),
            'foreignKey' => 'institute_id'
        ),
        'GroupValue' => array(
            'className' => 'GroupValue',
            'conditions' => array('GroupValue.row_status' => 1),
            'foreignKey' => 'user_role'
        )
    );
    
    
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
    public function updateUserAccessLevelDetails($updateData, $conditions) {
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
     * Query for fetchAccessDetailsByUserId
     * @param int $id Id for which information fetched
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchAccessDetailsByUserId($userId) {
        try {
            $conditions = array(
                'UserAccessLevel.row_status' => 1,
                'UserAccessLevel.user_id' => $userId
            );
            $result = $this->find("first", array(
                'fields' => array(
                    'UserAccessLevel.user_role',
                    'UserAccessLevel.institute_id'
                ),   
                'conditions' => $conditions,
                'order' => 'UserAccessLevel.id desc',
                'recursive' => -1
            ));
            return (!empty($result)) ? $result : array();
        }
        //try method ends
        //catch method starts
        catch (Exception $e) {
            pr($e->getMessage());exit;
            //log_message('error', $this->db->_error_message()); //error message when query is wrong
            return false;
        }
        //catch method ends
    }
    
    /**
     * Query for fetchAccessDetailsByUserId
     * @param int $id Id for which information fetched
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchAllAccessDetailsByUserId($userId) {
        try {
            $conditions = array(
                'UserAccessLevel.row_status' => 1,
                'UserAccessLevel.user_id' => $userId
            );
            $result = $this->find("all", array(
                'fields' => array(
                    'UserAccessLevel.id',
                    'UserAccessLevel.user_role',
                    'UserAccessLevel.institute_id',
                    'GroupValue.name'
                ),
                'joins' => array(
                    array(
                        'table' => 'group_values',
                        'alias' => 'GroupValue',
                        'type' => 'left',
                        'conditions' => array('UserAccessLevel.user_role = GroupValue.id AND GroupValue.row_status = 1')
                    ),
                ),
                'conditions' => $conditions,
                'order' => 'UserAccessLevel.user_role asc',
                'recursive' => -1
            ));
            return (!empty($result)) ? $result : array();
        }
        //try method ends
        //catch method starts
        catch (Exception $e) {
            pr($e->getMessage());exit;
            //log_message('error', $this->db->_error_message()); //error message when query is wrong
            return false;
        }
        //catch method ends
    }
    
    /**
     * Query for fetchAccessDetailsById
     * @param int $id Id for which information fetched
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchAccessDetailsById($accessLevelId) {
        try {
            $conditions = array(
                'UserAccessLevel.row_status' => 1,
                'UserAccessLevel.id' => $accessLevelId
            );
            $result = $this->find("first", array(
                'fields' => array(
                    'UserAccessLevel.user_role',
                    'UserAccessLevel.institute_id'
                ),   
                'conditions' => $conditions,
                'order' => 'UserAccessLevel.id desc',
                'recursive' => -1
            ));
            return (!empty($result)) ? $result : array();
        }
        //try method ends
        //catch method starts
        catch (Exception $e) {
            pr($e->getMessage());exit;
            //log_message('error', $this->db->_error_message()); //error message when query is wrong
            return false;
        }
        //catch method ends
    }
}
