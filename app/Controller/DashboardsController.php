<?php

/**
 * Dashboards Controller
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    DashboardsController
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
 * Dashboards Controller : User logins, Manage users with options like add,edit and delete
 *
 * @category DashboardsController
 * @package  Controllers
 * @author   Vijay.Ch <vijay.ch@vendus.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://localhost/cacsv2/index
 */
class DashboardsController extends AppController {

    public $uses = array('Institute');
    public $components = array('NotificationEmail','Dashboards');

    /**
     * Before filter
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    function beforeFilter() {
        $this->guestActions = array();
        $this->superadminActions = array('admin_index','account');
        $this->adminActions = array();
        $this->instituteAdminActions = array('index');
        $this->branchActions = array('index');
        $this->teacherActions = array('index');
        $this->accountantActions = array('index');
        $this->parentActions = array('index');
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
    public function admin_index() {
    }
    
    /**
     * School or Branch Index
     * @param array $user User Session data
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function index() {
        if ($this->instituteId != "") {
            $this->set('StudentCount',$this->Dashboards->getStudentCntByInstituteId($this->instituteId));
            $this->set('EmployeeCount',$this->Dashboards->getEmployeeCntByInstituteId($this->instituteId));
            $this->set('NewMsgCnt',$this->Dashboards->getNewMessageCntByRecieverId($this->instituteId,  $this->userId));
            $this->set('NewMsg',$this->Dashboards->getNewMessagesByRecieverId($this->instituteId, $this->userId));
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
    }

    public function account($instituteId) {
        $isExists = $this->Institute->isInstituteExistsById($instituteId);
        if ($isExists) {
            $this->Session->write('Auth.User.user_role', 1003);
            $this->Session->write('Auth.User.institute_id', $instituteId);
            return $this->redirect(array('controller' => 'dashboards', 'action' => 'index'));
        } else {
            return $this->redirect(array('controller' => 'schools', 'action' => 'admin_index'));
        }
    }

}

?>