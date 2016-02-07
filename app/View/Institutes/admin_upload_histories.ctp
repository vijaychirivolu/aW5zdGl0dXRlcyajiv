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
        <h2><?php echo __("Upload Histories");?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"dashboards","action"=>"admin_index"));?>"><?php echo __("Dashboards");?></a>
            </li>
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"institutes","action"=>"admin_index"));?>"><?php echo __("Schools");?></a>
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
                    <h5><?php echo __("Upload Histories");?></h5>
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
                    <table class="table table-striped table-bordered table-hover jquery-dataTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th><?php echo __("File Name");?></th>
                                <th><?php echo __("Status");?></th>
                                <th><?php echo __("Error Report");?></th>
                                <th><?php echo __("Error Message");?></th>
                                <th><?php echo __("Uploaded By");?></th>
                                <th><?php echo __("Date & Time");?></th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php 
                                if (!empty($historyList)) {
                                    foreach ($historyList as $key=>$val):
                                    $key++;
                                    ?>
                                    <tr>
                                        <td><?php echo $key;?></td>
                                        <td>
                                            <?php 
                                                echo $this->Html->link($val["UploadHistory"]["original_filename"],array(
                                                   'controller' => "dashboards",
                                                    "action" => "admin_downloadHistoryData",
                                                    $val["UploadHistory"]["id"]
                                                ));
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($val["UploadHistory"]["error_message"] != "") {
                                                echo '<a class="btn btn-danger status_btn">' . __("Failed") . '</a>';
                                            } else {
                                                echo '<a class="btn btn-success status_btn">' . __("Success") . '</a>';
                                            }
                                            ?>
                                            </td>
                                        <td>
                                            <?php if ($val["UploadHistory"]["error_filename"] !="") {
                                                echo $this->Html->link($val["UploadHistory"]["error_filename"],array(
                                                   'controller' => "dashboards",
                                                    "action" => "admin_downloadErrorReport",
                                                    $val["UploadHistory"]["id"]
                                                ));
                                            } else {
                                                echo "N/A";
                                            }?>
                                        </td>
                                        <td>
                                            <?php if ($val["UploadHistory"]["error_message"] !="") { ?>
                                                <?php echo $val["UploadHistory"]["error_message"];?>
                                            <?php } else {
                                                echo "N/A";
                                            }?>
                                        </td>
                                        <td><?php echo ucwords(stripslashes($val["User"]["first_name"]))." ".ucwords(stripslashes($val["User"]["last_name"]));?></td>
                                        <td>
                                            <?php echo date('d-m-Y', strtotime($val["UploadHistory"]["time_created"])) . ' at ' . date('H:i', strtotime($val["UploadHistory"]["time_created"]));?>
                                        </td>
                                    </tr>
                                <?php endforeach;
                                } ?>
                            </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
