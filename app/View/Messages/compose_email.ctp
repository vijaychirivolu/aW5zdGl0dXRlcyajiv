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
                            <li><a href="<?php echo $this->Html->Url(array("controller"=>"messages","action"=>"index"));?>"> <i class="fa fa-trash-o"></i> Trash</a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">
                <div class="pull-right tooltip-demo">
                    <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to draft folder"><i class="fa fa-pencil"></i> Draft</a>
                    <a href="mailbox.html" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Discard</a>
                </div>
                <h2>
                    Compse mail                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
                </h2>
            </div>
            <div class="mail-box">
                <div class="mail-body">
                    <?php  
                        echo $this->AppForm->create('Message', array(
                            'class' => 'form-horizontal ajax-form ', 
                            'method' => 'post',
                            'enctype' => 'multipart/form-data',
                            'novalidate'
                        ));
                        echo $this->AppForm->hidden("toid");
                    ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">To:</label>
                        <div class="col-sm-10">
                            <?php
                                echo  $this->AppForm->input('to_mail',array(
                                    'type'=>'text',
                                    'class'=>'form-control to-mail required',
                                    'label'=>false,
                                    'div'=>false
                                ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Subject:</label>
                        <div class="col-sm-10">
                            <?php
                                echo  $this->AppForm->input('subject',array(
                                    'type'=>'text',
                                    'class'=>'form-control',
                                    'label'=>false,
                                    'div'=>false
                                ));
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?php
                            echo  $this->AppForm->input('body',array(
                                'type'=>'textarea',
                                'class'=>'summernote',
                                'label'=>false,
                                'div'=>false
                            ));
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                            echo  $this->AppForm->input('file.',array(
                                'type'=>'file',
                                'class'=>'form-control disp-hide',
                                'accept' => "/*",
                                'multiple' => true,
                                'label'=>false,
                                'div'=>false
                            ));
                        ?>
                    </div>
                    <div class="mail-body text-right attachment-class">
                        <label class="no-of-attachments"></label>
                        <a id="attach_id" class="btn btn-white btn-sm" ><i class="fa fa-paperclip"></i> Attach</a>
                        <button type="submit" id="send_button" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Send"><i class="fa fa-reply"></i> Send</button>
                        <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Discard</a>
                        <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to draft folder"><i class="fa fa-pencil"></i> Draft</a>
                    </div>
                    
                </div>
                <div class="clearfix"></div>
                 <?php echo $this->AppForm->end(); ?>
            </div>
        </div>
    </div>
</div>
