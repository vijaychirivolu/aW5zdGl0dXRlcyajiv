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
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-success pull-right">Total</span>
                    <h5><?php echo __("Students");?></h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo isset($StudentCount)?$StudentCount:0;?></h1>
                    <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                    <small>Total income</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-info pull-right"><?php echo __("Total");?></span>
                    <h5><?php echo __("Teachers");?></h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"><?php echo isset($EmployeeCount)?$EmployeeCount:0;?></h1>
                    <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                    <small>New orders</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-primary pull-right">Today</span>
                    <h5>Vistits</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">106,120</h1>
                    <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
                    <small>New visits</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-danger pull-right">Low value</span>
                    <h5><?php echo __("SMS");?></h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">80,600</h1>
                    <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
                    <small>In first month</small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Messages</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content ibox-heading">
                    <h3><i class="fa fa-envelope-o"></i> New messages</h3>
                    <small><i class="fa fa-tim"></i> You have <?php echo isset($NewMsgCnt['NewMsgCount'])?$NewMsgCnt['NewMsgCount']:0?> new messages and <?php echo isset($NewMsgCnt['DraftMsgCnt'])?$NewMsgCnt['DraftMsgCnt']:0 ?> waiting in draft folder.</small>
                </div>
                <div class="ibox-content">
                    <div class="feed-activity-list">

                        <div class="feed-element">
                            <div>
                                <small class="pull-right text-navy">1m ago</small>
                                <strong>Monica Smith</strong>
                                <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum</div>
                                <small class="text-muted">Today 5:60 pm - 12.06.2014</small>
                            </div>
                        </div>

                        <div class="feed-element">
                            <div>
                                <small class="pull-right">2m ago</small>
                                <strong>Jogn Angel</strong>
                                <div>There are many variations of passages of Lorem Ipsum available</div>
                                <small class="text-muted">Today 2:23 pm - 11.06.2014</small>
                            </div>
                        </div>

                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5m ago</small>
                                <strong>Jesica Ocean</strong>
                                <div>Contrary to popular belief, Lorem Ipsum</div>
                                <small class="text-muted">Today 1:00 pm - 08.06.2014</small>
                            </div>
                        </div>

                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5m ago</small>
                                <strong>Monica Jackson</strong>
                                <div>The generated Lorem Ipsum is therefore </div>
                                <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                            </div>
                        </div>


                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5m ago</small>
                                <strong>Anna Legend</strong>
                                <div>All the Lorem Ipsum generators on the Internet tend to repeat </div>
                                <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                            </div>
                        </div>
                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5m ago</small>
                                <strong>Damian Nowak</strong>
                                <div>The standard chunk of Lorem Ipsum used </div>
                                <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                            </div>
                        </div>
                        <div class="feed-element">
                            <div>
                                <small class="pull-right">5m ago</small>
                                <strong>Gary Smith</strong>
                                <div>200 Latin words, combined with a handful</div>
                                <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Timeline</h5>
                    <span class="label label-primary">Meeting today</span>
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

                <div class="ibox-content inspinia-timeline">

                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-xs-3 date">
                                <i class="fa fa-briefcase"></i>
                                6:00 am
                                <br/>
                                <small class="text-navy">2 hour ago</small>
                            </div>
                            <div class="col-xs-7 content no-top-border">
                                <p class="m-b-xs"><strong>Meeting</strong></p>

                                <p>Conference on the sales results for the previous year. Monica please examine sales trends in marketing and products.</p>

                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-xs-3 date">
                                <i class="fa fa-file-text"></i>
                                7:00 am
                                <br/>
                                <small class="text-navy">3 hour ago</small>
                            </div>
                            <div class="col-xs-7 content">
                                <p class="m-b-xs"><strong>Send documents to Mike</strong></p>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-xs-3 date">
                                <i class="fa fa-coffee"></i>
                                8:00 am
                                <br/>
                            </div>
                            <div class="col-xs-7 content">
                                <p class="m-b-xs"><strong>Coffee Break</strong></p>
                                <p>
                                    Go to shop and find some products.
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="row">
                            <div class="col-xs-3 date">
                                <i class="fa fa-phone"></i>
                                11:00 am
                                <br/>
                                <small class="text-navy">21 hour ago</small>
                            </div>
                            <div class="col-xs-7 content">
                                <p class="m-b-xs"><strong>Phone with Jeronimo</strong></p>
                                <p>
                                    Lorem Ipsum has been the industry's standard dummy text ever since.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>