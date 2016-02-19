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
<?php if (!$this->request->is('ajax')) { ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($id) && $id > 0) ?__("Edit Student"):__("Add Student");?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"dashboards","action"=>"index"));?>"><?php echo __("Dashboards");?></a>
            </li>
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"students","action"=>"index"));?>"><?php echo __("Students");?></a>
            </li>
            
            <li class="active">
                <strong><?php echo (isset($id) && $id > 0) ?__("Edit"):__("Add");?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>All form elements <small>With custom checbox and radion elements.</small></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#">Config option 1</a>
                        </li>
                        <li><a href="#">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <?php
}
                    echo $this->AppForm->create('User', array(
                        'class' => 'form-horizontal validation-form',// ajax-form 
                        'method' => 'post',
                        'enctype' => 'multipart/form-data',
                        'novalidate'
                    ));
                    echo $this->AppForm->hidden("id");
                ?>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("First Name");?></label>

                        <div class="col-sm-6">
                            <?php
                            echo $this->AppForm->input('first_name', array(
                                'class' => 'form-control required',
                                'type' => 'text',
                                'label' => false,
                                'placeholder' => 'First Name Goes Here'
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Last Name");?></label>
                        <div class="col-sm-6">
                            <?php
                            echo $this->AppForm->input('last_name', array(
                                'class' => 'form-control required',
                                'type' => 'text',
                                'label' => false,
                                'placeholder' => 'Last Name Goes Here'
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Email");?></label>
                        <div class="col-sm-6">
                            <?php
                            echo $this->AppForm->input('email', array(
                                'class' => 'form-control required email',
                                'type' => 'email',
                                'label' => false,
                                'placeholder' => 'Email Address Goes Here'
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Password");?></label>
                        <div class="col-sm-6">
                            <?php
                            echo $this->AppForm->input('password', array(
                                'class' => 'form-control required',
                                'type' => 'password',
                                'label' => false,
                                'placeholder' => 'Create a Password'
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Role");?></label>
                        <div class="col-sm-6">
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
                            echo $this->AppForm->input('UserAccessLevel.user_role', array(
                                'type' => 'select',
                                'class' => 'form-control required user-role',
                                'placeholder' => "Please Select Role",
                                'label' => false,
                                'options' => $userTypesOptions
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("State");?></label>
                        <div class="col-sm-6">
                            <?php
                            echo $this->AppForm->input('UserAccessLevel.user_state', array(
                                'type' => 'select',
                                'class' => 'form-control citi-by-state',
                                'placeholder' => "Please Select State",
                                'label' => false,
                                'options' => $userStateOptions
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("City");?></label>
                        <div class="col-sm-6">
                            <?php
                            echo $this->AppForm->input('UserAccessLevel.user_city', array(
                                'type' => 'select',
                                'class' => 'form-control city-state-address',
                                'placeholder' => "Please Select City",
                                'label' => false,
                                'options' => $userCityOptions
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Address");?></label>
                        <div class="col-sm-6">
                            <?php
                            echo $this->AppForm->input('UserAccessLevel.user_address', array(
                                'type' => 'select',
                                'class' => 'form-control school-address',
                                'placeholder' => "Please Select Address",
                                'label' => false,
                                'options' => $userAddressOptions
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Institute Name");?></label>
                        <div class="col-sm-6">
                            <?php
                            echo $this->AppForm->input('UserAccessLevel.institute_id', array(
                                'type' => 'select',
                                'class' => 'form-control',
                                'placeholder' => "Please Select School",
                                'label' => false,
                                'options' => $userInstituteOptions
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <?php echo $this->Html->link(_("Cancel"),array("controller"=>"dashboards","action"=>"index"),array("class"=>"btn btn-white"));?>
                            <?php
                                echo $this->AppForm->button(__("Save changes"), array(
                                    'class' => 'btn btn-primary',
                                    'type' => 'submit',
                                ));
                            ?>
                        </div>
                    </div>
                <?php echo $this->AppForm->end(); ?>
                    <?php if (!$this->request->is('ajax')) { ?>
            </div>
        </div>
    </div>
</div>
</div>    
                    <?php } ?>