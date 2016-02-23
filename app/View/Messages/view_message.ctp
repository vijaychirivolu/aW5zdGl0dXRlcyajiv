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
                            <li><a href="<?php echo $this->Html->Url(array("controller"=>"messages","action"=>"index"));?>"> <i class="fa fa-inbox "></i> Inbox <span class="label label-warning pull-right">16</span> </a></li>
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
                <div class="pull-right tooltip-demo">
                    <a href="mail_compose.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Reply"><i class="fa fa-reply"></i> Reply</a>
                    <a href="#" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Print email"><i class="fa fa-print"></i> </a>
                    <a href="<?php echo $this->Html->Url(array("controller"=>"messages","action"=>"trashById",$type,$messageinfo['Message']['id'])); ?>" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </a>
                </div>
                <h2>
                    View Message
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                    <h3>
                        <span class="font-noraml">Subject: </span><?php echo $messageinfo['Message']['subject']; ?>
                    </h3>
                    <h5>
                        <span class="pull-right font-noraml"><?php echo date('h:iA d M Y', strtotime($messageinfo['Message']['time_created'])); ?></span>
                        <?php if($type == "outbox") { ?>
                        <span class="font-noraml">To: </span><span class="message-receviers"><?php echo $messageinfo['MessageReceiver'][0]['User']['email'] ?></span><?php echo "(".count($messageinfo['MessageReceiver']).")"; ?>
                        <?php } else if($type == "inbox") { ?>
                            <span class="font-noraml">From: </span><span class="message-receviers"><?php echo $messageinfo['MessageReceiver'][0]['User']['email'] ?></span>
                        <?php } ?>
                        
                    </h5>
                </div>
            </div>
            <div class="mail-box">
                <div class="mail-body">
                    <?php echo $messageinfo['Message']['body']; ?>
                </div>
                <?php if($messageinfo['Message']['has_attechments'] != "" && $messageinfo['Message']['has_attechments'] != 0) { ?>
                <div class="mail-attachment">
                    <p>
                        <span><i class="fa fa-paperclip"></i> <?php echo count($messageinfo['MessageAttachment']); ?> attachments - </span>
                        <a href="<?php echo Router::url('/', true).'messages/downloadall/'.$messageinfo['Message']['id'] ?>">Download all</a>
                        <!--|-->
                        <!--a href="#">View all images</a-->
                    </p>
                    
                    <div class="attachment">
                        <?php
                            foreach ($messageinfo['MessageAttachment'] as $key => $value) {
                        ?>
                            <div class="file-box">
                                <div class="file">
                                    <a href="<?php echo Router::url('/', true).'messages/downloaddoc/'.$value['filename'] ?>">
                                        <span class="corner"></span>

                                        <div class="icon">
                                            <i class="fa fa-file"></i>
                                        </div>
                                        <div class="file-name">
                                            <?php echo $value['original_filename']; ?>
                                            <br/>
                                            <small>Added: <?php echo date("M d,Y", strtotime($value['time_created'])); ?></small>
                                        </div>
                                    </a>
                                </div>

                            </div>
                        <?php
                            }
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php } ?>
                <div class="mail-body text-right tooltip-demo">
                    <a class="btn btn-sm btn-white" href="mail_compose.html"><i class="fa fa-reply"></i> Reply</a>
                    <a class="btn btn-sm btn-white" href="<?php echo $this->Html->Url(array("controller"=>"messages","action"=>"composeEmail",$messageinfo['Message']['id'])); ?>"><i class="fa fa-arrow-right"></i> Forward</a>
                    <button title="" data-placement="top" data-toggle="tooltip" type="button" data-original-title="Print" class="btn btn-sm btn-white"><i class="fa fa-print"></i> Print</button>
                    <a href="<?php echo $this->Html->Url(array("controller"=>"messages","action"=>"trashById",$type,$messageinfo['Message']['id'])); ?>" title="" data-placement="top" data-toggle="tooltip" data-original-title="Trash" class="btn btn-sm btn-white"><i class="fa fa-trash-o"></i> Remove</a>
                </div>
                <div class="clearfix"></div>


            </div>
        </div>
    </div>
</div>

