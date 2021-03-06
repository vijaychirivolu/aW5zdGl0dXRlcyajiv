<?php

/**
 * Skill Model
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    SkillModel
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
 * Skill Model
 *
 * @category    SkillModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @fileName    SkillModel.php
 * @description Used for user queies and validations
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class Skill extends AppModel {

    public $name = 'Skill';
    public $validate = array(
        'name' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter class name.'
            ),
            'rule2' => array(
                'rule' => 'alphaNumericDashUnderscore',
                'message' => 'Skill Name can only be letters,space,dash and underscore.'
            ),
            'between' => array(
                'rule' => array('between', 3, 50),
                'message' => 'Skill should be between 3 and 50 charaters.'
            ),
            'oncreate' => array(
                'on' => 'create',
                'rule' => array('skillExist', 'name'),
                'message' => 'Skill name already exist.',
            ),
            'onupdate' => array(
                'on' => 'update',
                'rule' => array('skillExistOnUpdate', 'name'),
                'message' => 'Skill name already exist.',
            ),
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
        if (Router::getParams("action") == "admin_skills") {
            $this->data[$this->alias]['time_created'] = date('Y-m-d H:i:s');
        } else {
            if (isset($this->data[$this->alias]['id']) && $this->data[$this->alias]['id'] == '') {
                $this->data[$this->alias]['time_created'] = date('Y-m-d H:i:s');
            }
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
    public function skillExist($field = array()) {
        $instituteId = AuthComponent::user('institute_id');
        $cnt = $this->find('count', array('conditions' => array(
                'Skill.name' => addslashes($this->data['Skill']['name']),
                'Skill.institute_id' => $instituteId,
                'Skill.row_status' => 1
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
    public function skillExistOnUpdate($field = array()) {
        $instituteId = AuthComponent::user('institute_id');
        $cnt = $this->find('count', array('conditions' => array(
                'Skill.name' => addslashes($this->data['Skill']['name']),
                'Skill.id <>' => $this->data['Skill']['id'],
                'Skill.institute_id' => $instituteId,
                'Skill.row_status' => 1)));
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
    public function updateSkillDetails($updateData, $conditions) {
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
    public function fetchSkillsDetailsByInstituteId($instituteId) {
        try {
            $result = $this->find("all", array(
                'conditions' => array(
                    'Skill.row_status' => 1,
                    'Skill.institute_id' => $instituteId
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
     * Query for fetchSkillsDetailsById
     * @param int $id Id for which information fetched
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchSkillDetailsById($id) {
        try {
            $result = $this->find("first", array(
                'conditions' => array(
                    'Skill.row_status' => 1,
                    'Skill.id' => $id
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
     * Query for fetchSkillSectionsResultsByInstitueId
     * @param int $instituteId Id for which information fetched
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchSkillResultsByInstitueId($instituteId) {
        try {
            $result = $this->find("all", array(
                "fields" => array(
                    "Skill.id",
                    "Skill.name"
                ),
                'conditions' => array(
                    'Skill.row_status' => 1,
                    'Skill.institute_id' => $instituteId
                ),
                'order' => 'Skill.id asc'
            ));
            $temp = array();
            if (!empty($result)) {
                foreach($result as $k=>$res):
                    $temp[$res["Skill"]["name"]][] = $res["Section"];
                endforeach;
            }
            return $temp;
        }
        //try method ends
        //catch method starts
        catch (Exception $e) {
            //log_message('error', $this->db->_error_message()); //error message when query is wrong
            return false;
        }
    }

}
