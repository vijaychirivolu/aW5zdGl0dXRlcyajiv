<?php

/**
 * Holidays Controller
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    HolidaysController
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
 * Holidays Controller : User logins, Manage users with options like add,edit and delete
 *
 * @category HolidaysController
 * @package  Controllers
 * @author   Vijay.Ch <vijay.ch@vendus.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://localhost/cacsv2/index
 */
class HolidaysController extends AppController {

    public $uses = array('Holiday');
    
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
        $holidaysList = $this->Holiday->fetchHolidaysDetailsByInstituteId($this->instituteId);
        $this->set(compact("holidaysList"));
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
            if ($this->Holiday->validates()) {
                if ($this->Holiday->save($postData)) {
                    $msg = ($id > 0) ? __('The Holiday has been updated.') : __('The Holiday has been added.');
                    if ($this->request->is('ajax')) {
                        echo json_encode(array(
                            'status' => "success",
                            "message" => $msg,
                            'callback' => array("prefix" => false, "controller" => "holidays", "action" => "index")
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
                $result = $this->Holiday->fetchHolidayDetailsById($id);
                $this->request->data = $result;
            }
        }
        $this->set("id",$id);
    }
    
    /**
     * Delete Holidays
     * @param int $id Id for delete cms
     * @return Json Data
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function delete($id) {
        if ($id != '' && is_numeric($id)) {
            $result = $this->Holiday->fetchHolidayDetailsById($id);
            //pr($result);exit;
            if (!empty($result)) {
                $updateData = array(
                    'Holiday.row_status' => 0
                );
                $conditions = array(
                    'Holiday.id' => $id,
                    'Holiday.row_status' => 1
                );
                if ($this->Holiday->updateHolidayDetails($updateData, $conditions)) {
                    echo json_encode(array(
                        'status' => "success",
                        "message" => __('The Holiday has been deleted.'),
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