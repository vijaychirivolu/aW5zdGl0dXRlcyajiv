<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>File upload</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>
                <a>Forms</a>
            </li>
            <li class="active">
                <strong>File upload</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Dropzone Area</h5>
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
                        echo $this->AppForm->create('GalleryImage', array(
                            'class' => 'dropzone',
                            'method' => 'post',
                            'enctype' => 'multipart/form-data',
                            'novalidate',
                            "id" => "my-awesome-dropzone",
                            'url' => array('controller' => "galleries", 'action' => "uploads",$galleryId)
                        ));
                      ?>
                        <div class="dropzone-previews"></div>
                        <?php
                            echo $this->AppForm->button(__("Submit this form!"), array(
                                'class' => 'btn btn-primary pull-right',
                                'type' => 'submit',
                            ));
                        ?>
                    <?php echo $this->AppForm->end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
