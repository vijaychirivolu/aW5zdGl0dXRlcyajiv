<?php

/**
 * CSV Component
 *
 * @author Dean Sofer (proloser@hotmail.com)
 * @version 1.0
 * @package CSV Plugin
 * */
App::uses('Component', 'Controller');
App::uses('File', 'Utility');

class CsvComponent extends Component {

    /**
     * Allows the mapping of preg-compatible regular expressions to public or
     * private methods in this class, where the array key is a /-delimited regular
     * expression, and the value is a class method.  Similar to the public functionality of
     * the findBy* / findAllBy* magic methods.
     *
     * @var array
     * @access public
     */
    public $defaults = array(
        'length' => 0,
        'delimiter' => ',',
        'enclosure' => '"',
        'escape' => '\\',
        'headers' => true
    );

    public function initialize(Controller $controller, $settings = array()) {
        // saving the controller reference for later use
        $this->controller = $controller;
        $this->defaults = array_merge($this->defaults, $settings);
    }

    /**
     * Encoding for foreign characters
     *
     * @var array
     * @access protected
     */
    protected function _encode($str = '') {
        return iconv("UTF-8", "WINDOWS-1257", html_entity_decode($str, ENT_COMPAT, 'utf-8'));
    }

    /**
     * Import public function
     *
     * @param string $filename path to the file under webroot
     * @return array of all data from the csv file in [Model][field] format
     * @author Dean Sofer
     */
    public function import($filename, $fields = array(), $options = array()) {
        $options = array_merge($this->defaults, $options);
        $data = array();
        $row = array();
        // open the file
        if ($file = @fopen(WWW_ROOT . $filename, 'r')) {
            if (empty($fields)) {
                // read the 1st row as headings
                $fields = fgetcsv($file, $options['length'], $options['delimiter'], $options['enclosure']);
            }
            // Row counter
            $r = 0;
            // read each data row in the file
            while ($sheetData = fgetcsv($file, $options['length'], $options['delimiter'], $options['enclosure'])) {
                if (!empty($sheetData)) {
                    $row = array_filter($sheetData);
                }
                // for each header field
                if (!empty($row)) {
                    foreach ($fields as $f => $field) {
                        // get the data field from Model.field
                        if (strpos($field, '.')) {
                            $keys = explode('.', $field);
                            if (isset($keys[2])) {
                                $data[$r][$keys[0]][$keys[1]][$keys[2]] = $row[$f];
                            } else {
                                // pr($data[$r]);exit;
                                $data[$r][$keys[0]][$keys[1]] = $row[$f];
                            }
                        } else {
                            $data[$r][$this->controller->modelClass][$field] = (isset($row) && isset($row[$f])) ? $row[$f] : '';
                        }
                    }
                    $r++;
                }
                
            }
            // close the file
            fclose($file);

            // return the messages
            return $data;
        } else {
            return false;
        }
    }

    /**
     * Converts a data array into
     *
     * @param string $filename
     * @param string $data
     * @return void
     * @author Dean
     */
    public function export($filename, $data, $options = array()) {
        //echo $filename;exit;

        $options = array_merge($this->defaults, $options);
        // open the file
        $filePermission = new File(WWW_ROOT . "files/export/" . $filename, false, 0777);
        $filePermission->delete();
        if ($file = fopen(WWW_ROOT . "files/export/" . $filename, 'w+')) {
            // Iterate through and format data
            $firstRecord = true;
            foreach ($data as $record) {
                //pr($record);
                //exit;
                $row = array();
                foreach ($record as $model => $fields) {
                    // TODO add parsing for HABTM
                    // pr($fields);exit;
                    foreach ($fields as $field => $value) {
                        //pr($field);
                        if (!is_array($value)) {

                            if ($firstRecord) {
                                //echo 1;exit;
                                $headers[] = $this->_encode($field);
                                //$model . '.' . $field
                            }

                            $row[] = $this->_encode($value);
                        } // TODO due to HABTM potentially being huge, creating an else might not be plausible
                    }//exit;
                    //pr($row);exit;
                }
                //pr($row);exit;
                $rows[] = $row;
                //pr($rows);exit;
                $firstRecord = false;
            }
            //exit;
            //pr($rows);exit;
            if ($options['headers']) {
//                            //echo $options['headers'];exit;
                // write the 1st row as headings
                //pr($options['delimiter']);exit;
                fputcsv($file, $headers, $options['delimiter'], $options['enclosure']);
            }
            // Row counter
            $r = 0;

            foreach ($rows as $row) {
                //echo $file;exit;
                //pr($row);exit;
                fputcsv($file, $row, $options['delimiter'], $options['enclosure']);
                $r++;
            }

            // close the file
            fclose($file);
            //echo $r;exit;
            return $r;
        } else {
            return false;
        }
    }

    public function importdata($data, $model) {

        $this->modelName = ClassRegistry::init($model);

        if (!empty($data)) {

            if ($data[$model]['file']['name'] != '') {
                $image_upload = $this->__fileupload($data, $model);
                if ($image_upload['status'] == true) {
                    $data = $this->import($image_upload['file']);
                    if ($this->modelName->validates()) {
                        if ($this->modelName->saveMany($data)) {
                            $msg = __('Successfully imported');
                            echo $msg;
                        }
                    } else {
                        echo "fail";
                    }
                } else {
                    $validationError = 1;
                }
            }
        }
    }

    private function __fileupload($data, $model) { // start of fileupload function
        $folder = WWW_ROOT . 'files/csv/'; //file upload directory
        $file = $data[$model]['file']['name'];
        $ext = substr($file, strpos($file, '.') + 1); // getting the extension of the file
        $filename = time() . '.' . $ext; // converting the name of the file to our own name
        $file_name = $folder . $data[$model]['file']['name'];
        if (!empty($data[$model]['file']['name'])) {
            if (move_uploaded_file($data[$model]['file']['tmp_name'], $folder . $filename)) {
                return array('status' => 'true', 'file' => $filename);
            }
        }//end of checking if the value is not empty
    }

    /**
     * Converts a data array into
     *
     * @param string $filename
     * @param string $data
     * @return void
     * @author Dean
     */
    public function exportCafr($filename, $data, $options = array()) {
        //echo $filename;exit;

        $options = array_merge($this->defaults, $options);
        // open the file
        $filePermission = new File($filename, false, 0777);
        $filePermission->delete();
        if ($file = fopen($filename, 'w+')) {
            // Iterate through and format data
            $firstRecord = true;
            foreach ($data as $record) {
                //pr($record);
                //exit;
                $row = array();
                foreach ($record as $model => $fields) {
                    // TODO add parsing for HABTM
                    //pr($fields);exit;
                    foreach ($fields as $field => $value) {
                        //pr($field);
                        if (!is_array($value)) {

                            if ($firstRecord) {
                                //echo 1;exit;
                                $headers[] = $this->_encode($field);
                                //$model . '.' . $field
                            }

                            $row[] = $this->_encode($value);
                        } // TODO due to HABTM potentially being huge, creating an else might not be plausible
                    }//exit;
                    //pr($row);exit;
                }
                //pr($row);exit;
                $rows[] = $row;
                //pr($rows);exit;
                $firstRecord = false;
            }
            //exit;
            //pr($rows);exit;
            if ($options['headers']) {
//                            //echo $options['headers'];exit;
                // write the 1st row as headings
                //pr($options['delimiter']);exit;
                fputcsv($file, $headers, $options['delimiter'], $options['enclosure']);
            }
            // Row counter
            $r = 0;

            foreach ($rows as $row) {
                //echo $file;exit;
                //pr($row);exit;
                fputcsv($file, $row, $options['delimiter'], $options['enclosure']);
                $r++;
            }

            // close the file
            fclose($file);
            //echo $r;exit;
            return $r;
        } else {
            return false;
        }
    }

}
