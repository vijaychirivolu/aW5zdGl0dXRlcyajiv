<?php

/**
 * Custom Component
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    CustomComponent
 * @package     Components
 * @author      Vijay.ch <vijay.ch@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 * @dateCreated 07/21/2015  MM/DD/YYYY
 * @dateUpdated 07/21/2015  MM/DD/YYYY 
 * @functions   8
 */

/**
 * Custom Component
 *
 * @category    Custom
 * @package     Components
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @fileName    CustomComponent.php
 * @description Used product and site mappings
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class CustomComponent extends Component {

    public $insertData = array();

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
    }

    /**
     * Construct method
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function __construct() {
        $this->School = ClassRegistry::init('School');
        $this->GroupValue = ClassRegistry::init('GroupValue');
        $this->UploadHistory = ClassRegistry::init('UploadHistory');
        $this->ClassInfo = ClassRegistry::init('ClassInfo');
        ini_set('memory_limit', '-1');
        ini_set('post_max_size', '64M');
        ini_set('upload_max_filesize', '64M');
        ini_set('max_execution_time', 1000); //300 seconds = 5 minutes
    }

    public function startup(Controller $controller) {
        $this->Controller = $controller;
    }

    /**
     * importSchoolData
     * @param array $data Csv or Xls data
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function importSchoolData($data) {
        //pr($data);exit;
        if (!empty($data)) {
            $cafrData = array();
            $errorReport = array();
            $definedArray1 = array("Name",
                "Registration No",
                "Description",
                "Phone No",
                "Landline No",
                "Address",
                "Street Address",
                "City",
                "State",
                "Country",
                "Postal Code",
                "Facebook Url",
                "Twitter Url",
                "Linkedin Url",
                "Is Publish"
            );
            $keys = array_keys($data[0]["School"]);
            if ($keys === $definedArray1) {
                $insertUploadData = array();
                if ($this->School->validateMany($data)) {
                    $insertUploadData = $data;
                } else {
                    foreach ($this->School->validationErrors as $key => $val):
                        if (isset($data) && $data[$key]) {
                            $errorRecord = $data[$key];
                            $errors = '';
                            foreach ($val as $k => $v) {
                                $errors .= (isset($v) && isset($v[0]) && $v[0] != "") ? $v[0] : "";
                            }
                            $errorRecord["School"]["Errors"] = $errors;
                            $errorReport[] = $errorRecord;
                            unset($data[$key]);
                        }
                    endforeach;
                    $insertUploadData = $data;
                }
                if (empty($insertUploadData)) {
                    return (!empty($errorReport)) ? $errorReport : array();
                }
                if ($this->School->validateMany($insertUploadData)) {
                    foreach ($insertUploadData as $k => $r):
                        $name = (isset($r["School"]["Name"]) && $r["School"]["Name"] != "") ? trim(addslashes($r["School"]["Name"])) : "";
                        $registrationNo = (isset($r["School"]["Registration No"]) && $r["School"]["Registration No"] != "") ? trim(addslashes($r["School"]["Registration No"])) : "";
                        $description = (isset($r["School"]["Description"]) && $r["School"]["Description"] != "") ? trim(addslashes($r["School"]["Description"])) : "";
                        $phoneNo = (isset($r["School"]["Phone No"]) && $r["School"]["Phone No"] != "") ? trim(addslashes($r["School"]["Phone No"])) : "";
                        $landlineNo = (isset($r["School"]["Landline No"]) && $r["School"]["Landline No"] != "") ? trim(addslashes($r["School"]["Landline No"])) : "";
                        $address = (isset($r["School"]["Address"]) && $r["School"]["Address"] != "") ? trim(addslashes($r["School"]["Address"])) : "";
                        $streetAddress = (isset($r["School"]["Street Address"]) && $r["School"]["Street Address"] != "") ? trim(addslashes($r["School"]["Street Address"])) : "";
                        $city = (isset($r["School"]["City"]) && $r["School"]["City"] != "") ? trim(addslashes($r["School"]["City"])) : "";
                        $state = (isset($r["School"]["State"]) && $r["School"]["State"] != "") ? trim(addslashes($r["School"]["State"])) : "";
                        $country = (isset($r["School"]["Country"]) && $r["School"]["Country"] != "") ? trim(addslashes($r["School"]["Country"])) : "";
                        $postalCode = (isset($r["School"]["Postal Code"]) && $r["School"]["Postal Code"] != "") ? trim(addslashes($r["School"]["Postal Code"])) : "";
                        $facebookUrl = (isset($r["School"]["Facebook Url"]) && $r["School"]["Facebook Url"] != "") ? trim(addslashes($r["School"]["Facebook Url"])) : "";
                        $twitterUrl = (isset($r["School"]["Twitter Url"]) && $r["School"]["Twitter Url"] != "") ? trim(addslashes($r["School"]["Twitter Url"])) : "";
                        $linkedinUrl = (isset($r["School"]["Linkedin Url"]) && $r["School"]["Linkedin Url"] != "") ? trim(addslashes($r["School"]["Linkedin Url"])) : "";
                        $isPublish = (isset($r["School"]["Is Publish"]) && $r["School"]["Is Publish"] != "") ? trim(addslashes($r["School"]["Is Publish"])) : "";

                        $schoolResult = $this->School->isSchoolExists($name, $registrationNo, $address, $streetAddress, $city, $state, $country, $postalCode);
                        if (!empty($schoolResult)) {
                            $schoolData["School"]["id"] = $schoolResult["School"]["id"];
                        } else {
                            $schoolData["School"]["id"] = '';
                        }

                        $schoolData["School"]["name"] = $name;
                        $schoolData["School"]["registration_no"] = $registrationNo;
                        $schoolData["School"]["description"] = $description;
                        $schoolData["School"]["phone_noe"] = $phoneNo;
                        $schoolData["School"]["landline_no"] = $landlineNo;
                        $schoolData["School"]["address"] = $address;
                        $schoolData["School"]["street_address"] = $streetAddress;
                        $schoolData["School"]["city"] = $city;
                        $schoolData["School"]["state"] = $state;
                        $schoolData["School"]["country"] = $country;
                        $schoolData["School"]["postal_code"] = $postalCode;
                        $schoolData["School"]["fb_url"] = $facebookUrl;
                        $schoolData["School"]["twitter_url"] = $twitterUrl;
                        $schoolData["School"]["linkedin_url"] = $linkedinUrl;
                        $schoolData["School"]["is_publish"] = $isPublish;
                        $this->School->create();  // initializes a new instance
                        $this->School->save($schoolData);
                    endforeach;
                    return (!empty($errorReport)) ? $errorReport : array();
                } else {
                    return (!empty($errorReport)) ? $errorReport : array();
                }
            } else {
                return "Header does not match. Please check it once.";
            }
        } else {
            return "File should not be empty.";
        }
    }

    /**
     * saveErrorReportFile
     * @param Array $data
     * @param Int $uploadId
     */
    public function saveErrorReportFile($data, $uploadId) {
        $errorCnt = count($data);
        $errorMessage = $errorCnt . " record(s) have failed. Please check the error report.";
        $filename = round(microtime(true)) . ".csv";
        $res = $this->Csv->exportCafr(WWW_ROOT . "files/upload_data/" . $filename, $data);
        if ($res > 0) {
            $updateData = array(
                'CafrUploadHistory.error_filename' => "'" . $filename . "'",
                'CafrUploadHistory.error_message' => "'" . $errorMessage . "'"
            );
            $conditions = array(
                'UploadHistory.row_status' => 1,
                'UploadHistory.id' => $uploadId
            );
            $this->UploadHistory->updateUploadHistoryDetails($updateData, $conditions);
        }

        return true;
    }
    
    /**
     * FetchGroupValuesById
     * @param $groupId
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchGroupValuesById($groupId) {
        $groupResult = $this->GroupValue->fetchGroupValuesById($groupId);
        return $groupResult;
    }
    
    /**
     * FetchClassesForDropDown
     * @param $instituteId
     * @return array
     * @throws NotFoundException When the view file could not be found
     *    or MissingViewException in debug mode.
     */
    public function fetchClassesForDropDown($instituteId) {
        $classResult = array();
        if ($instituteId !="") {
            $result = $this->ClassInfo->fetchClassInfosDetailsByInstituteId($instituteId);
            if (!empty($result)) {
                foreach($result as $k=>$res):
                    $classResult[$res["ClassInfo"]["id"]] = ucwords(stripslashes($res["ClassInfo"]["name"]));
                endforeach; 
            }
        }
        return $classResult;
    }
    
    
}

?>