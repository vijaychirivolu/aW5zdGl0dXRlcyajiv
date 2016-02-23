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
class MessagesController extends AppController {

    public $uses = array('MessageReceiver','User', 'Message', 'MessageAttachment');
    public $components = array('NotificationEmail','DataTable','Custom');

    /**
     * Before filter
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    function beforeFilter() {
        $accessArray = array('index','composeEmail', 'viewMessage','getUserEmails','sentMail','downloaddoc','downloadall','createZipFile','trashMessages','moveMessageToTrash','trashById');
        $this->guestActions = array();
        $this->superadminActions = array('admin_inbox','index','composeEmail');
        $this->adminActions = array();
        $this->instituteAdminActions = $accessArray;
        $this->branchActions = $accessArray;
        $this->userActions = $accessArray;
        $this->teacherActions = $accessArray;
        $this->accountantActions = $accessArray;
        $this->parentActions = $accessArray;
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
     * Inbox
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
        $userdata = $this->Session->read('Auth.User');
        /*$messages = $this->MessageReceiver->fetchUserMessages($userdata);
        $this->set('messages', $messages);*/
        if ($this->RequestHandler->responseType() == 'json') {
            $conditions = array(
                                'MessageReceiver.row_status' => 1, 
                                'MessageReceiver.receiver_id ' => $userdata["id"], 
                                'Messages.institute_id '=> $userdata["institute_id"], 
                                'MessageReceiver.type' => 12001
                               );
            $this->paginate = array(
                'fields' => array(
                    'MessageReceiver.id',
                    'MessageReceiver.status',
                    'Messages.id',
                    'Messages.subject',
                    'Messages.time_created',
                    'Users.first_name'
                ),
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'table' => 'messages',
                        'alias' => 'Messages',
                        'type' => 'left',
                        'conditions' => array('MessageReceiver.message_id = Messages.id')
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'left',
                        'conditions' => array('Messages.sender_id = Users.id')
                    )
                )
            );
            $this->DataTable->mDataProp = true;
            $result = $this->DataTable->getResponse();
            //pr($result);exit;
            $formattedArray = array();
            if (isset($result["aaData"])) {
                foreach ($result["aaData"] as $key => $val):
                    $formattedArray[$key]["MessageReceiver"]["id"] = '<input type="checkbox" class="check-message" name="readstatus[]" value="'.$val['MessageReceiver']['id'].'">';
                    $formattedArray[$key]["Users"]["first_name"] = '<a href="' . Router::url('/', true) . 'messages/viewMessage/inbox/' . $val["Messages"]["id"] . '">'.ucwords($val['Users']['first_name']).'</a>';
                    $formattedArray[$key]["MessageReceiver"]["status"] = $val['MessageReceiver']['status'];
                    $formattedArray[$key]["Messages"]["subject"] = '<a href="' . Router::url('/', true) . 'messages/viewMessage/inbox/' . $val["Messages"]["id"] . '">'.$val['Messages']['subject'].'</a>';
                    $formattedArray[$key]["Messages"]["time_created"] = date("H:m A", strtotime($val['Messages']['time_created']));
                endforeach;
            }
            $result["aaData"] = $formattedArray;
            $this->set('response', $result);
            $this->set('_serialize', 'response');
        }
    }

    public function composeEmail($id=0) {
        $postData = $this->request->data;
        if (!empty($postData)) {
            if (isset($postData['Message']['file']) && $postData['Message']['file'][0]['name'] != "" && $postData["Message"]['file'][0]["error"] == 0) {
                $postData['Message']['has_attechments'] = count($postData['Message']['file']);
            }
            //pr($postData);exit;
            $result = $this->Message->saveMessage($postData);
            $postData['Message']['message_id'] = $result['Message']['id'];
            $result = $this->MessageReceiver->saveMessageReceiver($postData);
            if (isset($postData['Message']['file']) && $postData['Message']['file'][0]['name'] != "" && $postData["Message"]['file'][0]["error"] == 0) {
                $postData['Message']['has_attachments'] = count($postData['Message']['file']);
                $uploadHistoryData['MessageAttachment'] = array();
                for ($i = 0; $i < count($postData['Message']['file']); $i++) {
                    $filename = explode('.', $postData["Message"]['file'][$i]["name"]);
                    $extension = strtolower(end($filename));
                    $filename = round(microtime(true)) . rand() . "." . $extension;
                    if (move_uploaded_file($postData["Message"]['file'][$i]['tmp_name'], WWW_ROOT . 'files/attachments/' . $filename)) {
                        $file = new File(WWW_ROOT . "files/attachments/" . $filename, false, 0777);
                        $uploadHistoryData['MessageAttachment'][$i] = array (
                                                                           "id" => "",
                                                                           "message_id" => $postData['Message']['message_id'],
                                                                           "original_filename" => $postData['Message']['file'][$i]['name'],
                                                                           "filename" => $filename
                                                                      );
                    }
                }
                $result = $this->MessageAttachment->saveUserAttachments($uploadHistoryData);
            }
            if ($result) {
                $msg = __('You mail sent succesfully.');
                if ($this->request->is('ajax')) {
                    echo json_encode(array(
                        'status' => "success",
                        "message" => $msg,
                        'callback' => array("prefix" => false, "controller" => "messages", "action" => "sentMail")
                    ));
                    exit;
                } else {
                    $this->_setFlashMsgs($msg, 'success');
                    $this->redirect(array('action' => 'sentMail'));
                }
            } else {
                if ($this->request->is('ajax')) {
                    echo json_encode(array(
                        'status' => "success",
                        "message" => $msg
                    ));
                    exit;
                } else {
                    $msg = __('Mail Sending failed due to below errors!');
                    $this->_setFlashMsgs($msg, 'danger');
                }
            }
        } else {
                if ($this->request->is('ajax')) {
                    echo json_encode(array(
                        'status' => "success",
                        "message" => $msg
                    ));
                    exit;
                } else {
                    $msg = __('Mail Sending failed due to below errors!');
                    $this->_setFlashMsgs($msg, 'danger');
                }
            }
    }
    
    public function getUserEmails() {
        $where_array['term'] = $_GET['q'];
        $users = $this->User->fetchAllUsers($where_array);
        $temp = array();
        foreach ($users as $key => $value) {
            $temp[$key]['id'] = $value['User']['id'];
            $temp[$key]['email'] = $value['User']['email'];
            $temp[$key]['name'] = $value['User']['first_name']." ".$value['User']['last_name'];
        }
        echo json_encode($temp);
        exit;
    }

    public function viewMessage($type = "", $id = 0) {
        $conditions = array(
                            "MessageReceiver.message_id" => $id,
                            "MessageReceiver.receiver_id" => AuthComponent::user('id'),
                            "MessageReceiver.row_status" => 1
                          );
        $updateData = array(
                        "MessageReceiver.status" => 10001
                      );
        $result = $this->MessageReceiver->updateMessageStatus($updateData, $conditions);
        $message_details = array();
        if ($result) {
            if ($type == "inbox" && $id != 0) {
                $message_details = $this->Message->fetchMessageDetailsById($type, $id);
            } else if ($type == "outbox" && $id != 0) {
                $message_details = $this->Message->fetchMessageDetailsById($type, $id);
            } else if ($type == "trash" && $id != 0) {
                $message_details = $this->Message->fetchMessageDetailsById($type, $id);
            } else {
                $msg = __('Something went wrong!');
                $this->_setFlashMsgs($msg, 'danger');
                $this->redirect(array("controller" => "messages", "action" => "index"),$exit);
            }
            $this->set('messageinfo', $message_details);
            $this->set('type', $type);
        } else {
            $msg = __('Something went wrong!');
            $this->_setFlashMsgs($msg, 'danger');
           $this->redirect(array("controller" => "messages", "action" => "index"),$exit);
        }
    }
    
    public function sentMail() {
        $userdata = $this->Session->read('Auth.User');
        if ($this->RequestHandler->responseType() == 'json') {
            $conditions = array(
                                'MessageReceiver.row_status' => 1, 
                                'MessageReceiver.receiver_id ' => $userdata["id"], 
                                'Messages.institute_id '=> $userdata["institute_id"], 
                                'MessageReceiver.type' => 12002
                               );
            $this->paginate = array(
                'fields' => array(
                    'MessageReceiver.id',
                    'MessageReceiver.status',
                    'Messages.id',
                    'Messages.subject',
                    'Messages.time_created',
                    'group_concat(Users.first_name) user_names',
                    'MessageReceiver.message_id'
                ),
                'conditions' => $conditions,
                'group' => array('MessageReceiver.message_id'), 
                'joins' => array(
                    array(
                        'table' => 'messages',
                        'alias' => 'Messages',
                        'type' => 'left',
                        'conditions' => array('MessageReceiver.message_id = Messages.id',)
                    ),
                    array(
                        'table' => 'message_receivers',
                        'alias' => 'MessageReceiver1',
                        'type' => 'inner',
                        'conditions' => array('MessageReceiver.message_id = MessageReceiver1.message_id','MessageReceiver1.type = 12001')
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'left',
                        'conditions' => array('MessageReceiver1.receiver_id = Users.id')
                    )
                )
            );
            $this->DataTable->mDataProp = true;
            $result = $this->DataTable->getResponse();
            //pr($result);exit;
            $formattedArray = array();
            if (isset($result["aaData"])) {
                foreach ($result["aaData"] as $key => $val):
                    $formattedArray[$key]["MessageReceiver"]["id"] = '<input type="checkbox" class="check-message" name="read_status" id="read_status" value="'.$val['MessageReceiver']['id'].'">';
                    $formattedArray[$key]["Users"]["first_name"] = '<a href="' . Router::url('/', true) . 'messages/viewMessage/outbox/' . $val["Messages"]["id"] . '" class="message-receviers">'.ucwords($val[0]['user_names']).'</a><span>'.((count(explode(",", $val[0]['user_names']))>1)?"(".count(explode(",", $val[0]['user_names'])).")":"").'</span>';
                    $formattedArray[$key]["MessageReceiver"]["status"] = $val['MessageReceiver']['status'];
                    $formattedArray[$key]["Messages"]["subject"] = '<a href="' . Router::url('/', true) . 'messages/viewMessage/outbox/' . $val["Messages"]["id"] . '">'.$val['Messages']['subject'].'</a>';
                    $formattedArray[$key]["Messages"]["time_created"] = date("H:m A", strtotime($val['Messages']['time_created']));
                endforeach;
            }
            $result["aaData"] = $formattedArray;
            $this->set('response', $result);
            $this->set('_serialize', 'response');
    }
}

public function downloaddoc($name = "") {
    //$this->viewClass = 'Media';
    $path = WWW_ROOT."files/attachments/".$name;
    $this->response->file($path, array(
        'download' => true,
        'name' => $name
    ));
    return $this->response;
}

public function downloadall($id = "") {
    $filenames = $this->MessageAttachment->getAllFileNames($id);
    $filenameArray = array();
    foreach ($filenames as $key => $val) {
        array_push($filenameArray, $val['MessageAttachment']['filename']);
    }
    //pr($filenameArray);exit;
    $path = WWW_ROOT."files/attachments/";
    $this->createZipFile($filenameArray, $path);
    
}

function createZipFile($filenameArray, $file_path) {
    $zip = new ZipArchive();
    $filename = "Attachments".time().".zip";

    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
        exit("cannot open <$filename>\n");
    }

    foreach($filenameArray as $files)
    {
        $zip->addFile($file_path.$files,$files);
    }
    $zip->close();
    //then send the headers to foce download the zip file
    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$filename);
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
    exit;
}
public function trashMessages() {
    $userdata = $this->Session->read('Auth.User');
        /*$messages = $this->MessageReceiver->fetchUserMessages($userdata);
        $this->set('messages', $messages);*/
        if ($this->RequestHandler->responseType() == 'json') {
            $conditions = array(
                                'MessageReceiver.row_status' => 1, 
                                'MessageReceiver.receiver_id ' => $userdata["id"], 
                                'Messages.institute_id '=> $userdata["institute_id"], 
                                'MessageReceiver.type' => 12003
                               );
            $this->paginate = array(
                'fields' => array(
                    'MessageReceiver.id',
                    'MessageReceiver.status',
                    'Messages.id',
                    'Messages.subject',
                    'Messages.time_created',
                    'Users.first_name'
                ),
                'conditions' => $conditions,
                'joins' => array(
                    array(
                        'table' => 'messages',
                        'alias' => 'Messages',
                        'type' => 'left',
                        'conditions' => array('MessageReceiver.message_id = Messages.id',)
                    ),
                    array(
                        'table' => 'users',
                        'alias' => 'Users',
                        'type' => 'left',
                        'conditions' => array('Messages.sender_id = Users.id')
                    )
                )
            );
            $this->DataTable->mDataProp = true;
            $result = $this->DataTable->getResponse();
            //pr($result);exit;
            $formattedArray = array();
            if (isset($result["aaData"])) {
                foreach ($result["aaData"] as $key => $val):
                    $formattedArray[$key]["MessageReceiver"]["id"] = '<input type="checkbox" class="" name="readstatus[]" id="read_status" value="'.$val['MessageReceiver']['id'].'">';
                    $formattedArray[$key]["Users"]["first_name"] = '<a href="' . Router::url('/', true) . 'messages/viewMessage/trash/' . $val["Messages"]["id"] . '">'.ucwords($val['Users']['first_name']).'</a>';
                    $formattedArray[$key]["MessageReceiver"]["status"] = $val['MessageReceiver']['status'];
                    $formattedArray[$key]["Messages"]["subject"] = '<a href="' . Router::url('/', true) . 'messages/viewMessage/trash/' . $val["Messages"]["id"] . '">'.$val['Messages']['subject'].'</a>';
                    $formattedArray[$key]["Messages"]["time_created"] = date("H:m A", strtotime($val['Messages']['time_created']));
                endforeach;
            }
            $result["aaData"] = $formattedArray;
            $this->set('response', $result);
            $this->set('_serialize', 'response');
        }
}


public function moveMessageToTrash() {
    //$trashmessageids  = explode(",", $_POST['trshids']);
    $conditions = array(
                    "MessageReceiver.row_status = 1",
                    "MessageReceiver.receiver_id = ".AuthComponent::user('id'),
                    "MessageReceiver.id in (".$_POST['trshids'].")"
                  );
    //pr($conditions);exit;
    $updateData = array(
                    "MessageReceiver.type" => 12003
                  );
    $result = $this->MessageReceiver->moveMessageTrash($updateData, $conditions);
    if($result) {
        echo json_encode(array("status"=>1,"msg"=>"Moved to trash successfully"));
        exit;
    } else {
        echo json_encode(array("status"=>2,"msg"=>"Something went wrong"));
        exit;
    }
}

public function trashById($type = "",$id = 0 ) {
    if ($id != 0) {
        $conditions = array(
            "MessageReceiver.row_status" => 1,
            "MessageReceiver.message_id" => $id,
            "MessageReceiver.receiver_id" => $this->userId
        );
        $updateData = array(
            "MessageReceiver.type" => 12003
        );
        if ($type == "inbox" && $id != 0) {
            $conditions['MessageReceiver.type'] = 12001;
        } else if ($type == "outbox" && $id != 0) {
            $conditions['MessageReceiver.type'] = 12002;
        }
        $result = $this->MessageReceiver->moveTrashById($conditions, $updateData);
        if($result) {
            if ($type == "inbox") {
                $this->redirect(array("controller" => "messages", "action" => "index"),$exit);
            } else if ($type == "outbox") {
                $this->redirect(array("controller" => "messages", "action" => "sentMail"),$exit);
            }
        } else {
            $msg = __('Something went wrong!');
            $this->_setFlashMsgs($msg, 'danger');
            $this->redirect(array("controller" => "messages", "action" => "viewMessage",$type,$id),$exit);
        }
    }
}
            }
?>