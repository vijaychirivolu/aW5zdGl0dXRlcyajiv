<?php

/**
 * Users Controller
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    UsersController
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
 * Users Controller : User logins, Manage users with options like add,edit and delete
 *
 * @category UsersController
 * @package  Controllers
 * @author   Vijay.Ch <vijay.ch@vendus.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://localhost/cacsv2/index
 */
class UsersController extends AppController {

    public $uses = array('User','UserSession','Institute','UserAccessLevel');
    public $components = array('NotificationEmail','ClientInfo', 'Custom', 'DataTable', 'Csv');

    /**
     * Before filter
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    function beforeFilter() {
        $this->guestActions = array('login', 'forgotPassword');
        $this->superadminActions = array('admin_manage', 'admin_setup', 'logout','admin_delete', 'admin_fetchCitiesByState', 'admin_fetchAddressByCityState', 'admin_fetchInstituteByAddress','changeUserRole');
        $this->adminActions = array('logout','changeUserRole');
        $this->instituteAdminActions = array('logout','changeUserRole');
        $this->branchActions = array('logout','changeUserRole');
        $this->teacherActions = array('logout','changeUserRole');
        $this->accountantActions = array('logout','changeUserRole');
        $this->parentActions = array('logout','changeUserRole');
        parent::beforeFilter();
        $this->UserAuth->allow('login', 'forgotPassword');
        $this->set('active_tab', 'users');
        if ($this->request->is('ajax')) {
            $this->layout = false;
        }
    }

    /**
    * Index function of users
    */
    public function admin_index() {
        
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
     * Save login time
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    private function _saveLogintime() {
        $browserInfo = $this->ClientInfo->browserInfo();
        $userSession = array(
          'UserSession' => array(
              "id" => "",
              'user_id' => $this->UserAuth->user('id'),
              'login_time' => date('Y-m-d H:i:s'),
              'login_ip' => $_SERVER["REMOTE_ADDR"],
              "browser" => $browserInfo["name"],
              "browser_version"=>$browserInfo["version"],
              "os" => $this->ClientInfo->osInfo()
          )  
        );
        if ($this->UserSession->save($userSession)) {
            $userSessionId = $this->UserSession->getLastInsertId();
            $accessLevelResult = $this->UserAccessLevel->fetchAccessDetailsByUserId($this->UserAuth->user('id'));
            $this->Session->write('Auth.User.user_session_id', $userSessionId);
            $this->Session->write('Auth.User.user_role', $accessLevelResult["UserAccessLevel"]["user_role"]);
            $this->Session->write('Auth.User.institute_id', $accessLevelResult["UserAccessLevel"]["institute_id"]);
            $userUpdateData = array(
                'User.last_login_date' => "'" . date('Y-m-d H:i:s') . "'",
                'User.user_session_id' => $userSessionId
            );
            $userConditions =  array(
                'User.id' => $this->UserAuth->user('id'),
                'User.row_status' => 1
            );
            $this->User->updateUserDetails($userUpdateData,$userConditions);
        }
        $this->redirect($this->UserAuth->redirect());
    }

    /**
     * Login Action
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function login() {
        $this->layout = 'login';
        if (!$this->UserAuth->loggedIn()) {
            if ($this->request->is('post')) {
                if ($this->User->validates()) {
                    if ($this->UserAuth->login()) {
                        $this->_saveLogintime();
                    } else {
                        $msg = __('Invalid email or password');
                        $this->_setFlashMsgs($msg, 'danger');
                    }
                } else {
                    $msg = __('Invalid email or password');
                    $this->_setFlashMsgs($msg, 'danger');
                }
            }
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
    }
    /* Forgot Password
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */

    public function admin_updatePassword() {
        $ajaxFlag = false;
        if (!empty($this->request->data)) {
            $ajaxFlag = true;
            
            $postData =$this->request->data;
            if ($this->userId !="") {
               if ($postData["User"]["password"] == $postData["User"]["confirm_password"]) {
                   unset($postData["User"]["confirm_password"]);
                   //pr($postData);exit;
                   $this->User->set($postData);
                   if ($this->User->validates()) {
                       if ($this->User->save($postData)) {
                            $userDetails = $this->User->find('first', array('conditions' => array('User.id' => $this->userId, 'User.row_status' => 1), 'recursive' => -1));
                            $this->Session->write('Auth', $userDetails);
                           if ($this->userType == 2003) {
                               $callBack = array("prefix" => true, "controller" => "cms", "action" => "articles");
                           } else {
                               $callBack = array("prefix" => true, "controller" => "dashboards", "action" => "index");
                           }  
                           echo json_encode(array(
                                'status' => "success",
                                "message" => "Password has been updated.",
                                'callback' => $callBack
                            ));
                            exit;
                       }
                   }
               } 
            }
        }
        $this->set("ajaxFlag",$ajaxFlag);
    }
    /* Forgot Password
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */

    public function forgotPassword() {
        if (!empty($this->request->data)) {
            $data = $this->request->data; //pr($data);exit;
            $conditions = array(
              'User.email' => $data["User"]["email"],
              'User.row_status' => 1  
            );
            $user = $this->User->find('first',array(
                'conditions' => $conditions
            )); 
            //pr($user);exit;
            if (empty($user)) {
                $this->_setFlashMsgs(__('Sorry, the email entered was not found.'), 'danger');
                $this->redirect(array('controller' => 'users', 'action' => 'forgotPassword'));
            } else {
                //echo AuthComponent::password('cacs@123');exit;
                $new_password = $this->Custom->generatePasswordToken($user);
                $user['User']['password'] = "'".AuthComponent::password($new_password)."'"; //pr($user);exit;
                if ($this->User->updateAll(array('Password' => $user['User']['password']),array('id' => $user['User']['id']))) {
                    if($this->NotificationEmail->sendForgotPasswordEmail($user, $new_password)) {
                    $this->_setFlashMsgs(
                            'Password reset instructions have been sent to your email address.
						You have 24 hours to complete the request.', 'success'
                    );
                    $this->redirect(array('controller' => 'users', 'action' => 'login'));
                    }
                }
            }
        }
    }

    /**
     * Manage Users
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function admin_manage() {
        if ($this->RequestHandler->responseType() == 'json') {
            $conditions = array(
                'User.row_status' => 1
            );
            $this->paginate = array(
                'conditions' => $conditions,
                'recursive' => 2
            );
            $this->DataTable->mDataProp = true;
            $result = $this->DataTable->getResponse();
            $formattedArray = array();
            $userRoles = "";
            $instituteName = "";
            if (isset($result["aaData"])) {
                foreach ($result["aaData"] as $key => $val):
                    $formattedArray[$key]["User"]["first_name"] = implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["User"]["first_name"])))))." ".implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["User"]["last_name"])))));
                    $formattedArray[$key]["User"]["email"] = implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["User"]["email"])))));
                    if (!empty($val) && count($val) > 0) {
                        foreach ($val["UserAccessLevel"] as $k=>$res):
                            if ($k > 0) {
                                $userRoles .= ", ";
                            }
                            $userRoles .= implode('-', array_map('ucwords', explode('-', strtolower(addslashes($res["GroupValue"]["name"])))));
                            if ($k == 0) {
                                $instituteName =  (isset($res["Institute"]) && isset($res["Institute"]["name"]) && $res["Institute"]["name"] !="")?implode('-', array_map('ucwords', explode('-', strtolower(addslashes($res["Institute"]["name"]))))):"N/A";
                            }
                            
                        endforeach;
                    }
                    $formattedArray[$key]["GroupValue"]["name"] = $userRoles;
                    $formattedArray[$key]["Institute"]["name"] = $instituteName;
                    $userRoles = "";
                endforeach;
            }
            $result["aaData"] = $formattedArray;
            $this->set('response', $result);
            $this->set('_serialize', 'response');
        }
        //$userdetails = $this->User->fetchUserDetails();
        //pr($userdetails);exit;
        //$this->set(compact('userdetails'));
    }

    /**
     * Setup User (Add ad Edit)
     * @param int $id To find weatheradd or edit
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function admin_setup($id = 0) {
        //echo $id;exit;
        $heading = $id > 0 ? __('Edit User') : __('Add New User');
        $button = $id > 0 ? __('Update user') : __('Add new user');
        $stateResults = $this->Institute->getStates();
        //pr($stateResults);exit;
        $userStateOptions = array();
        $userStateOptions[''] = "Select State";
        $userCityOptions[''] = "Select City";
        $userAddressOptions[''] = "Select Address";
        $userInstituteOptions[''] = "Select Institute";
        if (!empty($stateResults)) {
            foreach($stateResults as $key=>$val):
                if ($val["Institute"]["state"] != "")
                $userStateOptions[$val["Institute"]["state"]] = implode('-', array_map('ucwords', explode('-', strtolower(stripslashes($val["Institute"]["state"])))));
            endforeach;
        }
        //pr($userStateOptions);exit;
        $postData = $this->request->data;
        if (!empty($postData)) {
            if ($id > 0) {
                $result = $this->User->fetchUserDetailsById($id);
                if (!empty($result)) {
                    if ($result["User"]["password"] == $postData["User"]["password"]) {
                        $this->User->validator()->remove('password');
                    }
                }
            }
            $this->User->validator()->remove('email');
            if ($this->User->validates()) {
                $userData["User"] = $postData["User"];
                $msg = ($id > 0) ? __('The User has been updated.') : __('The User has been added.');
                $userResult = $this->User->isEmailExist($userData["User"]["email"]);
                if (!empty($userResult)) {
                    $userData["User"]["id"] = $userResult["User"]["id"];
                }
                if ($this->User->save($userData)) {
                    $lastInsertId = ((!empty($userResult)))?$userResult["User"]["id"]:$this->User->getLastInsertID();
                    if ($lastInsertId !="") {
                        $userAccessLevelData = array(
                            'UserAccessLevel' => array(
                                'user_id' => $lastInsertId,
                                'user_role' => $postData["UserAccessLevel"]["user_role"],
                                'institute_id' => $postData["UserAccessLevel"]["institute_id"]
                            )
                        );
                        if ($this->UserAccessLevel->save($userAccessLevelData)) {
                            if ($this->request->is('ajax')) {
                                echo json_encode(array(
                                    'status' => "success",
                                    "message" => $msg,
                                    'callback' => array("prefix" => true, "controller" => "users", "action" => "manage")
                                ));
                                exit;
                            } else {
                                $this->_setFlashMsgs($msg, 'success');
                                $this->redirect(array('action' => 'manage'));
                            }
                        } else {
                            
                        }
                    }
                } else {
                    
                }
            } else {
                $msg = __('Saving failed due to below errors!');
                $this->_setFlashMsgs($msg, 'danger');
            }
        } else {
            if ($id > 0) {
                $result = $this->User->fetchUserDetailsById($id);
                $cityResults = $this->Institute->getCitiesByStateName($result['Institute']['state']);
                if (!empty($cityResults)) {
                    foreach($cityResults as $key=>$val):
                        $userCityOptions[$val['Institute']["city"]] = implode('-', array_map('ucwords', explode('-', strtolower(stripslashes($val['Institute']["city"])))));
                    endforeach;
                }
                $addressResults = $this->Institute->getAddressByCityStateName($result['Institute']['state'], $result['Institute']['city']);
                if (!empty($addressResults)) {
                    foreach($addressResults as $key=>$val):
                        $userAddressOptions[$val['Institute']["street_address"]] = implode('-', array_map('ucwords', explode('-', strtolower(stripslashes($val['Institute']["street_address"])))));
                    endforeach;
                }
                $addressResults = $this->Institute->getInstituteNameByAddress($result['Institute']['state'], $result['Institute']['city'], $result['Institute']['street_address']);
                if (!empty($addressResults)) {
                    foreach($addressResults as $key=>$val):
                        $userInstituteOptions[$val['Institute']["id"]] = implode('-', array_map('ucwords', explode('-', strtolower(stripslashes($val['Institute']["name"])))));
                        //$userInstituteOptions[$key]['id'] = implode('-', array_map('ucwords', explode('-', strtolower(stripslashes($val['Institute']["id"])))));
                    endforeach;
                }
                if (!empty($result)) {
                    $result['User']['user_state'] = $result['Institute']['state'];
                    $result['User']['user_city'] = $result['Institute']['city'];
                    $result['User']['user_address'] = $result['Institute']['street_address'];
                    $result['User']['school_id'] = $result['Institute']['id'];
                }
                $this->request->data = $result;
            }
        }
        $this->set('heading', $heading);
        $this->set('button', $button);
        $this->set('userStateOptions', $userStateOptions);
        $this->set('userCityOptions', $userCityOptions);
        $this->set('userAddressOptions', $userAddressOptions);
        $this->set('userInstituteOptions', $userInstituteOptions);
    }

    /**
     * Admin_fetchCitiesByStateId
     * @return Json Data
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function admin_fetchCitiesByState() {
        $postData = $this->request->data;
        $stateName = (isset($postData) && isset($postData["state"]) && $postData["state"] !="")?$postData["state"]:"";
        $userCityOptions = array();
        if ($stateName !="") {
            $cityResults = $this->Institute->getCitiesByStateName($stateName);
            //echo "<pre>"; print_r($cityResults);exit;
            if (!empty($cityResults)) {
                foreach($cityResults as $key=>$val):
                    $userCityOptions[$key] = implode('-', array_map('ucwords', explode('-', strtolower(stripslashes($val['Institute']["city"])))));
                endforeach;
            }
        }
        //echo "<pre>"; print_r($userCityOptions);exit;
        $this->autoRender = false;
        echo json_encode($userCityOptions);
        exit;
        //$this->set("userCityOptions",$userCityOptions);
    }

    /**
     * Admin_fetchCitiesByStateId
     * @return Json Data
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function admin_fetchAddressByCityState() {
        $postData = $this->request->data;
        $stateName = (isset($postData) && isset($postData["state"]) && $postData["state"] !="")?$postData["state"]:"";
        $cityName = (isset($postData) && isset($postData["city"]) && $postData["city"] !="")?$postData["city"]:"";
        $userAddressOptions = array();
        if ($stateName !="" && $cityName != "") {
            $addressResults = $this->Institute->getAddressByCityStateName($stateName, $cityName);
            if (!empty($addressResults)) {
                foreach($addressResults as $key=>$val):
                    $userAddressOptions[$key] = implode('-', array_map('ucwords', explode('-', strtolower(stripslashes($val['Institute']["street_address"])))));
                endforeach;
            }
        }
        //echo "<pre>"; print_r($userCityOptions);exit;
        $this->autoRender = false;
        echo json_encode($userAddressOptions);
        exit;
        //$this->set("userCityOptions",$userCityOptions);
    }

    /**
     * Admin_fetchInstituteByAddress
     * @return Json Data
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function admin_fetchInstituteByAddress() {
        $postData = $this->request->data;
        $stateName = (isset($postData) && isset($postData["state"]) && $postData["state"] !="")?$postData["state"]:"";
        $cityName = (isset($postData) && isset($postData["city"]) && $postData["city"] !="")?$postData["city"]:"";
        $address = (isset($postData) && isset($postData["address"]) && $postData["address"] !="")?$postData["address"]:"";
        $userInstituteOptions = array();
        if ($stateName !="" && $cityName != "") {
            $addressResults = $this->Institute->getInstituteNameByAddress($stateName, $cityName, $address);
            if (!empty($addressResults)) {
                foreach($addressResults as $key=>$val):
                    $userInstituteOptions[$key]['name'] = implode('-', array_map('ucwords', explode('-', strtolower(stripslashes($val['Institute']["name"])))));
                $userInstituteOptions[$key]['id'] = implode('-', array_map('ucwords', explode('-', strtolower(stripslashes($val['Institute']["id"])))));
                endforeach;
            }
        }
        //echo "<pre>"; print_r($userCityOptions);exit;
        $this->autoRender = false;
        echo json_encode($userInstituteOptions);
        exit;
        //$this->set("userCityOptions",$userCityOptions);
    }

    /**
     * Admin Logout
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function logout() {
        if ($this->UserAuth->user()) { 
            $userSessionUpdateData = array(
              'UserSession.logout_time'=> "'" . date('Y-m-d H:i:s') . "'"  
            );
            $userSessionConditions =  array(
                'UserSession.id' => $this->userSessionId,
                'UserSession.row_status' => 1
            );
            //pr($userSessionConditions);
            //exit;
            $this->UserSession->updateUserSessionDetails($userSessionUpdateData,$userSessionConditions);
            $this->Session->destroy();
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        } else {
            $this->Session->_setFlashMsgs(__('Not logged in'), 'danger');
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
    }

    /**
     * Delete User
     * @param int $id Id for delete user
     * @return Json Data
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function admin_delete($id) {
        if ($id != '' && is_numeric($id)) {
            $result = $this->User->fetchUserDetailsById($id);
            if (!empty($result)) {
                $updateData = array(
                    'User.row_status' => 0
                );
                $conditions = array(
                    'User.id' => $id,
                    'User.row_status' => 1
                );
                if ($this->User->updateUserDetails($updateData, $conditions)) {
                    echo json_encode(array(
                        'status' => "success",
                        "message" => __('The User has been deleted.'),
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
    
    public function changeUserRole($accessLevelId) {
        if ($accessLevelId !="" && is_numeric($accessLevelId)) {
            $accessLevelResult = $this->UserAccessLevel->fetchAccessDetailsById($accessLevelId);
            if (!empty($accessLevelResult)) {
                $this->Session->write('Auth.User.user_role', $accessLevelResult["UserAccessLevel"]["user_role"]);
                $this->Session->write('Auth.User.institute_id', $accessLevelResult["UserAccessLevel"]["institute_id"]);
            }
            $this->redirect($this->UserAuth->redirect());
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
    }

}

?>