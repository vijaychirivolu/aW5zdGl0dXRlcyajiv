<?php

/**
 * Student Model
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    StudentModel
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
 * Student Model
 *
 * @category    StudentModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @fileName    StudentModel.php
 * @description Used for user queies and validations
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class Student extends AppModel {

    public $name = 'Student';
    public $uploadDir = 'files/students/';
    var $actsAs = array('StoredProcedure');
    public $belongsTo = array(
        'ClassInfo' => array(
            'className' => 'ClassInfo',
            'foreignKey' => 'current_class_id'
        ),
        'Section' => array(
            'className' => 'Section',
            'foreignKey' => 'current_section_id'
        )
    );
    public $validate = array(
        'current_class_id' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please select class name'
            )
        ),
        'first_name' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter first name.'
            ),
            'rule2' => array(
                'rule' => 'alphaNumericDashUnderscore',
                'message' => 'First Name can only be letters,space,dash and underscore.'
            )
        ),
        'last_name' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter last name.'
            ),
            'rule2' => array(
                'rule' => 'alphaNumericDashUnderscore',
                'message' => 'Last Name can only be letters,space,dash and underscore.'
            )
        ),
        'addmission_no' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter admission number.'
            ),
            'oncreate' => array(
                'on' => 'create',
                'rule' => array('studentExist', 'name'),
                'message' => 'Student already exists with this admission number.',
            ),
            'onupdate' => array(
                'on' => 'update',
                'rule' => array('studentExistOnUpdate', 'name'),
                'message' => 'Student already exists with this admission number.',
            )
        ),
        'date_of_joining' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter student date of joining'
            )
        ),
        'image' => array(
            // http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::uploadError
            'uploadError' => array(
                'rule' => 'uploadError',
                'message' => 'Something went wrong with the file upload',
                'required' => FALSE,
                'allowEmpty' => TRUE,
            ),
            // http://book.cakephp.org/2.0/en/models/data-validation.html#Validation::mimeType
            // custom callback to deal with the file upload
            'processUpload' => array(
                'rule' => array('processUpload', 'image'),
                'message' => 'Something went wrong processing your file',
                'required' => FALSE,
                'allowEmpty' => TRUE,
                'last' => TRUE,
            )
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
        $userSessionId = AuthComponent::user('user_session_id');
        $this->data[$this->alias]['user_session_id'] = ($userSessionId != "") ? $userSessionId : 0;
        $instituteId = AuthComponent::user('institute_id');
        $this->data[$this->alias]['institute_id'] = ($instituteId != "") ? $instituteId : 0;
        
        $dateOfJoining = $this->data[$this->alias]["date_of_joining"];
        if ($dateOfJoining != "") {
            $explodeJoiningDetails = explode("/", $dateOfJoining);
            $this->data[$this->alias]["date_of_joining"] = $explodeJoiningDetails[2] . "-" . $explodeJoiningDetails[1] . "-" . $explodeJoiningDetails[0];
        }
        
        return parent::beforeSave($options);
    }

    /**
     * AlphaNumericDashUnderscore
     * @param type $check
     * @return type
     */
    public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];

        return preg_match('/^([a-zA-Z\s\_\-\.]+)$/', $value);
    }

    /**
     * Entered state exist or not: function is used on create
     * @param array $field Entered state is existing or not
     * @return boolean If returns true state exist, other wise state availble
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function studentExist($field = array()) {
        $instituteId = AuthComponent::user('institute_id');
        $cnt = $this->find('count', array('conditions' => array(
                'Student.admission_no' => addslashes($this->data['Student']['admission_no']),
                'Student.institute_id' => $instituteId,
                'Student.class_id' => $this->data['Student']['class_id'],
                'Student.row_status' => 1
            )
                )
        );
        return ($cnt >= 1) ? FALSE : TRUE;
    }

    /**
     * Entered email exist or not: function is used on update
     * @param array $field Entered email is existing or not
     * @return boolean If returns true email exist, other wise email availble
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function studentExistOnUpdate($field = array()) {
        $instituteId = AuthComponent::user('institute_id');
        $cnt = $this->find('count', array('conditions' => array(
                'Student.admission_no' => addslashes($this->data['Student']['admission_no']),
                'Student.id <>' => $this->data['Student']['id'],
                'Student.institute_id' => $instituteId,
                'Student.class_id' => $this->data['Student']['class_id'],
                'Student.row_status' => 1)));
        return ($cnt >= 1) ? FALSE : TRUE;
    }

    /**
     * Update query based on condtions
     * @param array $updateData which data has been updated
     * @param array $conditions which id we need to update
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function updateStudentDetails($updateData, $conditions) {
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
     * Query for fetchSettingDetailsByUserId
     * @param int $id Id for which information fetched
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchStudentsDetailsByInstituteId($instituteId) {
        try {
            $result = $this->find("all", array(
                'conditions' => array(
                    'Student.row_status' => 1,
                    'Student.institute_id' => $instituteId
                )
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
     * Query for fetchStudentsDetailsById
     * @param int $id Id for which information fetched
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchStudentDetailsById($id) {
        try {
            $result = $this->find("first", array(
                'conditions' => array(
                    'Student.row_status' => 1,
                    'Student.id' => $id
                )
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
     * Process the Upload
     * @param array $check
     * @param string $uploadName Name of the image
     * @return boolean
     */
    public function processUpload($check = array(), $uploadName) {
        // deal with uploaded file
        if (!empty($check[$uploadName]['tmp_name'])) {
            // check file is uploaded
            if (!is_uploaded_file($check[$uploadName]['tmp_name'])) {
                return FALSE;
            }
            $extension = pathinfo($check[$uploadName]['name'], PATHINFO_EXTENSION);
            $filename = time() . '_' . $uploadName . "." . $extension;
            // build full filename
            $fullpath = WWW_ROOT . $this->uploadDir . $filename;
            // @todo check for duplicate filename
            // try moving file
            if (!move_uploaded_file($check[$uploadName]['tmp_name'], $fullpath)) {
                return FALSE;
                // file successfully uploaded
            } else {
                // save the file path relative from WWW_ROOT e.g. uploads/example_filename.jpg
                $this->data[$this->alias][$uploadName] = $filename;
            }
        }

        return TRUE;
    }
    
    public function getStudentCntByInstituteId($instituteId=0){
        $inParams=array(0=>$instituteId);
        $result = $this->executeMssqlSp('spGetStudentCountByInstituteId', $inParams );
        return isset($result[0][0]['StdCount'])?$result[0][0]['StdCount']:0;
    }

}
