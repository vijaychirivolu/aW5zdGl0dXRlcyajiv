<?php

/**
 * Classes Controller
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    ClassesController
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
 * Classes Controller : User logins, Manage users with options like add,edit and delete
 *
 * @category ClassesController
 * @package  Controllers
 * @author   Vijay.Ch <vijay.ch@vendus.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://localhost/cacsv2/index
 */
class ClassesController extends AppController {

    public $uses = array('ClassInfo');
    
    /**
     * Before filter
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    function beforeFilter() {
        $this->guestActions = array();
        $this->superadminActions = array();
        $this->instituteAdminActions = array('index','setup','delete');
        $this->adminActions = array();
        $this->userActions = array();
        parent::beforeFilter();
        $this->UserAuth->allow();
        $this->set('active_tab', 'holidays');
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
        $classesList = $this->ClassInfo->fetchClassInfosDetailsByInstituteId($this->instituteId);
        $this->set(compact("classesList"));
    }

    /**
     * Add,Edit Actions
     * @param array $user User Session data
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function setup($id = 0) {
        $postData = $this->request->data;
        if (!empty($postData)) {
            if ($this->ClassInfo->validates()) {
                if ($this->ClassInfo->save($postData)) {
                    $msg = ($id > 0) ? __('The Class has been updated.') : __('The Class has been added.');
                    if ($this->request->is('ajax')) {
                        echo json_encode(array(
                            'status' => "success",
                            "message" => $msg,
                            'callback' => array("prefix" => false, "controller" => "classes", "action" => "index")
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
                $result = $this->ClassInfo->fetchClassInfoDetailsById($id);
                $this->request->data = $result;
            }
        }
        $this->set("id",$id);
    }
    
    /**
     * Delete Classes
     * @param int $id Id for delete cms
     * @return Json Data
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function delete($id) {
        if ($id != '' && is_numeric($id)) {
            $result = $this->ClassInfo->fetchClassInfoDetailsById($id);
            if (!empty($result)) {
                $updateData = array(
                    'ClassInfo.row_status' => 0
                );
                $conditions = array(
                    'ClassInfo.id' => $id,
                    'ClassInfo.row_status' => 1
                );
                if ($this->ClassInfo->updateClassInfoDetails($updateData, $conditions)) {
                    echo json_encode(array(
                        'status' => "success",
                        "message" => __('The Class has been deleted.'),
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
}

?>