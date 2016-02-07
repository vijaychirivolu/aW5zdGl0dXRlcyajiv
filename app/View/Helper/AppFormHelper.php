<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppFormHelper
 *
 * @author Gupta
 */
//create this file called 'MyFormHelper.php' in your View/Helper folder
App::uses('FormHelper', 'View/Helper');
class AppFormHelper extends FormHelper {


  
  /**
 * Generate format options
 *
 * @param array $options
 * @return array
 */
    protected function _getFormat($options) {
            if (is_array($options['format']) && in_array('input', $options['format'])) {
                    return $options['format'];
            }
            if ($options['type'] === 'hidden') {
                    return array('input');
            }elseif ($options['type'] === 'checkbox') {
                    return array('before', 'input', 'between', 'label', 'error', 'after');
            }elseif ($options['type'] === 'radio') {
                    return array('error', 'before', 'input', 'between', 'label', 'after');
            }
            return array('before', 'label', 'between', 'input', 'error', 'after');
    }
}