<?php

/**
 * Institutes Controller
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    InstitutesController
 * @package     Controllers
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 * @dateCreated 07/17/2015  MM/DD/YYYY
 * @dateUpdated 07/17/2015  MM/DD/YYYY 
 * @functions   2
 */
App::uses('AppController', 'Controller');
App::import('Vendor', 'php-excel-reader/excel_reader2'); //import statement
App::uses('File', 'Utility');

/**
 * Institutes Controller : User logins, Manage users with options like add,edit and delete
 *
 * @category InstitutesController
 * @package  Controllers
 * @author   Vijay.Ch <vijay.ch@vendus.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://localhost/cacsv2/index
 */
class InstitutesController extends AppController {

    public $uses = array('Institute', 'UploadHistory', 'InstituteSetting');
    public $components = array('NotificationEmail', 'DataTable', 'Custom', 'Csv');

    /**
     * Before filter
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    function beforeFilter() {
        $this->guestActions = array();
        $this->superadminActions = array('admin_index', 'admin_setup', 'admin_uploadInstituteData');
        $this->instituteAdminActions = array('timings', 'settings');
        $this->adminActions = array();
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
    public function admin_index() {
        $this->Session->delete('schoolId');
        if ($this->RequestHandler->responseType() == 'json') {
            $this->paginate = array(
                'fields' => array(
                    'Institute.id',
                    'Institute.name',
                    'Institute.registration_no',
                    'Institute.street_address',
                    'Institute.city'
                ),
                'conditions' => array(
                    'Institute.row_status' => 1
                )
            );
            $this->DataTable->mDataProp = true;
            $result = $this->DataTable->getResponse();
            //pr($result);exit;
            $formattedArray = array();
            if (isset($result["aaData"])) {
                foreach ($result["aaData"] as $key => $val):
                    $formattedArray[$key]["Institute"]["name"] = '<a href="' . Router::url('/', true) . 'school/dashboards/account/' . $val["Institute"]["id"] . '">' . implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["Institute"]["name"]))))) . '</a>';
                    $formattedArray[$key]["Institute"]["registration_no"] = ($val["Institute"]["registration_no"] != "") ? $val["Institute"]["registration_no"] : "N/A";
                    $formattedArray[$key]["Institute"]["street_address"] = implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["Institute"]["street_address"])))));
                    $formattedArray[$key]["Institute"]["city"] = implode('-', array_map('ucwords', explode('-', strtolower(addslashes($val["Institute"]["city"])))));
                    $formattedArray[$key]["Institute"]["id"] = '<div class="btn-group"><a class="btn-white btn btn-xs" href="' . Router::url('/', true) . 'admin/schools/setup/' . $val["Institute"]["id"] . '">' . __("Edit") . '</a><a class="btn-white btn btn-xs delete-confirm-alert" href="' . Router::url('/', true) . 'admin/states/delete/' . $val["Institute"]["id"] . '" data-message = "You are permenantly deleting this state!">' . __("Delete") . '</a></div>';
                endforeach;
            }
            $result["aaData"] = $formattedArray;
            $this->set('response', $result);
            $this->set('_serialize', 'response');
        }
    }

    /**
     * Add,Edit Actions
     * @param array $user User Session data
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function admin_setup($id = 0) {
        $postData = $this->request->data;
        if (!empty($postData)) {
            if ($this->Institute->validates()) {
                if ($this->Institute->save($postData)) {
                    $msg = ($id > 0) ? __('The Institute has been updated.') : __('The Institute has been added.');
                    if ($this->request->is('ajax')) {
                        echo json_encode(array(
                            'status' => "success",
                            "message" => $msg,
                            'callback' => array("prefix" => true, "controller" => "states", "action" => "index")
                        ));
                        exit;
                    } else {
                        $this->_setFlashMsgs($msg, 'success');
                        $this->redirect(array('action' => 'admin_index'));
                    }
                }
            }
        } else {
            if ($id > 0) {
                $result = $this->Institute->fetchStateDetailsById($id);
                $this->request->data = $result;
            }
        }
        $this->set("id", $id);
    }

    /**
     * Upload CAFR Data
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function admin_uploadInstituteData() {
        if (!empty($this->request->data)) {
            $data = $this->request->data;
            if (!empty($data["UploadInstituteData"]['filename']) && $data["UploadInstituteData"]['filename']["name"] != "" && $data["UploadInstituteData"]['filename']["error"] == 0) {
                $filename = explode('.', $data["UploadInstituteData"]['filename']["name"]);
                $extension = strtolower(end($filename));
                if ($extension == 'csv' || $extension == 'xls') {
                    $filename = round(microtime(true)) . rand() . "." . $extension;
                    if (move_uploaded_file($data["UploadInstituteData"]['filename']['tmp_name'], WWW_ROOT . 'files/upload_data/' . $filename)) {
                        $file = new File(WWW_ROOT . "files/upload_data/" . $filename, false, 0777);
                        $uploadHistoryData = array(
                            'UploadHistory' => array(
                                "id" => "",
                                'original_filename' => $data["UploadInstituteData"]['filename']["name"],
                                'uploaded_filename' => $filename,
                                'upload_type' => 3001
                            )
                        );
                        $this->UploadHistory->save($uploadHistoryData);
                        $schoolUploadHistoryId = $this->UploadHistory->getLastInsertId();
                        if ($extension == 'csv') {
                            $result = $this->Csv->import('/files/upload_data/' . $filename);
                            $dataArray = $this->Custom->importInstituteData($result);
                            if (is_array($dataArray)) {
                                if (empty($dataArray)) {
                                    $this->_setFlashMsgs(__('File uploaded successfully.'), 'success');
                                    $this->redirect(array('action' => 'admin_index'));
                                } else {
                                    $this->Custom->saveErrorReportFile($dataArray, $cafrUploadHistoryId);
                                    $errorCnt = count($dataArray);
                                    $this->_setFlashMsgs(__($errorCnt . " record(s) have failed. Please check the error report."), 'danger');
                                    $this->redirect(array('action' => 'admin_uploadHistories'));
                                }
                            } else {
                                $updateData = array(
                                    'UploadHistory.error_message' => "'" . $dataArray . "'"
                                );
                                $conditions = array(
                                    'UploadHistory.id' => $schoolUploadHistoryId,
                                    'UploadHistory.row_status' => 1
                                );
                                $this->UploadHistory->updateUploadHistoryDetails($updateData, $conditions);
                                $this->_setFlashMsgs(__($dataArray), 'danger');
                                $this->redirect(array('action' => 'admin_uploadHistories'));
                            }
                        } else {
                            $sheetResult = new Spreadsheet_Excel_Reader(WWW_ROOT . 'files/upload_data/' . $filename, true);
                            $sheetResult = $sheetResult->sheets;

                            $sheetCnt = count($sheetResult);
                            if ($sheetCnt >= 1) {
                                $result = array();
                                $sheetResult = $sheetResult[0]["cells"];
                                $cellCnt = count($sheetResult);
                                $temp = $sheetResult[1];
                                //pr($sheetResult);
                                foreach ($temp as $k => $row):
                                    $j = 0;
                                    for ($i = 2; $i <= $cellCnt; $i++):
                                        if (!empty($sheetResult[$i])) {
                                            $sheetData = array_filter($sheetResult[$i]);
                                            if (!empty($sheetData)) {
                                                $result[$j]["Institute"][$row] = (isset($sheetData) && (isset($sheetData[$k])) && $sheetData[$k] != "") ? $sheetData[$k] : "";
                                            }
                                            $j++;
                                        }
                                    endfor;
                                endforeach;
                                $resultArray = $this->Custom->importInstituteData($result);
                                if (is_array($resultArray)) {
                                    if (empty($resultArray)) {
                                        $this->_setFlashMsgs(__('File uploaded successfully.'), 'success');
                                        $this->redirect(array('action' => 'admin_uploadHistories'));
                                    } else {
                                        $this->saveErrorReportFile($resultArray, $schoolUploadHistoryId);
                                        $errorCnt = count($resultArray);
                                        $this->_setFlashMsgs(__($errorCnt . " record(s) have failed. Please check the error report."), 'danger');
                                        $this->redirect(array('action' => 'admin_uploadHistories'));
                                    }
                                } else {
                                    $updateData = array(
                                        'UploadHistory.error_message' => "'" . $resultArray . "'"
                                    );
                                    $conditions = array(
                                        'UploadHistory.id' => $schoolUploadHistoryId,
                                        'UploadHistory.row_status' => 1
                                    );
                                    $this->UploadHistory->updateUploadHistoryDetails($updateData, $conditions);
                                    $this->_setFlashMsgs(__($resultArray), 'danger');
                                    $this->redirect(array('action' => 'admin_uploadHistories'));
                                }
                            }
                        }
                    } else {
                        $this->_setFlashMsgs(__('Something went wrong. Please try again!'), 'danger');
                        $this->redirect(array('action' => 'admin_index'));
                    }
                } else {
                    $this->_setFlashMsgs(__('Invalid File. CSV and XLS are allowed.'), 'danger');
                    $this->redirect(array('action' => 'admin_index'));
                }
            } else {
                $this->_setFlashMsgs(__('File should not be empty.'), 'danger');
                $this->redirect(array('action' => "admin_index"));
            }
        } else {
            $this->_setFlashMsgs(__('File should not be empty.'), 'danger');
            $this->redirect(array('action' => "admin_index"));
        }
    }

    /**
     * Admin CafrDataHistory
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function admin_uploadHistories() {
        $historyList = $this->UploadHistory->getUploadHistoryListByType(3001);
        $this->set(compact('historyList'));
    }

    /**
     * Institute Timings
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function timings() {
        if ($this->instituteId != "") {
            $weekData = $this->Custom->fetchGroupValuesById(9000);
            $timings = array(9=>"9:00",9.5=>"9:30",10=>"10:00");
            $this->set(compact('weekData','timings'));
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
    }

    /**
     * Institute Settings
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function settings() {
        if ($this->instituteId != "") {
            if (!empty($this->request->data)) {
                $data = $this->request->data;
                if ($this->InstituteSetting->save($data)) {
                    $this->_setFlashMsgs(__('Institute Settings Saved Successfully'), 'success');
                    $this->redirect($this->UserAuth->redirect());
                } else {
                    $msg = __('Saving failed due to below errors!');
                    $this->_setFlashMsgs($msg, 'danger');
                }
            }
            $result = $this->InstituteSetting->fetchSettingDetailsByInstituteId($this->instituteId);
            $this->request->data = $result;
            $breakTimes = array(5 => '5 minutes', 10 => '10 minutes', 15 => '15 minutes');
            $lunchTimes = array(30 => '30 minutes', 45 => '45 minutes', 60 => 'Hourly');
            $periodTimes = array(30 => '30 minutes', 45 => '45 minutes', 60 => 'Hourly');
            $maxAllowedPeriods = array(4 => '4 Periods', 5 => '5 Periods', 6 => '6 Periods', 7 => '7 Periods', 8 => '8 Periods');
            $this->set(compact("breakTimes", "lunchTimes", "periodTimes", "maxAllowedPeriods"));
        } else {
            $this->redirect($this->UserAuth->redirect());
        }
    }

}

?>