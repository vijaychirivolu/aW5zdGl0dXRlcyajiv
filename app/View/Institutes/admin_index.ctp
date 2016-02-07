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
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?php echo __("Upload Institute Data");?></h5>
                    <h5 class="pull-right">
                        <span><?php echo __("Download Template");?>:</span>
                        <span>
                                <?php echo $this->Html->link(
                                    $this->Html->image('file_csv.png',array(
                                        "height" => 20,
                                        "alt" => "csv"
                                    )),array(
                                        'controller' => "schools",
                                        "action" => "admin_downloadTemplate",
                                        "csv"
                                    ), array(
                                        'escape' => false
                                    )
                                );
                                ?>
                        </span>
                        <span>
                                <?php echo $this->Html->link($this->Html->image("xls_file.png",array(
                                    "height" => 20,
                                    "alt" => "XLS"
                                )),array(
                                    "controller" => "schools",
                                    "action" => "admin_downloadTemplate",
                                    "xls"
                                ), array(
                                    'escape' => false
                                ));?>
                        </span>
                    </h5>
                    <div ibox-tools></div>
                </div>
                <div class="ibox-content">
                        <?php
                        echo $this->AppForm->create('UploadInstituteData', array(
                            'class' => 'form-horizontal',
                            'method' => 'post',
                            'enctype' => 'multipart/form-data',
                            'novalidate',
                            'url' => array('controller' => "schools", 'action' => "admin_uploadInstituteData")
                        ));
                        ?>
                    <div class="form-group upload">
                        <div class="col-lg-12 browse_height">
                            <h5><?php echo __("Upload a Institute file");?> (CSV or XCEL only)</h5>
                            <div class="input-group col-lg-11">
                                    <?php
                                        echo $this->AppForm->input('filename', array(
                                            'type' => 'file',
                                            'class' => 'custom_file_button',
                                            'label' => false,
                                            'div' => false
                                        ));
                                    ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group upload m-t">
                        <div class="col-lg-10">
                            <div class="input-group">
                                    <?php
                                    echo $this->AppForm->button(__("Upload"), array(
                                        'class' => 'btn btn-primary upload_button cafr_upload',
                                        'type' => 'submit',
                                    ));
                                    ?>
                            </div>
                        </div>
                    </div>
                        <?php echo $this->AppForm->end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Editable Table in- combination with jEditable</h5>
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
                    <div class="">
                        <a href="<?php echo $this->Html->Url(array("controller"=>"schools","action"=>"admin_setup"));?>" class="btn btn-primary "><?php echo __("Add a new school");?></a>
                    </div>
                    <table class="table table-striped table-bordered table-hover school-ajax-dataTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Registration No</th>
                                <th>Street Address</th>
                                <th>City</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
