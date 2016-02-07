<?php

/**
 * Institute Model
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    InstituteModel
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
 * Institute Model
 *
 * @category    InstituteModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @fileName    InstituteModel.php
 * @description Used for user queies and validations
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class Institute extends AppModel {
    
    public $name = 'Institute';
    public $uploadDir = 'files/schools/';
    public $validate = array(
        'name' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter school name'
            ),
            'rule2' => array(
                'rule' => 'alphaNumericDashUnderscore',
                'message' => 'Institute Name can only be letters,space,dash and underscore'
            ),
            'between' => array(
                'rule' => array('between', 3, 200),
                'message' => 'Institute should be between 3 and 200 charaters.',
                'allowEmpty' => true
            )/*,
            'oncreate' => array(
                'on' => 'create',
                'rule' => array('schoolExist', 'name'),
                'message' => 'Institute name already exist',
            ),
            'onupdate' => array(
                'on' => 'update',
                'rule' => array('schoolExistOnUpdate', 'name'),
                'message' => 'Institute name already exist',
            ),*/
        ),
        'registration_no' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter registration number'
            )
        ),
        'landline_no' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter landline number'
            ),
            'rule2' => array(
                'rule' => 'numeric',
                'message' => 'Numerics only.'
            )
        ),
        'phone_no' => array(
            'rule1' => array(
                'rule' => array('notBlank'),
                'message' => 'Please enter phone number'
            ),
            'rule2' => array(
                'rule' => 'numeric',
                'message' => 'Numerics only.'
            )
        ),
        'logo' => array(
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
                'rule' => array('processUpload', 'logo'),
                'message' => 'Something went wrong processing your file',
                'required' => FALSE,
                'allowEmpty' => TRUE,
                'last' => TRUE,
            )
        ),
        'fb_url' => array(
            'website' => array(
                'rule' => array('url', true),
                'allowEmpty' => true,
                'message' => 'Please enter facebook URL'
            ),
            'between' => array(
                'rule' => array('between', 3, 200),
                'message' => 'Facebook URL should be between 3 and 200 charaters.',
                'allowEmpty' => true
            )
        ),
        'twitter_url' => array(
            'website' => array(
                'rule' => array('url', true),
                'allowEmpty' => true,
                'message' => 'Please enter twitter URL'
            ),
            'between' => array(
                'rule' => array('between', 3, 200),
                'message' => 'Twitter URL should be between 3 and 200 charaters.',
                'allowEmpty' => true
            )
        ),
        'linkedin_url' => array(
            'website' => array(
                'rule' => array('url', true),
                'allowEmpty' => true,
                'message' => 'Please enter linkedin URL'
            ),
            'between' => array(
                'rule' => array('between', 3, 200),
                'message' => 'Linkedin URL should be between 3 and 200 charaters.',
                'allowEmpty' => true
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

        return preg_match('/^([a-zA-Z\s\_\-]+)$/', $value);
    }

    
    /**
     * Update query based on condtions
     * @param array $updateData which data has been updated
     * @param array $conditions which id we need to update
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function updateInstituteDetails($updateData, $conditions) {
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
     * Here Checking school exists or not
     * @param String $name Institute Name
     * @param String $registrationNo Institute Registration No  
     * @param String $address Institute Address
     * @param String $streetAddress Institute Street Address
     * @param String $city Institute City
     * @param String $state Institute State
     * @param String $country Institute Country
     * @param String $postalCode Institute Postal Code
     * @return array 
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode. 
     */
    public function isInstituteExists($name,$registrationNo,$address,$streetAddress,$city,$state,$country,$postalCode) {
        $result = $this->find("first",array(
           'conditions' => array(
               'Institute.name' => $name,
               'Institute.registration_no' => $registrationNo,
               'Institute.address' => $address,
               'Institute.street_address' => $streetAddress,
               'Institute.city' => $city,
               'Institute.state' => $state,
               'Institute.country' => $country,
               'Institute.postal_code' => $postalCode
           ) 
        ));
        return (!empty($result))?$result:array();
    }
    
    /**
     * isInstituteExists
     * @param Int $schoolId
     * @return boolean 
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode. 
     */
    public function isInstituteExistsById($schoolId) {
        $count = $this->find("count",array(
           'conditions' => array(
               'Institute.row_status' => 1,
               'Institute.id' => $schoolId
           ) 
        ));
        return ($count > 0) ? true : false;
    }

     /**
    * Get the list of states
    * return states_list array
    */
    public function getStates() {
        try {
            $conditions = array(
                'Institute.row_status' => 1
            );
            $result = $this->find("all", array(
                'fields' => array(
                    'DISTINCT Institute.state'
                ),
                'conditions' => $conditions
            ));
            return (!empty($result)) ? $result : array();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
    * Get the list of cities by state id
    * @param stateid int
    * return citieslist json 
    */
    public function getCitiesByStateName($state) {
        try {
            $conditions = array(
                'Institute.row_status' => 1,
                'Institute.state' => $state
            );
            $result = $this->find("all", array(
                'fields' => array(
                    'DISTINCT Institute.city'
                ),
                'conditions' => $conditions
            ));
            return (!empty($result)) ? $result : array();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
    * Get the list of cities by state id
    * @param stateid int
    * return citieslist json 
    */
    public function getAddressByCityStateName($state, $city) {
        try {
            $conditions = array(
                'Institute.row_status' => 1,
                'Institute.state' => $state,
                'Institute.city' => $city
            );
            $result = $this->find("all", array(
                'fields' => array(
                    'DISTINCT Institute.street_address'
                ),
                'conditions' => $conditions
            ));
            return (!empty($result)) ? $result : array();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
    * Get the list of schools by address
    * @param stateid int
    * return citieslist json 
    */
    public function getInstituteNameByAddress($state, $city, $address) {
        try {
            $conditions = array(
                'Institute.row_status' => 1,
                'Institute.state' => $state,
                'Institute.city' => $city,
                'Institute.street_address' => $address
            );
            $result = $this->find("all", array(
                'fields' => array(
                    'Institute.name',
                    'Institute.id'
                ),
                'conditions' => $conditions
            ));
            return (!empty($result)) ? $result : array();
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * FetchStateDetailsById
     * @param Int $schoolId
     * @return array Result of school 
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode. 
     */
    public function fetchStateDetailsById($schoolId) {
        return $this->find('first', array(
                    'conditions' => array(
                        'Institute.id' => $schoolId,
                        'Institute.row_status' => 1
                    )
        ));
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
}
