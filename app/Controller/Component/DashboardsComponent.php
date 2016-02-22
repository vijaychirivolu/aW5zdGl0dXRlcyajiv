<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboardsComponent
 *
 * @author Sriram
 */
App::uses('Component', 'Controller');
class DashboardsComponent extends Component{
    //put your code here
    
    
    public function __construct() {
        $this->Student = ClassRegistry::init('Student');
        $this->Employee = ClassRegistry::init('Employee');
        $this->MessageReceiver = ClassRegistry::init('MessageReceiver');
        $this->Message = ClassRegistry::init('Message');
        
    }
    
    public function getStudentCntByInstituteId($instituteId){
        return $this->Student->getStudentCntByInstituteId($instituteId);
    }
    
    public function getEmployeeCntByInstituteId($instituteId){
        return $this->Employee->getEmployeeCntByInstituteId($instituteId);
    }
    
    public function getNewMessageCntByRecieverId($instituteId){
        return $this->MessageReceiver->getNewMessageCntByRecieverId($instituteId);
    }
    
    public function getNewMessagesByRecieverId($instituteId){
        return $this->MessageReceiver->getNewMessagesByRecieverId($instituteId);
    }
}
