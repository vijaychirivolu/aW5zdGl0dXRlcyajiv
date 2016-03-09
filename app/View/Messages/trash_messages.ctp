<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content mailbox-content">
                    <div class="file-manager">
                        <a class="btn btn-block btn-primary compose-mail" href="<?php echo $this->Html->Url(array("controller"=>"messages","action"=>"composeEmail"));?>">Compose Mail</a>
                        <div class="space-25"></div>
                        <h5>Folders</h5>
                        <ul class="folder-list m-b-md" style="padding: 0">
                            <li><a href="<?php echo $this->Html->Url(array("controller"=>"messages","action"=>"index"));?>"> <i class="fa fa-inbox "></i> Inbox <span class="label label-warning pull-right inbox-unread-count">16</span> </a></li>
                            <li><a href="<?php echo $this->Html->Url(array("controller"=>"messages","action"=>"sentMail"));?>"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                            <!--li><a href="mailbox.html"> <i class="fa fa-certificate"></i> Important</a></li-->
                            <!--li><a href="<?php echo $this->Html->Url(array("controller"=>"messages","action"=>"index"));?>"> <i class="fa fa-file-text-o"></i> Drafts <span class="label label-danger pull-right">2</span></a></li-->
                            <li><a href="<?php echo $this->Html->Url(array("controller"=>"messages","action"=>"trashMessages"));?>"> <i class="fa fa-trash-o"></i> Trash</a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">

                <form method="get" action="index.html" class="pull-right mail-search">
                    <div class="input-group">
                        <input type="text" class="form-control input-sm" name="search" placeholder="Search email">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
                <h2>
                    Trash <span id="outboxcount">(0)</span>
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                    <!--div class="btn-group pull-right">
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>

                    </div-->
                    <button class="btn btn-white btn-sm refresh-trash-messages" data-toggle="tooltip" data-placement="left" title="Refresh outbox" id="refreshoutbox"><i class="fa fa-refresh"></i> Refresh</button>
                    <!--button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as read"><i class="fa fa-eye"></i> </button-->
                    <!--button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as important"><i class="fa fa-exclamation"></i> </button-->
                    <button class="btn btn-white btn-sm perminent-delete" data-toggle="tooltip" data-placement="top" title="Move to trash" id="deltemessage"><i class="fa fa-trash-o"></i> </button>

                </div>
            </div>
            <div class="ibox-content">

                <table class="table table-hover table-mail trashmessages-table" id="trashbox_table">
                    <thead>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </thead>
                </table>


            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="pull-right">
        10GB of <strong>250GB</strong> Free.
    </div>
    <div>
        <strong>Copyright</strong> Example Company &copy; 2014-2015
    </div>
</div>