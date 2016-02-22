<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo __("Manage Timings");?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"institutes","action"=>"admin_index"));?>"><?php echo __("Institutes");?></a>
            </li>
            <li class="active">
                <strong><?php echo __("Timings");?></strong>
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
                <div class="col-lg-12 m-b">
                <div class="col-sm-3"></div>
                <div class="col-sm-3 text-center"><strong>Start Time</strong></div>
                <div class="col-sm-3 text-center"><strong>End Time</strong></div>
            </div>
                <?php
                    echo $this->AppForm->create('InstituteTiming', array(
                        'class' => 'form-horizontal', 
                        'method' => 'post',
                        'enctype' => 'multipart/form-data',
                        'novalidate'
                    ));
                    
                ?>
                <?php 
                if (!empty($instituteHours)) {     
                foreach($instituteHours as $key=>$row) { 
                    ?>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <?php
                            echo  $this->AppForm->input($key.'.InstituteTiming.week_id',array(
                                'type'=>'checkbox',
                                'multiple' => 'checkbox',
                                'class'=>'i-checks institute_timings',
                                'label' => array('text' => __($row['GroupValue']['name'])),
                                'value'=>$row['GroupValue']['id'],
                                'div'=>false,
                                'hiddenField'=>false,
                                'id' => $row['GroupValue']['id']."_week",
                                'default' => (isset($row["GroupValue"]["checked_values"]) && $row["GroupValue"]["checked_values"]["week_id"] == $row["GroupValue"]["id"])?true:false,
                            ));                            
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <?php
                            echo  $this->AppForm->input($key.'.InstituteTiming.opening_hours',array(
                                'type'=>'select',
                                'class'=>'form-control m-b ajax-changing-timings',
                                'label'=>false,
                                'div'=>false,
                                'options'=>$timings,
                                'id' => $row['GroupValue']['id']."-opening_hours",
                                'default' => (isset($row["GroupValue"]["checked_values"]))?date("H:i",strtotime($row["GroupValue"]["checked_values"]['opening_hours'])):"00:00"                              
                            ));
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <?php
                            echo  $this->AppForm->input($key.'.InstituteTiming.closing_hours',array(
                                'type'=>'select',
                                'class'=>'form-control m-b ajax-changing-timings',
                                'label'=>false,
                                'div'=>false,
                                'id' => $row['GroupValue']['id']."-closing_hours",
                                'options'=>$timings,
                                'default' => (isset($row["GroupValue"]["checked_values"]))?date("H:i",strtotime($row["GroupValue"]["checked_values"]['closing_hours'])):"00:00"                              
                                
                            ));
                            ?>
                        </div>
                        
                    </div>
                <?php } }?>
                 <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-4">
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