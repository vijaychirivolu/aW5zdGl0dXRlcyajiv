<?php

/**
 * Galleries Controller
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    GalleriesController
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
 * Gallery Controller : User logins, Manage users with options like add,edit and delete
 *
 * @category GalleryController
 * @package  Controllers
 * @author   Vijay.Ch <vijay.ch@vendus.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://localhost/cacsv2/index
 */
class GalleriesController extends AppController {

    public $uses = array('Gallery', 'GalleryImage', 'ClassInfo', 'GalleryAccess');
    public $components = array('Custom');

    /**
     * Before filter
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    function beforeFilter() {
        $this->guestActions = array();
        $this->superadminActions = array('index', 'uploads');
        $this->adminActions = array();
        $this->instituteAdminActions = array('setup', 'index', 'uploads', 'images');
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
        $galleryConditions = array(
            'Gallery.row_status' => 1,
            'Gallery.institute_id' => $this->instituteId
        );
        $galleriesResult = $this->Gallery->fetchAllGalleriesByConditions($galleryConditions);
        $this->set(compact('galleriesResult'));
        //echo $this->schoolId;exit;
    }

    /**
     * Images
     * @param array $user User Session data
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function images($galleryId) {
        if ($this->instituteId != "") {
            if ($galleryId != "" && is_numeric($galleryId)) {
                $galleryConditions = array(
                    'Gallery.row_status' => 1,
                    'Gallery.institute_id' => $this->instituteId
                );
                $galleriesResult = $this->Gallery->fetchAllGalleriesByConditions($galleryConditions);
                $galleryImageConditions = array(
                    'GalleryImage.row_status' => 1,
                    'GalleryImage.gallery_id' => $galleryId
                );
                $galleryImages = $this->GalleryImage->fetchAllGalleryImagesByConditions($galleryImageConditions);
                $this->set(compact('galleriesResult', 'galleryImages', "galleryId"));
            } else {
                $this->redirect(array("action" => "index"));
            }
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
    }

    /**
     * Setup
     * @param array $user User Session data
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function setup($id = 0) {
        if ($this->instituteId != "") {
            $classSectionResults = $this->ClassInfo->fetchClassSectionsResultsByInstitueId($this->instituteId);
            $postData = $this->request->data;
            if (!empty($postData)) {
                pr($postData);exit;
                $galleryData["Gallery"] = $postData["Gallery"];
                if ($this->Gallery->validates()) {
                    if ($this->Gallery->save($galleryData)) {
                        $lastInsertId = $this->Gallery->getLastInsertId();
                        if (!empty($postData["GalleryAccess"])) {
                            foreach ($postData["GalleryAccess"]["section_id"] as $key => $res):
                                $galleryAccessData[$key]["GalleryAccess"]["id"] = "";
                                $galleryAccessData[$key]["GalleryAccess"]["gallery_id"] = $lastInsertId;
                                $galleryAccessData[$key]["GalleryAccess"]["section_id"] = $res;
                            endforeach;
                            $this->GalleryAccess->saveAll($galleryAccessData);
                        }
                        $msg = ($id > 0) ? __('The Gallery has been updated.') : __('The Gallery has been added.');
                        if ($this->request->is('ajax')) {
                            echo json_encode(array(
                                'status' => "success",
                                "message" => $msg,
                                'callback' => array("prefix" => false, "controller" => "galleries", "action" => "index")
                            ));
                            exit;
                        } else {
                            $this->_setFlashMsgs($msg, 'success');
                            $this->redirect(array('action' => 'index'));
                        }
                    }
                }
            } else {
                if ($id > 0) {
                    $result = $this->Holiday->fetchHolidayDetailsById($id);
                    $this->request->data = $result;
                }
            }
            $this->set(compact("id", "classSectionResults"));
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
    }

    /**
     * 
     */
    public function uploads($galleryId) {
        if ($this->instituteId != "") {
            if (isset($_FILES) && isset($_FILES["file"]) && isset($_POST)) {
                if ($galleryId != "" && is_numeric($galleryId)) {
                    $conditions = array(
                        'Gallery.id' => $galleryId,
                        'Gallery.row_status' => 1
                    );
                    $galleryResult = $this->Gallery->isGalleryExists($conditions);
                    if (!empty($galleryResult)) {
                        $galleryId = $galleryResult["Gallery"]["id"];
                        $cnt = count($_FILES["file"]["name"]);
                        $errorCnt = 0;
                        for ($i = 0; $i < $cnt; $i++) {
                            $fileUpload = $_FILES["file"];
                            if ($fileUpload['error'][$i] > 0) {
                                $errorCnt = $errorCnt + 1;
                            } else {
                                $tempfile = $fileUpload['tmp_name'][$i];
                                $allowedExts = array("gif", "jpeg", "jpg", "png");
                                $explodeDetails = explode(".", $fileUpload['name'][$i]);
                                $extension = strtolower(end($explodeDetails));
                                $filename = time() . '_' . $this->instituteId . '_' . $i . '.' . $extension;
                                $folder = WWW_ROOT . 'files/galleries/';
                                if ((($fileUpload["type"][$i] == "image/gif") || ($fileUpload["type"][$i] == "image/jpeg") || ($fileUpload["type"][$i] == "image/jpg") || ($fileUpload["type"][$i] == "image/pjpeg") || ($fileUpload["type"][$i] == "image/x-png") || ($fileUpload["type"][$i] == "image/png")) && in_array($extension, $allowedExts)) {
                                    if ($fileUpload["error"][$i] > 0) {
                                        $errorCnt = $errorCnt + 1;
                                    } else {
                                        move_uploaded_file($fileUpload["tmp_name"][$i], $folder . $filename);
                                        $insData[$i]['GalleryImage']['id'] = "";
                                        $insData[$i]['GalleryImage']['filename'] = $filename;
                                        $insData[$i]['GalleryImage']['original_filename'] = $fileUpload['name'][$i];
                                        $insData[$i]['GalleryImage']['gallery_id'] = $galleryId;
                                    }
                                } else {
                                    $errorCnt = $errorCnt + 1;
                                }
                            }
                        }
                        if ($this->GalleryImage->saveAll($insData)) {
                            if ($errorCnt > 0) {
                                $msg = __($errorCnt . " Image's are not uploaded due to some errors.");
                                echo json_encode(array(
                                    'status' => "error",
                                    "message" => $msg,
                                    'callback' => array("prefix" => false, "controller" => "galleries", "action" => "images","id"=>$galleryId)
                                ));
                                exit;
                            } else {
                                echo json_encode(array(
                                    'status' => "success",
                                    "message" => "Images are uploaded successfully.",
                                    'callback' => array("prefix" => false, "controller" => "galleries", "action" => "images", "id"=>$galleryId)
                                ));
                                exit;
                            }
                        } else {
                            echo json_encode(array(
                                'status' => "error",
                                "message" => "Something went wrong. Please try again!",
                                'callback' => array("prefix" => false, "controller" => "galleries", "action" => "images", "id"=>$galleryId)
                            ));
                            exit;
                        }
                    } else {
                        echo json_encode(array(
                            'status' => "error",
                            "message" => "Something went wrong. Please try again!",
                            'callback' => array("prefix" => false, "controller" => "galleries", "action" => "index")
                        ));
                        exit;
                    }
                } else {
                    echo json_encode(array(
                        'status' => "error",
                        "message" => "Something went wrong. Please try again!",
                        'callback' => array("prefix" => false, "controller" => "galleries", "action" => "index")
                    ));
                    exit;
                }
            }
            if ($galleryId != "" && is_numeric($galleryId)) {
                $this->set(compact("galleryId"));
            } else {
                $this->redirect(array("action" => "index"));
            }
            
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
        
    }

}

?>