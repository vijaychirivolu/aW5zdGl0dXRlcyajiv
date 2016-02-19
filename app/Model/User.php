<?php

/**
 * User Model
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    UserModel
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
 * User Model
 *
 * @category    UserModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @fileName    UserModel.php
 * @description Used for user queies and validations
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class User extends AppModel {
    
    public $name = 'User';

    public $hasMany = array(
        'UserAccessLevel' => array(
            'className' => 'UserAccessLevel',
            'conditions' => array('UserAccessLevel.row_status' => 1),
            'foreignKey' => 'user_id'
        )
    );
    
    public $validate = array(
        'first_name' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter first name'
            ),
            'between' => array(
                'rule' => array('between', 3, 50),
                'message' => 'Between 3 to 50 charaters'
            ),
        ),
        'last_name' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter last name'
            ),
            'between' => array(
                'rule' => array('between', 3, 50),
                'message' => 'Between 3 to 50 charaters'
            ),
        ),
        'email' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter email address'
            ),
            'rule2' => array(
                'rule' => array('custom', '/^[A-Za-z0-9._%+-]+@([A-Za-z0-9-]+\.)+([A-Za-z0-9]{2,4})$/'),
                'message' => 'Please enter valid email address'
            ),
            'oncreate' => array(
                'on' => 'create',
                'rule' => array('emailExist', 'email'),
                'message' => 'email address already exist',
            ),
            'onupdate' => array(
                'on' => 'update',
                'rule' => array('emailExistOnUpdate', 'email'),
                'message' => 'email address already exist',
            ),
            'between' => array(
                'rule' => array('between', 3, 50),
                'message' => 'Between 3 to 50 characters',
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter password'
            )
        ),
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
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        } else {
            $result = $this->fetchUserDetailsById($this->data[$this->alias]['id']);
            if (!empty($result)) {
                if ($result["User"]["password"] != $this->data[$this->alias]['password']) {
                    $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
                }
            }
        }
        $userId = AuthComponent::user('id');
        $this->data[$this->alias]['requested_by'] = ($userId != "") ? $userId : 0;
        return parent::beforeSave($options);
    }

    /**
     * Entered email exist or not: function is used on create
     * @param array $field Entered email is existing or not
     * @return boolean If returns true email exist, other wise email availble
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function emailExist($field = array()) {
        $cnt = $this->find('count', array('conditions' => array('User.email' => $field['email'], 'User.row_status' => 1)));
        return ($cnt >= 1) ? FALSE : TRUE;
    }

    /**
     * Entered email exist or not: function is used on update
     * @param array $field Entered email is existing or not
     * @return boolean If returns true email exist, other wise email availble
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function emailExistOnUpdate($field = array()) {
        //pr($this->data);exit;
        /** To get the Existing Email Count * */
        $cnt = $this->find('count', array('conditions' => array('User.email' => $this->data['User']['email'], 'User.id <>' => $this->data['User']['id'], 'User.row_status' => 1)));
        return ($cnt >= 1) ? FALSE : TRUE;
    }

    /**
     * Query for fetch User Details
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchUserDetails() {
        try {
            $conditions = array(
                'User.row_status' => 1
            );
            $result = $this->find("all", array(
                'fields' => array(
                    'User.id',
                    'User.first_name',
                    'User.last_name',
                    'User.email',
                    'User.time_created',
                    'GroupValue.name',
                    'GroupValue.id',
                    'School.name',
                    'School.id'
                ),
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'table' => 'group_values',
                        'alias' => 'GroupValue',
                        'type' => 'left',
                        'conditions' => array('User.user_role = GroupValue.id')
                    ),
                    array(
                        'table' => 'schools',
                        'alias' => 'School',
                        'type' => 'left',
                        'conditions' => array('User.school_id = School.id')
                    )
                ),
            ));
            //pr($result);exit;
            return (!empty($result)) ? $result : array();
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
     * Query for fetch user details based on id
     * @param int $id Id for which information fetched
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchUserDetailsById($id) {
        try {
            $conditions = array(
                'User.row_status' => 1,
                'User.id' => $id
            );
            $result = $this->find("first", array(
                'fields' => array(
                    'User.id',
                    'User.first_name',
                    'User.last_name',
                    'User.password',
                    'User.email'
                ),
                'conditions' => $conditions,
                'recursive' => -1
            ));
            return (!empty($result)) ? $result : array();
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
     * Update query based on condtions
     * @param array $updateData which data has been updated
     * @param array $conditions which id we need to update
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function updateUserDetails($updateData, $conditions) {
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
     * Save query based on condtions
     * @param array $insert-data which data has been updated
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function saveUserDetails($data) {
        try {
            $data['time_created'] = date('Y-m-d H:i:s');
            return $this->save($data);
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
     * Entered email exist or not: function is used on create
     * @param array $field Entered email is existing or not
     * @return boolean If returns true email exist, other wise email availble
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function isEmailExist($email) {
        try {
            return $this->find('first', array('conditions' => array('User.email' => $email, 'User.row_status' => 1)));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
