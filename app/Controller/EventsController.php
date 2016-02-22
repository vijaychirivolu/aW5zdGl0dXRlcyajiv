<?php

/**
 * Events Controller
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    EventsController
 * @package     Controllers
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 * @dateCreated 07/17/2015  MM/DD/YYYY
 * @dateUpdated 07/17/2015  MM/DD/YYYY 
 * @functions   2
 */
App::uses('AppController', 'Controller');
App::uses('File', 'Utility');

/**
 * Events Controller : User logins, Manage users with options like add,edit and delete
 *
 * @category EventsController
 * @package  Controllers
 * @author   Vijay.Ch <vijay.ch@vendus.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://localhost/cacsv2/index
 */
class EventsController extends AppController {

    public $uses = array('Events',"ClassInfo");
    public $components = array('NotificationEmail', 'DataTable', 'Custom', 'Csv');

    /**
     * Before filter
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    function beforeFilter() {
        $this->guestActions = array();
        $this->superadminActions = array('admin_index', 'admin_setup', 'admin_uploadEventData');
        $this->adminActions = array();
        $this->instituteAdminActions = array('index', 'setup');
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
        if ($this->RequestHandler->responseType() == 'json') {
            $this->paginate = array(
                'fields' => array(
                    'Event.id',
                    'Event.name',
                    'Event.registration_no',
                    'Event.street_address',
                    'Event.city'
                ),
                'conditions' => array(
                    'Event.row_status' => 1
                )
            );
            $this->DataTable->mDataProp = true;
            $result = $this->DataTable->getResponse();
            //pr($result);exit;
            $formattedArray = array();
            if (isset($result["aaData"])) {
                foreach ($result["aaData"] as $key => $val):
                    $formattedArray[$key]["Event"]["name"] = '<a href="' . Router::url('/', true) . 'school/dashboards/account/' . $val["Event"]["id"] . '">' . implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["Event"]["name"]))))) . '</a>';
                    $formattedArray[$key]["Event"]["registration_no"] = ($val["Event"]["registration_no"] != "") ? $val["Event"]["registration_no"] : "N/A";
                    $formattedArray[$key]["Event"]["street_address"] = implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["Event"]["street_address"])))));
                    $formattedArray[$key]["Event"]["city"] = implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["Event"]["city"])))));
                    $formattedArray[$key]["Event"]["id"] = '<div class="btn-group"><a class="btn btn-white" href="' . Router::url('/', true) . 'admin/schools/setup/' . $val["Event"]["id"] . '">' . __("Edit") . '</a><a class="btn btn-white delete-confirm-alert" href="' . Router::url('/', true) . 'admin/states/delete/' . $val["Event"]["id"] . '" data-message = "You are permenantly deleting this state!">' . __("Delete") . '</a></div>';
                endforeach;
            }
            $result["aaData"] = $formattedArray;
            $this->set('response', $result);
            $this->set('_serialize', 'response');
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
        if ($this->instituteId !="") {
            $postData = $this->request->data;
            $classSectionResults = $this->ClassInfo->fetchClassSectionsResultsByInstitueId($this->instituteId);
            $studentResults = array();
            if (!empty($postData)) {
                if ($this->Event->validates()) {
                    if ($this->Event->save($postData)) {
                        $msg = ($id > 0) ? __('The Event has been updated.') : __('The Event has been added.');
                        if ($this->request->is('ajax')) {
                            echo json_encode(array(
                                'status' => "success",
                                "message" => $msg,
                                'callback' => array("prefix" => true, "controller" => "states", "action" => "index")
                            ));
                            exit;
                        } else {
                            $this->_setFlashMsgs($msg, 'success');
                            $this->redirect(array('action' => 'admin_index'));
                        }
                    }
                }
            } else {
                if ($id > 0) {
                    $result = $this->Event->fetchStateDetailsById($id);
                    $this->request->data = $result;
                }
            }
            $this->set(compact("id","classSectionResults","studentResults"));
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
        
    }
}
?>