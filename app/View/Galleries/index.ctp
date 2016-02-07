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
        <h2><?php echo __("Gallery");?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"dashboards","action"=>"school_index"));?>"><?php echo __("Dashboards");?></a>
            </li>
            <li class="active">
                <strong><?php echo __("Manage");?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="file-manager">
                        <h5>Show:</h5>
                        <div class="hr-line-dashed"></div>
                        <a class="btn btn-primary btn-block" href="<?php echo $this->Html->Url(array("controller"=>"galleries","action"=>"school_uploads"));?>"><?php echo __("Upload Files");?></a>
                        <div class="hr-line-dashed"></div>
                        <h5>Folders</h5>
                        <?php if (!empty($galleriesResult)) {?>
                            <ul class="folder-list" style="padding: 0">
                                <li><a href="<?php echo $this->Html->Url(array("controller"=>"galleries","action"=>"index"));?>"><i class="fa fa-folder"></i> <?php echo __("All");?></a></li>
                                <?php foreach($galleriesResult as $key=>$res):?> 
                                <li><a href="<?php echo $this->Html->Url(array("controller"=>"galleries","action"=>"index",$res["Gallery"]["id"]));?>"><i class="fa fa-folder"></i> <?php echo ucwords(stripslashes($res["Gallery"]["name"]));?></a></li>
                                <?php endforeach;?>
                            </ul>
                        <?php } else {
                            echo '<p>'.__("No folders found").'.</p>';
                        }?>  
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <?php if (!empty($galleryImages)) {?>
                            <?php foreach($galleryImages as $key=>$row):?> 
                                    <div class="file-box">
                                        <div class="file">
                                            <a href="#">
                                                <span class="corner"></span>

                                                <div class="image">
                                                    <?php echo $this->Html->image("/files/galleries/".$row["GalleryImage"]["filename"],array(
                                                        "alt" => ucwords(stripslashes($row["GalleryImage"]["original_filename"])),
                                                        "class" => "img-responsive"
                                                    ));?>
                                                </div>
                                                <div class="file-name">
                                                    <?php echo ucwords(stripslashes($row["GalleryImage"]["original_filename"]));?>
                                                    <br/>
                                                    <small><?php echo __("Added");?>: <?php echo date("M d, Y",strtotime($row["GalleryImage"]["time_created"]));?></small>
                                                </div>
                                            </a>

                                        </div>
                                    </div>
                            <?php endforeach;?>
                    <?php } else {
                        echo '<p>'.__("No folders found").'.</p>';
                    }?>  
                </div>
            </div>
        </div>
    </div>
</div>