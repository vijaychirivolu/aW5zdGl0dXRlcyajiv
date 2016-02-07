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

    public $uses = array('Gallery', 'GalleryImage');
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
    public function index($galleryId = "") {
        $galleryConditions = array(
            'Gallery.row_status' => 1,
            'Gallery.school_id' => $this->schoolId
        );
        $galleriesResult = $this->Gallery->fetchAllGalleriesByConditions($galleryConditions);
        $galleryImageConditions = array(
            'GalleryImage.row_status' => 1,
            'GalleryImage.school_id' => $this->schoolId
        );
        if ($galleryId != "") {
            $galleryImageConditions["GalleryImage.gallery_id"] = $galleryId;
        }
        $galleryImages = $this->GalleryImage->fetchAllGalleryImagesByConditions($galleryImageConditions);
        $this->set(compact('galleriesResult', 'galleryImages'));
        //echo $this->schoolId;exit;
    }

    /**
     * 
     */
    public function uploads() {
        if (isset($_FILES) && isset($_FILES["file"]) && isset($_POST)) {
            $galleryName = (isset($_POST["name"]) && $_POST["name"] != "") ? $_POST["name"] : "";
            if ($galleryName != "") {
                $galleryResult = $this->Gallery->isGalleryExistsByName($galleryName,$this->schoolId);
                if (!empty($galleryResult)) {
                    $galleryId = $galleryResult["Gallery"]["id"];
                } else {
                    $galleryInsData = array(
                        'Gallery' => array(
                            'id' => '',
                            'name' => stripslashes($galleryName),
                            'school_id' => $this->schoolId
                        )
                    );
                    if ($this->Gallery->save($galleryInsData)) {
                        $galleryId = $this->Gallery->getLastInsertId();
                    } else {
                        $galleryId = 0;
                    }
                }
                if ($galleryId != 0) {
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
                            $filename = time() . '_' . $this->schoolId . '_' . $i . '.' . $extension;
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
                                    $insData[$i]['GalleryImage']['school_id'] = $this->schoolId;
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
                                'callback' => array("prefix" => true, "module" => "school", "controller" => "galleries", "action" => "index")
                            ));
                            exit;
                        } else {
                            echo json_encode(array(
                                'status' => "success",
                                "message" => "Images are uploaded successfully.",
                                'callback' => array("prefix" => true, "module" => "school", "controller" => "galleries", "action" => "index")
                            ));
                            exit;
                        }
                    } else {
                        echo json_encode(array(
                            'status' => "error",
                            "message" => "Something went wrong. Please try again!",
                            'callback' => array("prefix" => true, "module" => "school", "controller" => "galleries", "action" => "index")
                        ));
                        exit;
                    }
                } else {
                    echo json_encode(array(
                        'status' => "error",
                        "message" => "Something went wrong. Please try again!",
                        'callback' => array("prefix" => true, "module" => "school", "controller" => "galleries", "action" => "uploads")
                    ));
                    exit;
                }
            } else {
                echo json_encode(array(
                    'status' => "error",
                    "message" => "Something went wrong. Please try again!",
                    'callback' => array("prefix" => true, "module" => "school", "controller" => "galleries", "action" => "uploads")
                ));
                exit;
            }
        }
    }

}

?>