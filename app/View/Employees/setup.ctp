<?php

/**
 * Short description for file : Add and delete employees
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    Employees
 * @package     Views:Employees
 * @author      Pushkar <pushkar@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/Ourwebsites/AdminData
 * @dateCreated 02/18/2016  MM/DD/YYYY
 * @dateUpdated 02/18/2016  MM/DD/YYYY  
 */
?>
<?php if (!$this->request->is('ajax')) { ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($id) && $id > 0) ?__("Edit Employee"):__("Add Employee");?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"dashboards","action"=>"index"));?>"><?php echo __("Dashboards");?></a>
            </li>
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"employees","action"=>"index"));?>"><?php echo __("Employees");?></a>
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
                    echo $this->AppForm->create('Employee', array(
                        'class' => 'form-horizontal ajax-form', 
                        'method' => 'post',
                        'enctype' => 'multipart/form-data',
                        'novalidate'
                    ));
                    echo $this->AppForm->hidden("id");
                ?>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("First Name");?></label>
                        <div class="col-sm-4">
                            <?php
                            echo  $this->AppForm->input('first_name',array(
                                'type'=>'text',
                                'class'=>'form-control m-b required',
                                'label'=>false,
                                'div'=>false
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Last Name");?></label>
                        <div class="col-sm-4">
                            <?php
                            echo  $this->AppForm->input('last_name',array(
                                'type'=>'text',
                                'class'=>'form-control m-b required',
                                'label'=>false,
                                'div'=>false
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Email");?></label>
                        <div class="col-sm-4">
                            <?php
                            echo  $this->AppForm->input('user.email',array(
                                'type'=>'text',
                                'class'=>'form-control m-b required',
                                'label'=>false,
                                'div'=>false
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Qualification");?></label>
                        <div class="col-sm-4">
                            <?php
                            echo  $this->AppForm->input('qualification',array(
                                'type'=>'text',
                                'class'=>'form-control m-b required',
                                'label'=>false,
                                'div'=>false
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Gender");?></label>
                        <div class="col-sm-4">
                            <?php
                            echo  $this->AppForm->input('gender',array(
                                'type'=>'radio',
                                'class'=>'form-control m-b required',
                                'legend'=>false,
                                'div'=>TRUE,
                                'label'=>array('class'=>"col-sm-5"),
                                'value'=>8001,
                                'options'=>array(8001=>'Male',8002=>"Female")
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Skills");?></label>
                        <div class="col-sm-8">
                            <?php
                            foreach($instituteSkills as $k => $res) {
                                echo $this->AppForm->input($res, array(
                                  'type'=>'checkbox', 
                                    'name'=>'EmployeeSkill['.$k.']',
                                  'div'=>array('class'=>'col-sm-3')
                            ) ); 
                            }
                            ?>                            
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Date Of Joining");?></label>
                        <div class="col-sm-4">
                            <?php
                            echo  $this->AppForm->input('date_of_joining',array(
                                'type'=>'text',
                                'class'=>'form-control m-b required date-picker',
                                'label'=>false,
                                'div'=>false,
                                'value' => (isset($this->request->data) && isset($this->request->data["Student"]["date_of_joining"]) && $this->request->data["Student"]["date_of_joining"] !="")?date("d/m/Y",strtotime($this->request->data["Student"]["date_of_joining"])):""
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Image");?></label>
                        <div class="col-sm-4">
                            <?php
                            echo  $this->AppForm->input('image',array(
                                'type'=>'file',
                                'class'=>'form-control m-b custom_file_button',
                                'label'=>false,
                                'div'=>false
                            ));
                            ?>
                        </div>
                    </div>
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