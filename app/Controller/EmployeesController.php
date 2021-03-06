<?php

/**
 * Employees Controller
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    EmployeesController
 * @package     Controllers
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 * @dateCreated 07/17/2015  MM/DD/YYYY
 * @dateUpdated 07/17/2015  MM/DD/YYYY 
 * @functions   2
 */
App::uses('AppController', 'Controller');

/**
 * Gallery Controller : User logins, Manage users with options like add,edit and delete
 *
 * @category GalleryController
 * @package  Controllers
 * @author   Vijay.Ch <vijay.ch@vendus.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://localhost/cacsv2/index
 */
class EmployeesController extends AppController {

    public $uses = array('Employee','Skill');
    public $components = array('Custom');

    /**
     * Before filter
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    function beforeFilter() {
        $this->guestActions = array();
        $this->superadminActions = array('setup', 'index', 'grid');
        $this->adminActions = array();
        $this->instituteAdminActions = array('setup', 'index', 'grid');
        $this->userActions = array();
        parent::beforeFilter();
        $this->UserAuth->allow('');
        $this->set('active_tab', 'users');
        if ($this->request->is('ajax')) {
            $this->layout = false;
        }
    }

    /**
     * isAuthorized
     * @param array $user User Session data
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function isAuthorized($user) {
        return $this->__checkAuthentication($user, $this->action);
    }

    /**
     * Index
     * @param array $user User Session data
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function index() {
        
    }

    /**
     * Index
     * @param array $user User Session data
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function grid() {
        if ($this->instituteId != "") {
            $conditions = array(
                'Employee.row_status' => 1,
                'Employee.institute_id' => $this->instituteId
            );
            $employeeResults = $this->Employee->fetchAllEmployeesByConditions($conditions);
            //pr($employeeResults);exit;
            $this->set(compact("employeeResults"));
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
    }

    /**
     * Index
     * @param array $user User Session data
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function setup($id = 0) {
        if ($this->instituteId != "") {
            $postData = $this->request->data;
            $skillDetails = $this->Skill->fetchSkillsDetailsByInstituteId($this->instituteId);
            foreach($skillDetails as $k=>$res){
                $instituteSkills[$res['Skill']['id']] = $res['Skill']['name'];
            }
            if (!empty($postData)) {
                if ($this->Student->validates()) {
                    if ($this->Employee->save($postData)) {
                        $msg = ($id > 0) ? __('The Employee has been updated.') : __('The Employee has been added.');
                        if ($this->request->is('ajax')) {
                            echo json_encode(array(
                                'status' => "success",
                                "message" => $msg,
                                'callback' => array("prefix" => false, "controller" => "employees", "action" => "index")
                            ));
                            exit;
                        } else {
                            $this->_setFlashMsgs($msg, 'success');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            } else {
                if ($id > 0) {
                    $result = $this->Student->fetchStudentDetailsById($id);
                    $this->request->data = $result;
                }
            }
            $this->set(compact("id", "instituteSkills"));
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
    }

}

?>