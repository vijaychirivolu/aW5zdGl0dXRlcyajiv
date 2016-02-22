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
<?php echo $this->Breadcrumb->render(); ?>
<div class="wrapper wrapper-content animated fadeInRight">
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
                    <div class="row">
                        <?php
                        echo $this->AppForm->create('Student', array(
                            'method' => 'post',
                            'enctype' => 'multipart/form-data',
                            'novalidate',
                            "id" => "studentSearchFilterForm"
                        ));
                        ?>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="keyword">Keyword</label>
                                <?php
                                    echo $this->AppForm->input('keyword', array(
                                        'type' => 'text',
                                        'class' => 'form-control required',
                                        'label' => false,
                                        'div' => false,
                                        "placeholder" => "Name Or Admission No"
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="class">Class</label>
                                <?php
                                    echo  $this->AppForm->input('current_class_id',array(
                                        'type'=>'select',
                                        'class'=>'form-control m-b',
                                        'options' => $classResult,
                                        'label'=>false,
                                        'div'=>false
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="section">Section</label>
                                <?php
                                    echo  $this->AppForm->input('current_section_id',array(
                                        'type'=>'select',
                                        'class'=>'form-control m-b',
                                        'options' => array(),
                                        'label'=>false,
                                        'div'=>false
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label" for="apply"></label>
                                <?php
                                echo $this->AppForm->button(__("Apply"), array(
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
    <div class="row table-none" id="student-table-results">
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
                        <a href="<?php echo $this->Html->Url(array("controller"=>"students","action"=>"setup"));?>" class="btn btn-primary "><?php echo __("Add a new student");?></a>
                    </div>
                    <table class="table table-striped table-bordered table-hover" id="studentsResultsByFilters">
                        <thead>
                            <tr>
                                <th><?php echo __("Name");?></th>
                                <th><?php echo __("Admission Number");?></th>
                                <th><?php echo __("Class");?></th>
                                <th><?php echo __("Section");?></th>
                                <th><?php echo __("Date Of Joining");?></th>
                                <th><?php echo __("Actions");?></th>
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
