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

    public $uses = array('School');
    public $components = array('NotificationEmail');

    /**
     * Before filter
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    function beforeFilter() {
        $this->guestActions = array();
        $this->superadminActions = array('admin_index','school_account');
        $this->adminActions = array();
        $this->schoolAdminActions = array('index');
        $this->branchActions = array('index');
        $this->userActions = array();
        parent::beforeFilter();
        $this->UserAuth->allow();
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
        
    }

    public function school_account($schoolId) {
        $isExists = $this->School->isSchoolExistsById($schoolId);
        if ($isExists) {
            $this->Session->write('schoolId', $schoolId);
            return $this->redirect(array('controller' => 'galleries', 'action' => 'school_index'));
        } else {
            return $this->redirect(array('controller' => 'schools', 'action' => 'admin_index'));
        }
    }

}

?>