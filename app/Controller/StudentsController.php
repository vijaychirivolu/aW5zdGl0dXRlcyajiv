<?php

/**
 * Students Controller
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    StudentsController
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
 * Students Controller : User logins, Manage users with options like add,edit and delete
 *
 * @category StudentsController
 * @package  Controllers
 * @author   Vijay.Ch <vijay.ch@vendus.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://localhost/cacsv2/index
 */
class StudentsController extends AppController {

    public $uses = array('Student');
    public $components = array("Custom", "DataTable");

    /**
     * Before filter
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    function beforeFilter() {
        $this->guestActions = array();
        $this->superadminActions = array();
        $this->instituteAdminActions = array('index', 'setup', 'delete', 'resultsByFilters');
        $this->adminActions = array();
        $this->userActions = array();
        parent::beforeFilter();
        $this->UserAuth->allow('');
        $this->set('active_tab', 'students');
        if ($this->request->is('ajax')) {
            $this->layout = false;
        }
        $this->Breadcrumb->add('Dashboards', '/dashboards/index');
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
        if ($this->instituteId != "") {
            $heading = __("Manage Students");
            $this->Breadcrumb->add('Manage', '');
            $classResult = $this->Custom->fetchClassesForDropDown($this->instituteId);
            $this->set(compact("classResult","heading"));
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
    }

    /**
     * Add,Edit Actions
     * @param array $user User Session data
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function setup($id = 0) {
        if ($this->instituteId != "") {
            $heading = ($id > 0)?__("Edit Student"):__("Add Student");
            $this->Breadcrumb->add('Manage', '/students/index');
            $this->Breadcrumb->add(($id > 0)?'Edit':'Add', '');
            $postData = $this->request->data;
            $classResult = $this->Custom->fetchClassesForDropDown($this->instituteId);
            if (!empty($postData)) {
                if ($this->Student->validates()) {
                    if ($this->Student->save($postData)) {
                        $msg = ($id > 0) ? __('The Student has been updated.') : __('The Student has been added.');
                        if ($this->request->is('ajax')) {
                            echo json_encode(array(
                                'status' => "success",
                                "message" => $msg,
                                'callback' => array("prefix" => false, "controller" => "students", "action" => "index")
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
            $this->set(compact("id", "classResult"));
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
    }

    /**
     * Delete Students
     * @param int $id Id for delete cms
     * @return Json Data
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function delete($id) {
        if ($id != '' && is_numeric($id)) {
            $result = $this->Student->fetchStudentDetailsById($id);
            if (!empty($result)) {
                $updateData = array(
                    'Student.row_status' => 0
                );
                $conditions = array(
                    'Student.id' => $id,
                    'Student.row_status' => 1
                );
                if ($this->Student->updateStudentDetails($updateData, $conditions)) {
                    echo json_encode(array(
                        'status' => "success",
                        "message" => __('The Student has been deleted.'),
                    ));
                    exit;
                } else {
                    echo json_encode(array(
                        'status' => "error",
                        "message" => __('Something went wrong. Please try again!'),
                    ));
                    exit;
                }
            } else {
                echo json_encode(array(
                    'status' => "error",
                    "message" => __('Something went wrong. Please try again!'),
                ));
                exit;
            }
        } else {
            echo json_encode(array(
                'status' => "error",
                "message" => __('Something went wrong. Please try again!'),
            ));
            exit;
        }
    }

    public function resultsByFilters() {
        if ($this->RequestHandler->responseType() == 'json') {
            $requestedData = array();
            parse_str($this->request->query["Student"], $requestedData);
            $conditions = array(
                'Student.row_status' => 1
            );
            if (!empty($requestedData) && isset($requestedData["data"]) && isset($requestedData["data"]["Student"])) {
                $postData = $requestedData["data"]["Student"];
                if (isset($postData["keyword"]) && $postData["keyword"] != "") {
                    $conditions['OR'] = array(
                        'Student.first_name like' => '%' . $postData["keyword"] . '%',
                        'Student.last_name like' => '%' . $postData["keyword"] . '%',
                        'Student.admission_no like' => '%' . $postData["keyword"] . '%'
                    );
                }
                if (isset($postData["current_class_id"]) && $postData["current_class_id"] != "") {
                    $conditions['Student.current_class_id'] = $postData["current_class_id"];
                }
                if (isset($postData["current_section_id"]) && $postData["current_section_id"] != "") {
                    $conditions['Student.current_section_id'] = $postData["current_section_id"];
                }
            }
            $this->paginate = array(
                'fields' => array(
                    'Student.id',
                    'Student.first_name',
                    'Student.last_name',
                    'Student.admission_no',
                    'Student.date_of_joining',
                    'ClassInfo.name',
                    'Section.name'
                ),
                'joins' => array(
                    array(
                        'table' => 'class_infos',
                        'alias' => 'ClassInfo',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Student.current_class_id = ClassInfo.id',
                            'ClassInfo.row_status' => 1
                        )
                    ),
                    array(
                        'table' => 'sections',
                        'alias' => 'Section',
                        'type' => 'LEFT',
                        'conditions' => array(
                            'Student.current_section_id = Section.id',
                            'Section.row_status' => 1
                        )
                    )
                ),
                'conditions' => $conditions
            );
            $this->DataTable->mDataProp = true;
            $result = $this->DataTable->getResponse();
            $formattedArray = array();
            if (isset($result["aaData"])) {
                foreach ($result["aaData"] as $key => $val):
                    $formattedArray[$key]["Student"]["name"] = '<a href="' . Router::url('/', true) . 'students/profile/' . $val["Student"]["id"] . '">' . implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["Student"]["first_name"]))))) . " " . implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["Student"]["last_name"]))))) . '</a>';
                    $formattedArray[$key]["Student"]["admission_no"] = ($val["Student"]["admission_no"] != "") ? $val["Student"]["admission_no"] : "N/A";
                    $formattedArray[$key]["ClassInfo"]["name"] = implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["ClassInfo"]["name"])))));
                    $formattedArray[$key]["Section"]["name"] = ($val["Section"]["name"] != "") ? implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["Section"]["city"]))))) : "N/A";
                    $formattedArray[$key]["Student"]["date_of_joining"] = date("d/m/Y", strtotime($val["Student"]["date_of_joining"]));
                    $formattedArray[$key]["Student"]["id"] = '<div class="btn-group"><a class="btn-white btn btn-xs" href="' . Router::url('/', true) . 'students/setup/' . $val["Student"]["id"] . '">' . __("Edit") . '</a><a class="btn-white btn btn-xs delete-confirm-alert" href="' . Router::url('/', true) . 'students/delete/' . $val["Student"]["id"] . '" data-message = "You are permenantly deleting this state!">' . __("Delete") . '</a></div>';
                endforeach;
            }
            $result["aaData"] = $formattedArray;
            $this->set('response', $result);
            $this->set('_serialize', 'response');
        }
    }

}

?>