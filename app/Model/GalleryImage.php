<?php

/**
 * GalleryImage Model
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    GalleryImageModel
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
 * GalleryImage Model
 *
 * @category    GalleryImageModel
 * @package     Models
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @fileName    GalleryImageModel.php
 * @description Used for user queies and validations
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class GalleryImage extends AppModel {
    
    public $name = 'GalleryImage';
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
        
        $userSessionId = AuthComponent::user('user_session_id');
        $this->data[$this->alias]['user_session_id'] = ($userSessionId != "") ? $userSessionId : 0;
        return parent::beforeSave($options);
    }

    
    /**
     * Update query based on condtions
     * @param array $updateData which data has been updated
     * @param array $conditions which id we need to update
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function updateGalleryImageDetails($updateData, $conditions) {
        try {
            return $this->updateAll($updateData, $conditions);
        }
        //try method ends
        //catch method starts
        catch (Exception $e) {
            //log_message('error', $this->db->_error_message()); //error message when query is wrong
            return false;
        }
        //catch method ends
    }
    
    /**
     * FetchAllGalleriesByConditions
     * @param array $conditions which id we need to update
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchAllGalleryImagesByConditions($conditions) {
        try {
            return $this->find("all",array(
            'conditions' => $conditions,
            'fields' => array(
                'GalleryImage.id',
                'GalleryImage.original_filename',
                'GalleryImage.filename',
                'GalleryImage.time_created'
            ),
            'joins' => array(
                array(
                    'table' => 'galleries',
                    'alias' => 'Gallery',
                    'type' => 'left',
                    'conditions' => array('GalleryImage.gallery_id = Gallery.id AND Gallery.row_status = 1')
                ),
            ),    
            'order' => 'GalleryImage.id desc'
            ));
        }
        //try method ends
        //catch method starts
        catch (Exception $e) {
            //pr($e->getMessage());exit;
            //log_message('error', $this->db->_error_message()); //error message when query is wrong
        }
          
    }
}
