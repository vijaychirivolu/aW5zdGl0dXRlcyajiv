<?php

/* * ******************************************************
 * File Name                :   GroupValue.php
 * File Description         :   This is the module which contains userdefined functions.
 * Author                   :   Ch.Vijay
 * Class Created Date       :   24/04/2014  (DD/MM/YYYY)
 * Revision                 :   XXXXXXXX
 * Class Modify By          :   XXXXXX
 * Class Modify Date        :   XXXXX (DD/MM/YYYY)       
 * Class Modify Revision    :   XXXXXX
 * ******************************************************* */

class GroupValue extends AppModel {

    public $name = 'GroupValue';

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['id']) && $this->data[$this->alias]['id'] == '') {
            $this->data[$this->alias]['time_created'] = date('Y-m-d H:i:s');
        }
        $userId = AuthComponent::user('id');
        $this->data[$this->alias]['requested_by'] = ($userId != "") ? $userId : 0;
        return true;
    }

    /**
     * FetchGroupValuesById
     * @param array $groupId
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchGroupValuesById($groupId) {
        $results = $this->find('all', array(
            'conditions' => array(
                'GroupValue.row_status' => 1,
                'GroupValue.group_id' => $groupId
            ),
            'fields' => array('GroupValue.id, GroupValue.name'),
            'recursive' => -1,
                )
        );
        $result = (!empty($results)) ? $results : array();
        return $result;
    }

}
