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
        <h2><?php echo (isset($id) && $id > 0)?__("Edit Institute"):__("Add Institute");?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"dashboards","action"=>"admin_index"));?>"><?php echo __("Dashboards");?></a>
            </li>
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"institutess","action"=>"admin_index"));?>"><?php echo __("Institutes");?></a>
            </li>
            <li class="active">
                <strong><?php echo (isset($id) && $id > 0)?__("Edit"):__("Add");?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5><?php echo (isset($id) && $id > 0)?__("Edit"):__("Add");?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php /*<h2>
                        Validation Wizard Form
                    </h2>
                    <p>
                        This example show how to use Steps with jQuery Validation plugin.
                    </p>
                    */?>
                    <?php
                        echo $this->AppForm->create('Institute', array(
                            'class' => 'wizard-big',
                            'method' => 'post',
                            'enctype' => 'multipart/form-data',
                            'novalidate',
                            "id" => "form"
                        ));
                        echo $this->AppForm->hidden('lat');
                        echo $this->AppForm->hidden('lng');
                    ?>
                        <h1><?php echo __("Basic");?></h1>
                        <fieldset>
                            <h2><?php echo __("Basic Information");?></h2>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label><?php echo __("Name");?> *</label>
                                        <?php
                                            echo $this->AppForm->input('name', array(
                                                'type' => 'text',
                                                'class' => 'form-control required',
                                                'label' => false,
                                                'div' => false,
                                                "placeholder" => "Institute Name"
                                            ));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo __("Landline Number");?> *</label>
                                        <?php
                                            echo $this->AppForm->input('landline_no', array(
                                                'type' => 'text',
                                                'class' => 'form-control required',
                                                'label' => false,
                                                'div' => false,
                                                "placeholder" => "Landline Number"
                                            ));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo __("Logo");?> *</label>
                                        <?php
                                            echo $this->AppForm->input('logo', array(
                                                'type' => 'file',
                                                'class' => (isset($this->request->data) && isset($this->request->data["Institute"]) && isset($this->request->data["Institute"]["logo"]) && $this->request->data["Institute"]["logo"] !="")?'custom_file_button':'custom_file_button required',
                                                'label' => false,
                                                'div' => false,
                                                "placeholder" => "Logo"
                                            ));
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label><?php echo __("Registration Number");?> *</label>
                                        <?php
                                            echo $this->AppForm->input('registration_no', array(
                                                'type' => 'text',
                                                'class' => 'form-control required',
                                                'label' => false,
                                                'div' => false,
                                                "placeholder" => "Registration Number"
                                            ));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo __("Mobile Number");?> *</label>
                                        <?php
                                            echo $this->AppForm->input('phone_no', array(
                                                'type' => 'text',
                                                'class' => 'form-control required',
                                                'label' => false,
                                                'div' => false,
                                                "placeholder" => "Mobile Number"
                                            ));
                                        ?>
                                    </div>
                                    
                                </div>
                            </div>

                        </fieldset>
                        <h1><?php echo __("Description");?></h1>
                        <fieldset>
                            <h2><?php echo __("Institute Description");?></h2>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group ibox-content no-padding">
                                        <?php
                                            echo $this->AppForm->input('description', array(
                                                'class' => 'summernote',
                                                'type' => 'textarea',
                                                'label' => false,
                                                'div' => false,
                                                'cols' => 20
                                            ));
                                            ?>  
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <h1><?php echo __("Location");?></h1>
                        <fieldset>
                            <h2><?php echo __("Location Information");?></h2>
                            <div class="col-lg-8">
                                    <div class="form-group">
                                        <label><?php echo __("Location");?> *</label>
                                        <?php
                                            echo $this->AppForm->input('address', array(
                                                'type' => 'text',
                                                'class' => 'form-control required',
                                                'label' => false,
                                                'div' => false,
                                                "placeholder" => "Location"
                                            ));
                                        ?>
                                    </div>
                                    <div id="regmap_canvas"></div>
                            </div>
                            <div class="col-lg-4">
                                    <div class="form-group">
                                        <label><?php echo __("Land Mark");?> *</label>
                                        <?php
                                            echo $this->AppForm->input('landmark', array(
                                                'type' => 'text',
                                                'class' => 'form-control required',
                                                'label' => false,
                                                'div' => false,
                                                "placeholder" => "Landmark"
                                            ));
                                        ?>
                                    </div>
                            </div>
                        </fieldset>

                        <h1><?php echo __("Settings");?></h1>
                        <fieldset>
                            <h2><?php echo __("Social Settings");?></h2>
                            <div class="col-lg-6">
                                    <div class="form-group">
                                        <label><?php echo __("Facebook URL");?> *</label>
                                        <?php
                                            echo $this->AppForm->input('fb_url', array(
                                                'type' => 'text',
                                                'class' => 'form-control',
                                                'label' => false,
                                                'div' => false,
                                                "placeholder" => "Facebook URL"
                                            ));
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo __("Twitter URL");?> *</label>
                                        <?php
                                            echo $this->AppForm->input('twitter_url', array(
                                                'type' => 'text',
                                                'class' => 'form-control',
                                                'label' => false,
                                                'div' => false,
                                                "placeholder" => "Twitter URL"
                                            ));
                                        ?>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label><?php echo __("Linkedin URL");?> *</label>
                                        <?php
                                            echo $this->AppForm->input('linkedin_url', array(
                                                'type' => 'text',
                                                'class' => 'form-control',
                                                'label' => false,
                                                'div' => false,
                                                "placeholder" => "Linkedin URL"
                                            ));
                                        ?>
                                    </div>
                                </div>
                        </fieldset>
                    <?php echo $this->AppForm->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>