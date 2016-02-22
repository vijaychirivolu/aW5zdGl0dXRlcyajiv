<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo __("Manage Skills");?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"institutes","action"=>"admin_index"));?>"><?php echo __("Institutes");?></a>
            </li>
            <li class="active">
                <strong><?php echo __("Skills");?></strong>
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
                    echo $this->AppForm->create('Skill', array(
                        'class' => 'form-horizontal', 
                        'method' => 'post',
                        'enctype' => 'multipart/form-data',
                        'novalidate'
                    ));
                    
                ?>
                <?php 
                if (!empty($defaultSkills)) {     
                foreach($defaultSkills as $key=>$row) { 
                    ?>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <?php
                            echo  $this->AppForm->input($key.'.Skill.name',array(
                                'type'=>'checkbox',
                                'multiple' => 'checkbox',
                                'class'=>'i-checks',
                                'label' => array('text' => __($row['Skill']['name'])),
                                'value'=>$row['Skill']['name'],
                                'div'=>false,
                                'hiddenField'=>false,
                                'id' => $row['Skill']['id']."_skills",
                                'default' => (isset($row["Skill"]["checked_values"]) && $row["Skill"]["checked_values"] == $row["Skill"]["name"])?true:false,
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