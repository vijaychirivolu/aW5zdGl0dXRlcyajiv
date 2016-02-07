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
 * @link        http://localhost/Ourwebsites/AdminData
 * @dateCreated 07/17/2015  MM/DD/YYYY
 * @dateUpdated 07/17/2015  MM/DD/YYYY  
 */
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo __("Add Users");?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"Users","action"=>"admin_manage"));?>"><?php echo __("Users");?></a>
            </li>
            <li class="active">
                <strong><?php echo __("Add User");?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<?php if (!$this->request->is('ajax')) { ?>
<div class="container admin_data">
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo $heading;?></h5>
                        <div ibox-tools>
                            <a class="cancel_button cancel_margin pull-right" href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'manage')); ?>"><?php echo __("Cancel"); ?></a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <?php } ?>
                        <?php
                            echo $this->AppForm->create('User', array(
                                'class' => 'validation-form ajax-form',// 
                                'method' => 'post',
                                'enctype' => 'multipart/form-data',
                                'novalidate'
                            ));
                            echo $this->AppForm->hidden("id");
                        ?>
                            <div class="form-group">
                                <?php
                                    echo $this->AppForm->input('first_name', array(
                                        'class' => 'form-control',
                                        'type' => 'text',
                                        'label' => 'Name',
                                        'placeholder' => 'Full Name Goes Here'
                                    ));
                                ?>
                            </div>
                            <div class="form-group m-t">
                                <?php
                                    echo $this->AppForm->input('email', array(
                                        'class' => 'form-control',
                                        'type' => 'email',
                                        'label' => 'Email Address',
                                        'placeholder' => 'Email Address Goes Here'
                                    ));
                                ?>
                            </div>
                            <div class="form-group m-t">
                                <?php
                                    echo $this->AppForm->input('password', array(
                                        'class' => 'form-control required',
                                        'type' => 'password',
                                        'label' => 'Password',
                                        'placeholder' => 'Create a Password'
                                    ));
                                ?>
                            </div>
                            <div class="form-group m-t">
                                <label>Role</label>
                                 <?php
                                    $userTypesOptions = array(
                                        "" => "--Select--",
                                      1001 => "Super Admin",
                                      1002 => "Admin",
                                      1003 => "School Admin",
                                      1004 => "Branch Admin",
                                      1005 => "Teacher",
                                      1006 => "Accountant"
                                    );
                                    echo $this->AppForm->input('user_role', array(
                                        'type' => 'select',
                                        'class' => 'form-control required user-role',
                                        'placeholder' => "Please Select Role",
                                        'label' => false,
                                        'options' => $userTypesOptions
                                    ));
                                    ?>
                            </div>
                            <div class="form-group m-t role-based-hide">
                                <label>State</label>
                                 <?php
                                    echo $this->AppForm->input('user_state', array(
                                        'type' => 'select',
                                        'class' => 'form-control required citi-by-state',
                                        'placeholder' => "Please Select State",
                                        'label' => false,
                                        'options' => $userStateOptions
                                    ));
                                    ?>
                            </div>
                            <div class="form-group m-t role-based-hide">
                                <label>City</label>
                                 <?php
                                    echo $this->AppForm->input('user_city', array(
                                        'type' => 'select',
                                        'class' => 'form-control required city-state-address',
                                        'placeholder' => "Please Select City",
                                        'label' => false,
                                        'options' => $userCityOptions
                                    ));
                                    ?>
                            </div>
                            <div class="form-group m-t role-based-hide">
                                <label>Address</label>
                                 <?php
                                    echo $this->AppForm->input('user_address', array(
                                        'type' => 'select',
                                        'class' => 'form-control required school-address',
                                        'placeholder' => "Please Select Address",
                                        'label' => false,
                                        'options' => $userAddressOptions
                                    ));
                                    ?>
                            </div>
                            <div class="form-group m-t role-based-hide">
                                <label>School</label>
                                 <?php
                                    echo $this->AppForm->input('school_id', array(
                                        'type' => 'select',
                                        'class' => 'form-control required ',
                                        'placeholder' => "Please Select School",
                                        'label' => false,
                                        'options' => $userSchoolOptions
                                    ));
                                    ?>
                            </div>
                            <div class="form-group m-t">
                                <?php
                                    echo $this->AppForm->button(__($button), array(
                                        'class' => 'btn btn-primary add_user_button',
                                        'type' => 'submit',
                                    ));
                                ?>
                                <a class="cancel_button cancel_margin" href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'manage')); ?>"><?php echo __("Cancel"); ?></a>
                            <?php echo $this->AppForm->end(); ?>
                            <?php if (!$this->request->is('ajax')) { ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
</div>
<?php } ?>