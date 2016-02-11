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
                    echo $this->AppForm->create('TimeSetting', array(
                        'class' => 'form-horizontal', 
                        'method' => 'post',
                        'enctype' => 'multipart/form-data',
                        'novalidate'
                    ));
                    echo $this->AppForm->hidden("id");
                ?>
                <?php foreach($weekData as $key=>$val){
                    if(isset($val['GroupValue']) && count($val['GroupValue'])){?>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <?php
                            echo  $this->AppForm->input($val['GroupValue']['name'],array(
                                'type'=>'checkbox',
                                'class'=>'i-checks',
                                'value'=>$val['GroupValue']['id'],
                                //'label'=>false,
                                'div'=>false
                            ));                            
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <?php
                            echo  $this->AppForm->input('start_date',array(
                                'type'=>'select',
                                'class'=>'form-control m-b',
                                'label'=>false,
                                'div'=>false,
                                'options'=>$timings
                            ));
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <?php
                            echo  $this->AppForm->input('start_date',array(
                                'type'=>'select',
                                'class'=>'form-control m-b',
                                'label'=>false,
                                'div'=>false,
                                'options'=>$timings
                            ));
                            ?>
                        </div>
                    </div>
                <?php } }?>
                    
                <?php echo $this->AppForm->end(); ?>
            </div>
        </div>
    </div>
</div>
</div>    
