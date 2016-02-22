<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo __("Manage Institutes");?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"dashboards","action"=>"admin_index"));?>"><?php echo __("Dashboards");?></a>
            </li>
            <li class="active">
                <strong><?php echo __("Manage");?></strong>
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
                    echo $this->AppForm->create('InstituteSetting', array(
                        'class' => 'form-horizontal', 
                        'method' => 'post',
                        'enctype' => 'multipart/form-data',
                        'novalidate'
                    ));
                    echo $this->AppForm->hidden("id");
                ?>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Break Time");?></label>

                        <div class="col-sm-6">
                            <?php
                            echo  $this->AppForm->input('break_time',array(
                                'type'=>'select',
                                'class'=>'form-control m-b',
                                'label'=>false,
                                'div'=>false,
                                'options'=>$breakTimes
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Lunch Time");?></label>
                        <div class="col-sm-6">
                            <?php
                            echo  $this->AppForm->input('lunch_time',array(
                                'type'=>'select',
                                'class'=>'form-control m-b',
                                'label'=>false,
                                'div'=>false,
                                'options'=>$lunchTimes
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Period Time");?></label>

                        <div class="col-sm-6">
                            <?php
                            echo  $this->AppForm->input('period_time',array(
                                'type'=>'select',
                                'class'=>'form-control m-b',
                                'label'=>false,
                                'div'=>false,
                                'options'=>$periodTimes
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Max Periods Allowed");?></label>
                        <div class="col-sm-6">
                            <?php
                            echo  $this->AppForm->input('max_periods_allowed',array(
                                'type'=>'select',
                                'class'=>'form-control m-b',
                                'label'=>false,
                                'div'=>false,
                                'options'=>$maxAllowedPeriods
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <?php echo $this->Html->link(_("Cancel"),array("controller"=>"institutes","action"=>"admin_index"),array("class"=>"btn btn-white"));?>
                            <?php
                                echo $this->AppForm->button(__("Save changes"), array(
                                    'class' => 'btn btn-primary',
                                    'type' => 'submit',
                                ));
                            ?>
                        </div>
                    </div>
                <?php echo $this->AppForm->end(); ?>
            </div>
        </div>
    </div>
</div>
</div>    
