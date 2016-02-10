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
        <h2><?php echo __("Manage Holidays");?></h2>
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
                        <a href="<?php echo $this->Html->Url(array("controller"=>"holidays","action"=>"setup"));?>" class="btn btn-primary "><?php echo __("Add a new holiday");?></a>
                    </div>
                    <table class="table table-striped table-bordered table-hover jquery-dataTable">
                        <thead>
                            <tr>
                                <th><?php echo __("Name");?></th>
                                <th><?php echo __("No Of Day(s)");?></th>
                                <th><?php echo __("Start Date");?></th>
                                <th><?php echo __("End Date");?></th>
                                <th><?php echo __("Actions");?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if (!empty($holidaysList)) {
                                    foreach ($holidaysList as $key => $row) {
                                        $date1 = new DateTime($row['Holiday']['start_date']);
                                        $date2 = new DateTime($row['Holiday']['end_date']);
                                        $noOfDays = $date2->diff($date1)->format("%a");
                                        ?>
                                        <tr>
                                            <td><?php echo ucwords(stripslashes($row['Holiday']['name'])); ?></td>
                                            <td><?php echo ($noOfDays ==0)?1:$noOfDays; ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['Holiday']['start_date'])); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['Holiday']['end_date'])); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <?php echo $this->Html->link(__("Edit"),array("controller"=>"holidays","action"=>"setup",$row["Holiday"]["id"]),array("class"=>"btn-white btn btn-xs"));?>
                                                    <?php echo $this->Html->link(__("Delete"),array("controller"=>"holidays","action"=>"delete",$row["Holiday"]["id"]),array("class"=>"btn-white btn btn-xs delete-confirm-alert","data-message"=>"You are permenantly deleting this holiday!"));?>
                                                </div>
                                            </td>
                                        </tr> 
                                <?php }}?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
