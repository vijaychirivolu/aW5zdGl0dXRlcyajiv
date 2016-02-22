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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="pull-right mail-search">
            <?php
                echo $this->AppForm->create('Gallery', array(
                    'class' => 'form-horizontal', 
                    'method' => 'post',
                    'enctype' => 'multipart/form-data',
                    'novalidate'
                ));
            ?>
            <div class="input-group">
                <?php
                echo  $this->AppForm->input('keyword',array(
                    'type'=>'text',
                    'class'=>'form-control m-b',
                    'label'=>false,
                    'div'=>false,
                    'default' => $keyword
                    
                ));
                ?>
                <div class="input-group-btn">
                    <button class="btn btn-sm btn-primary" type="submit">
                        Search
                    </button>
                </div>
            </div>
            <?php echo $this->AppForm->end(); ?>
        </div>
    </div>
    <div class="clear"></div>
    <div class="row">
        <?php if(!empty($galleriesResult)) {
            foreach ($galleriesResult as $key=>$res):?>
                <div class="col-md-3">
                    <div class="ibox">
                        <div class="ibox-content product-box albums">

                            <div class="product-imitation">
                                <?php 
                                if (isset($res["GalleryImage"]) && isset($res["GalleryImage"]["filename"]) && $res["GalleryImage"]["filename"] !="" && file_exists(WWW_ROOT."files/galleries/".$res["GalleryImage"]["filename"])) {
                                    echo $this->Html->image("/files/galleries/".$res["GalleryImage"]["filename"],array(
                                        "alt" => ucwords(stripslashes($res["GalleryImage"]["original_filename"])),
                                        "class" => "img-responsive"
                                    ));
                                } else {
                                    echo $this->Html->image("/files/galleries/1455109567_1_0.jpg",array(
                                        "alt" => "No Image",
                                        "class" => "img-responsive"
                                    ));
                                }
                                
                                ?>
                            </div>
                            <div class="product-desc">
                                <a href="<?php echo $this->Html->Url(array("controller"=>"galleries","action"=>"images",$res["Gallery"]["id"]));?>">
                                    <span class="product-price"><?php echo __("View");?></span>
                                </a>
                                <a href="<?php echo $this->Html->Url(array("controller"=>"galleries","action"=>"images",$res["Gallery"]["id"]));?>" class="product-name"><?php echo ucwords(stripslashes($res["Gallery"]["name"]));?></a>
                                <div class="small m-t-xs">
                                    <?php 
                                        echo date("M d, Y",strtotime($res["Gallery"]["time_created"]));
                                    ?>
                                </div>
                                <div class="m-t text-righ">
                                    <a href="<?php echo $this->Html->Url(array("controller"=>"galleries","action"=>"uploads",$res["Gallery"]["id"]));?>" class="btn btn-xs btn-outline btn-primary"><?php echo __("Upload Files");?> <i class="fa fa-long-arrow-right"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        } ?>
    </div>
</div>