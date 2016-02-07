<?php

/**
 * Login view
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    Login
 * @package     Views:Layouts
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 * @dateCreated 07/17/2015  MM/DD/YYYY
 * @dateUpdated 07/17/2015  MM/DD/YYYY  
 */
?>
<div class="col-md-6">
    <div class="ibox-content">
        <?php echo $this->AppForm->create('User',array(
                'class' => 'm-t validation-form',
                'method' => 'post'
            )); ?>
        <form class="m-t" role="form" action="index.html">
            <div class="form-group">
                <?php echo $this->AppForm->input('email',array(
                    'class' => 'form-control',
                    'type' => 'text',
                    'placeholder' => 'Email',
                    'label'=>false
                ));?>
            </div>
            <div class="form-group">
                <?php echo $this->AppForm->input('password',array(
                    'class' => 'form-control',
                    'type' => 'password',
                    'placeholder' => 'Password',
                    'label'=>false
                ));?>
            </div>
            <?php echo $this->AppForm->button(__('Login'),array(
                    'class' => 'btn btn-primary block full-width m-b',
                    'type' => 'submit',
                ));?>
            <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'forgotPassword'));?>">
                <small><?php echo __("Forgot password");?>?</small>
            </a>
        <?php echo $this->AppForm->end();?>
    </div>
</div>