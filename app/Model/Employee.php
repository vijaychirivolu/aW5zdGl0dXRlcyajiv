<?php

/**
 * Employee Model
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    EmployeeModel
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
 * Employee Model
 *
 * @category    EmployeeModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @fileName    EmployeeModel.php
 * @description Used for user queies and validations
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class Employee extends AppModel {

    public $name = 'Employee';
    
    public $hasMany = array(
        'EmployeeSkill' => array(
            'className' => 'EmployeeSkill',
            'conditions' => array('EmployeeSkill.row_status' => 1),
            'foreignKey' => 'employee_id'
        )
    );
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'conditions' => array('User.row_status' => 1),
            'foreignKey' => 'user_id'
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
        if (isset($this->data[$this->alias]['id']) && $this->data[$this->alias]['id'] == '') {
            $this->data[$this->alias]['time_created'] = date('Y-m-d H:i:s');
        }
        $userId = AuthComponent::user('id');
        $this->data[$this->alias]['requested_by'] = ($userId != "") ? $userId : 0;
        $userSessionId = AuthComponent::user('user_session_id');
        $this->data[$this->alias]['user_session_id'] = ($userSessionId != "") ? $userSessionId : 0;
        $instituteId = AuthComponent::user('institute_id');
        $this->data[$this->alias]['institute_id'] = ($instituteId != "") ? $instituteId : 0;
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
    public function updateEmployeeDetails($updateData, $conditions) {
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
     * fetchAllEmployeesByConditions
     * @param array $conditions which id we need to update
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchAllEmployeesByConditions($conditions) {
        try {
             return $this->find("all", array(
                        'conditions' => $conditions,
                        'recursive' => 2
            ));
        }
        //try method ends
        //catch method starts
        catch (Exception $e) {
            pr($e->getMessage());
            exit;
            //log_message('error', $this->db->_error_message()); //error message when query is wrong
        }
    }
    
    public function getEmployeeCntByInstituteId($instituteId=0){
        $sqlstr="SELECT count(1) as EmpCount FROM employees WHERE institute_id in (SELECT id FROM institutes where id =".$instituteId." and  row_status=1 union SELECT id FROM institutes where id =".$instituteId." and row_status=1) and row_status=1";
//        $sqlstr="SELECT count(1) as EmpCount FROM employees WHERE institute_id=".$instituteId." and row_status=1";
//        $sqlstr="SELECT count(1) as StdCount FROM students WHERE row_status=1";
        $result=$this->query($sqlstr);
//        pr($sqlstr);pr($result);exit;
        return isset($result[0][0]['EmpCount'])? $result[0][0]['EmpCount']:0;
    }

}
