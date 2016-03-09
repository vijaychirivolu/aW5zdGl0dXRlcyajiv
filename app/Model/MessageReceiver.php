<?php

/**
 * Message Model
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    MessageModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 * @dateCreated 07/17/2015  MM/DD/YYYY
 * @dateUpdated 07/17/2015  MM/DD/YYYY 
 * @functions   2
 */
App::uses('AppModel', 'Model');

/**
 * Message Model
 *
 * @category    MessageModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @fileName    InstituteModel.php
 * @description Used for user queies and validations
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class MessageReceiver extends AppModel {
    
    public $name = 'MessageReceiver';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'receiver_id',
            'conditions' => array('User.row_status' => '1')
        )
    );
    var $actsAs = array('StoredProcedure');
    //public $uploadDir = 'files/schools/';
    
    
    /**
     * Before Validation Callback
     * @param array $options
     * @return boolean
     */
    public function beforeValidate($options = array()) {
        // ignore empty file - causes issues with form validation when file is empty and optional
        if (!empty($this->data[$this->alias]['logo']['error']) && $this->data[$this->alias]['logo']['error'] == 4 && $this->data[$this->alias]['logo']['size'] == 0) {
            unset($this->data[$this->alias]['logo']);
        }
        return parent::beforeValidate($options);
    }
    
    /**
     * Before Save Insert or Update
     * @param array $options Request Arguments
     * @return boolean true false
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function beforeSave($options = array()) {
        //pr($this->data);exit;
        if (isset($this->data[$this->alias]['id']) && $this->data[$this->alias]['id'] == '') {
            $this->data[$this->alias]['time_created'] = date('Y-m-d H:i:s');
        }
        $userId = AuthComponent::user('id');
        $this->data[$this->alias]['requested_by'] = ($userId != "") ? $userId : 0;
        return parent::beforeSave($options);
    }
    
    /**
     * Save message
     */
    public function saveMessageReceiver($data = array()) {
        try {
            $to_array = explode(",", $data['Message']['toid']);
            $insertdata['MessageReceiver'] = array();
            $i = 0;
            foreach ($to_array as $key => $value) {
                $insertdata['MessageReceiver'][$key]['message_id'] = $data['Message']['message_id'];
                $insertdata['MessageReceiver'][$key]['receiver_id'] = $value;
                $insertdata['MessageReceiver'][$key]['status'] = 10002;
                $insertdata['MessageReceiver'][$key]['type'] = 12001;
                $insertdata['MessageReceiver'][$key]['time_created'] = date("Y-m-d H:m:i");
                $i = $key;
            }
                $insertdata['MessageReceiver'][$i+1]['message_id'] = $data['Message']['message_id'];
                $insertdata['MessageReceiver'][$i+1]['receiver_id'] = AuthComponent::user('id');
                $insertdata['MessageReceiver'][$i+1]['status'] = 10002;
                $insertdata['MessageReceiver'][$i+1]['type'] = 12002;
                $insertdata['MessageReceiver'][$i+1]['time_created'] = date("Y-m-d H:m:i");
            return $this->saveAll($insertdata['MessageReceiver']);
        } catch (Exception $e) {
            //pr($e);
            //log_message('error', $this->db->_error_message()); //error message when query is wrong
            return false;
        }
    }
    
    /**
     * Retrieve user messages based on userid
     * @param userdata array
     * @return resultarray array
     */
    public function fetchUserMessages($userdata = array()) {
        try {
            $conditions = array(
                'MessageReceiver.row_status' => 1,
                'MessageReceiver.receiver_id' => $userdata['id'],
                'Messages.institute_id' => $userdata['institute_id']
            );
            $result = $this->find("all", array(
                'fields' => array(
                    'Messages.*',
                    'MessageReceiver.*',
                    'Users.*'
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
                        'conditions' => array('MessageReceiver.receiver_id = Users.id')
                    )
                )
            ));
            return (!empty($result))?$result:array();
        } catch(Exception $e) {
            return FALSE;
        }
    }
    
    /**
     * function to update the message read status
     * @param id int messageid
     * @return boolean
     */
    public function updateMessageStatus($updateData, $conditions) {
        try {
            return $this->updateAll($updateData, $conditions);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * function to update the message trash status
     * @param id int messageid
     * @return boolean
     */
    public function moveMessageTrash($updateData, $conditions) {
        try {
            return $this->updateAll($updateData, $conditions);
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Function to move the message to trash by using its id
     * @param $conditions array
     * @param $updateData array
     * @return boolean
     */
    public function moveTrashById($conditions, $updateData) {
        try {
            return $this->updateAll($updateData, $conditions);
        } catch (Exception $e) {
            return false;
        }
    }
    
    
    /**
     * Function to get the recent messages of the user
     * @return json Messages list in json response
     */
    public function getRecentMessages($conditions) {
        try {
            $result = $this->find("all", array(
                                    "conditions" => $conditions,
                                    "limit" => 4,
                                    "recursive" => 1
                                ));
            return (!empty($result))?$result:array();
        } catch (Exception $e) {
            return FALSE;
        }
    }
    /**
     * Function to delete message perminently
     * @param type $messagereceiverId
     * @return 
     */
    public function messagePerminentDelete($conditions, $updateData) {
        try {
            $this->belongsTo = array();
            return $this->updateAll($conditions, $updateData);
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function getNewMessageCntByRecieverId($instituteId=0,$recieverId=0){
        $inParams=array(0=>$instituteId,1=>$recieverId);
        $output = $this->executeMssqlSp('spGetUnreadMsgByReceiverId', $inParams );
        if(is_array($output) && $output!=NULL){
            $result['NewMsg']=$output[0][0]['MsgCount'];
            $result['DraftMsg']=$output[1][0]['MsgCount'];
            return $result;
        }
        return NULL;
    }
    
    public function getNewMessagesByRecieverId($instituteId=0,$recieverId=0){
        $inParams=array(0=>$instituteId,1=>$recieverId);
        $output = $this->executeMssqlSp('spGetNewMsgByReceiverId', $inParams );
        $result=NULL;
        if(is_array($output) && $output!=NULL){
            foreach ($output as $row=>$value){
                $result[$row]['receiver_id']=$value['mr']['receiver_id'];
                $result[$row]['message_id']=$value['mr']['message_id'];
                $result[$row]['student_id']=$value['mr']['student_id'];
                $result[$row]['time_created']=$value['mr']['time_created'];
                $result[$row]['institute_id']=$value['msg']['institute_id'];
                $result[$row]['sender_id']=$value['msg']['sender_id'];
                $result[$row]['subject']=($value['msg']['subject']!='' || $value['msg']['subject']!=NULL)?$value['msg']['subject']:'No Subject';
                $result[$row]['body']=($value['msg']['body']!='' || $value['msg']['body']!=NULL)?$value['msg']['body']:'No Message Body';
                $result[$row]['SenderName']=($value[0]['SenderName']!='' || $value[0]['SenderName']!=NULL)?ucfirst($value[0]['SenderName']):'';
                $result[$row]['RecivedOnDate']=$value[0]['RecivedOnDate'];
                $timeConvert=$this->__getRecivedTimeFormat($value[0]['RecivedTime']);
                $result[$row]['RecivedTime']=  $timeConvert[0];
                $result[$row]['RecivedOnTime']=  isset($timeConvert[1])?$timeConvert[1].$value[0]['RecivedOnTime']:'Today '.$value[0]['RecivedOnTime'];
                $result[$row]['RecivedDays']=$value[0]['RecivedDays'];
                
            } 
        }
        return $result;
    }
    
    private function __getRecivedTimeFormat($time=''){
        if($time!=null || $time!='' || $time>0){
            $hr=(int)substr($time, 0,strpos($time, ':'));
            $min=(int)substr($time, 3,2);
            $sec=(int)substr($time, 6,2);
            if($hr>0){
                if($hr<=24)
                    $resultentTime[0]=$hr.' hours ago ';
                else if(ceil($hr/24)==1)
                    $resultentTime[0]=$resultentTime[1]='Yesterday ';
                else {
                    $resultentTime[0]=  $resultentTime[1]=ceil($hr/24).' days ago ';
                }
            }else if($min>0){
                $resultentTime[0]=$min.' mins ago ';
            }else if($sec>0){
                $resultentTime[0]=$sec.' sec agos ';
            }  else {
                $resultentTime[0]='0 sec ago ';
            }
//            $resultentTime=($hr>0)?($hr<=24)?$hr.' hours ago':ceil($hr/24).' days ago':($min>0?$min.' mins ago':($sec>0?$sec.' sec ago':'0 sec ago'));
        }  else {
            $resultentTime[0]='0 secsago';
        }
        return $resultentTime;
    }
}
