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
//pr($userdetails);exit;
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo __("Manage Users");?></h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo $this->Html->Url(array("controller"=>"Users","action"=>"admin_manage"));?>"><?php echo __("Users");?></a>
            </li>
            <li class="active">
                <strong><?php echo __("Manage");?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="admin_data">
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo __("Users");?></h5>
                        <div ibox-tools></div>
                    </div>
                    <div class="ibox-content users_content">
                        <a href="<?php echo $this->Html->webroot;?>admin/users/setup">
                            <input type="submit" value="Add new user" class="btn btn-primary add_user_button user_margin content_margin">
                        </a>
                        <div><br></div>
                        <table class="table table-striped table-bordered table-hover user-ajax-dataTable">
                            <thead>
                                <tr>
                                    <th><?php echo __("Name");?></th>
                                    <th><?php echo __("Email");?></th>
                                    <th><?php echo __("Role");?></th>
                                    <th><?php echo __("School");?></th>
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
</div>
