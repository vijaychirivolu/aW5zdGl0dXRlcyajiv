<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php if (!$this->request->is('ajax')) { ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo (isset($id) && $id > 0) ?__("Edit Holiday"):__("Add Holiday");?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"dashboards","action"=>"index"));?>"><?php echo __("Dashboards");?></a>
            </li>
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"holidays","action"=>"index"));?>"><?php echo __("Holidays");?></a>
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
                    echo $this->AppForm->create('Holiday', array(
                        'class' => 'form-horizontal ajax-form', 
                        'method' => 'post',
                        'enctype' => 'multipart/form-data',
                        'novalidate'
                    ));
                    echo $this->AppForm->hidden("id");
                ?>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Name");?></label>

                        <div class="col-sm-6">
                            <?php
                            echo  $this->AppForm->input('name',array(
                                'type'=>'text',
                                'class'=>'form-control m-b required',
                                'label'=>false,
                                'div'=>false
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Description");?></label>
                        <div class="col-sm-6">
                            <?php
                            echo  $this->AppForm->input('description',array(
                                'type'=>'textarea',
                                'class'=>'form-control m-b',
                                'label'=>false,
                                'div'=>false
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="input-daterange">
                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("Start Date");?></label>
                        <div class="col-sm-6">
                            <?php
                            echo  $this->AppForm->input('start_date',array(
                                'type'=>'text',
                                'class'=>'form-control m-b required',
                                'label'=>false,
                                'div'=>false,
                                'value' => (isset($this->request->data) && isset($this->request->data["Holiday"]["start_date"]) && $this->request->data["Holiday"]["start_date"] !="")?date("d/m/Y",strtotime($this->request->data["Holiday"]["start_date"])):""
                            ));
                            ?>
                        </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group"><label class="col-sm-2 control-label"><?php echo __("End Date");?></label>
                            <div class="col-sm-6">
                                <?php
                                echo  $this->AppForm->input('end_date',array(
                                    'type'=>'text',
                                    'class'=>'form-control m-b required',
                                    'label'=>false,
                                    'div'=>false,
                                    'value' => (isset($this->request->data) && isset($this->request->data["Holiday"]["end_date"]) && $this->request->data["Holiday"]["end_date"] !="")?date("d/m/Y",strtotime($this->request->data["Holiday"]["end_date"])):""
                                ));
                                ?>
                            </div>
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