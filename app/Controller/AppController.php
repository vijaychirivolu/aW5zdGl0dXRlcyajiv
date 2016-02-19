<?php

/**
 * Application leval Controller: Here we load the default libraries
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    Controllers
 * @package     AppController
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 * @dateCreated 07/10/2015  MM/DD/YYYY
 * @dateUpdated 07/10/2015  MM/DD/YYYY 
 * @functions   2
 */
App::uses('Controller', 'Controller');
App::import('Component', 'UserAuth');
App::uses('CakeNumber', 'Utility');
/**
 * App Controller
 *
 * @category Controllers
 * @package  AppController
 * @author   Vijay.Ch <vijay.ch@vendus.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://localhost/cacsv2/index
 */
class AppController extends Controller {
    
    public $userId = '';
    public $userRole = '';
    public $userSessionId = "";
    public $instituteId = "";
    public $userName = "";
    
    public $metaTitle = 'Schools';
    public $metaDescription = 'Schools App';
    public $metaKeywords = '';
    
    public $guestActions = array();
    public $superAdminActions = array();
    public $adminActions = array();
    public $instituteAdminActions = array();
    public $branchActions = array();
    public $teacherActions = array();
    public $accountantActions = array();
    public $parentActions = array();
    
    public $uses = array('User','UserAccessLevel');
    
    public $helpers = array(
        'Session',
        'Timthumb.Timthumb',
        'Form' => array('className' => 'AppForm')
    );
    public $components = array(
        'Acl',
        'Session',
        'Email',
        'Paginator',
        'RequestHandler',
        'Cookie',
        'UserAuth' => array(
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email'),
                    'scope' => array('User.row_status' => 1,'User.status'=>2001),
                )
            ),
            'authorize' => array('Controller')
        ),
    );

    /**
     * Before filter action
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function beforeFilter() {
        //echo AuthComponent::password('schools@1405');exit;
        //ini_set('upload_max_filesize', '10M');
        /*if (isset($this->request->params['admin']) || isset($this->request->params['school'])) {
            $this->layout = "admin";
        }*/
        $this->layout = "admin";
        if ($this->params['controller'] == "institutes" && $this->params['action'] == 'admin_index') {
            $this->Session->delete('instituteId');
        }
        $this->userId = ($this->Session->check('id')) ? $this->Session->read('id') : $this->UserAuth->user('id');
        $this->userRole = ($this->Session->check('user_role')) ? $this->Session->read('user_role') : $this->UserAuth->user('user_role');
        $this->userSessionId = ($this->Session->check('user_session_id')) ? $this->Session->read('user_session_id') : $this->UserAuth->user('user_session_id');
        if ($this->Session->check('first_name') && $this->Session->check('last_name')) {
            $this->userName = ucwords(stripslashes($this->Session->read('first_name')))." ".ucwords(stripslashes($this->Session->read('last_name')));
        } else {
            $this->userName = ucwords(stripslashes($this->UserAuth->user('first_name')))." ".ucwords(stripslashes($this->UserAuth->user('last_name')));
        }
        $this->instituteId = ($this->Session->check('institute_id')) ? $this->Session->read('institute_id') : $this->UserAuth->user("institute_id");
        $accessLevelResult = array();
        if ($this->userId !="") {
            $accessLevelResult = $this->UserAccessLevel->fetchAllAccessDetailsByUserId($this->userId);
        }
        
        
        
        $this->set('userId', $this->userId);
        $this->set('userRole', $this->userRole);
        $this->set('instituteId', $this->instituteId);
        $this->set('userName',$this->userName);
        $this->set('userSessionId',$this->userSessionId);
        $this->set('accessLevelResult', $accessLevelResult);
        $this->set('metaTitle', $this->metaTitle);
        $this->set('metaDescription', $this->metaDescription);
        $this->set('metaKeywords', $this->metaKeywords);
    }
    
    /**
     *  Checked Authorized user or not
     *
     * @return boolean True or false
     * @param array $user User Auth array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function isAuthorized($user) {
        return false;
    }
    
    /**
     *  Checking Autentication for controlelr and actions
     * @return boolean True or false
     * @param array $user User Auth array
     * @param string $action Action name
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function __checkAuthentication($user, $action) {
        $action = $this->action;
        $authFlag = false;
        $role = $this->UserAuth->user("user_role");
        switch ($role) {
            case 1001:
                if (in_array($action, $this->superadminActions)) {
                    $authFlag = true;
                    $action = 'index';
                }
                break;
            case 1002:
                if (in_array($action, $this->adminActions)) {
                    $authFlag = true;
                    $action = 'index';
                }
                break;
            case 1003:
                if (in_array($action, $this->instituteAdminActions)) {
                    $authFlag = true;
                    $action = 'index';
                }
                break;
            case 1004:
                if (in_array($action, $this->branchActions)) {
                    $authFlag = true;
                    $action = 'index';
                }
                break;
            case 1005:
                if (in_array($action, $this->teacherActions)) {
                    $authFlag = true;
                    $action = 'index';
                }
                break;
            case 1006:
                if (in_array($action, $this->accountantActions)) {
                    $authFlag = true;
                    $action = 'index';
                }
                break;
            case 1007:
                if (in_array($action, $this->parentActions)) {
                    $authFlag = true;
                    $action = 'index';
                }
                break;    
            default:
                if (in_array($action, $this->guestActions)) {
                    $authFlag = true;
                    $action = 'index';
                }
                break;
        }

        if (!$authFlag) {
            $this->_setFlashMsgs(__('You are not authorized for this action'), 'danger');
            $this->redirect($this->UserAuth->redirect());
            return false;
        } else {
            return true;
        }
        return self::isAuthorized($user);
    }

    /**
     *  Set flash messages
     *
     * @return void
     * @param string $msg message description
     * @param string $type message type sucess or failure
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function _setFlashMsgs($msg = '', $type = 'info') {
        $html = '<div class="alert alert-'.$type.' alert-dismissable">';
        $html .= '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>';
        $html .= $msg;
        $html .= '</div>';
        $this->Session->setFlash($html);
    }

}

?>