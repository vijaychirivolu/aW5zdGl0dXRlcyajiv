<?php
/**
 * Short description for file : Uploads
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    Home
 * @package     Views:Layouts
 * @author      Priyanka.Ch <priyanka@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 * @dateCreated 07/17/2015  MM/DD/YYYY
 * @dateUpdated 07/17/2015  MM/DD/YYYY  
 */
?>
<div class="passwordBox">
    <div class="page_content row">
        <div class="col-md-12">
            <div class="ibox-content">
                <h2 class="font-bold">Forgot password</h2>
                <p>
                    Enter your email address and your password will be reset and emailed to you.
                </p>
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo $this->AppForm->create('User',array(
                            'class' => 'm-t validation-form','method' => 'post'
                            )); ?>
                            <div class="form-group">
                                <?php echo $this->AppForm->input('email',array(
                                                    'class' => 'form-control',
                                                    'type' => 'email',
                                                    'placeholder' => 'Email address',
                                                    'label' => false
                                                ));?>
                            </div>
                            <button type="submit" class="btn btn-primary block full-width m-b m-t">Reset password</button>
                        <?php echo $this->AppForm->end();?>
                    </div>
                </div>
            </div>
            <br><br>
            <center>
                <small>Need Help?</small><br>
                <a ui-sref="forgot_password"><small>Contact Vendus Support</small></a>
            </center>
        </div>
    </div>
</div>