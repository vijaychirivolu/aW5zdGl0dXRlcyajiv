<?php if ((isset($ajaxFlag)) && !$ajaxFlag) { ?>
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>-->
            <h4 class="modal-title text-center m-t float-e-margins">Update Password</h4>

            <h5 class="text-center m-t">You must update your password</h5>
        </div>
        <div class="ibox-content">
<?php }
            echo $this->AppForm->create('User', array(
                'class' => 'validation-form ajax-form',
                'method' => 'post',
                'enctype' => 'multipart/form-data',
                'novalidate',
                'url' => array('controller' => 'users', 'action' => 'admin_updatepassword')
            ));
            echo $this->AppForm->hidden("id", array('value' => $userId));
            echo $this->AppForm->hidden('pwd_flag', array('value' => 0))
            ?>
            <div class="form-group">
                <?php
                echo $this->AppForm->input('password', array(
                    'class' => 'form-control required',
                    'type' => 'password',
                    'label' => 'New Password',
                    'placeholder' => 'New Password Goes Here'
                ));
                ?>
            </div>
            <div class="form-group m-t float-e-margins">
                <?php
                echo $this->AppForm->input('confirm_password', array(
                    'class' => 'form-control required',
                    'type' => 'password',
                    'label' => 'Confirm Password',
                    'placeholder' => 'Confirm Password Goes Here',
                    'equalTo' => '#UserPassword'
                ));
                ?>
            </div>
            <div class="form-group m-t text-center">
                <?php
                echo $this->AppForm->button('Update Password', array(
                    'class' => 'btn btn-primary add_user_button',
                    'type' => 'submit',
                ));
                ?>
                <?php echo $this->AppForm->end(); ?>
<?php if ((isset($ajaxFlag)) && !$ajaxFlag) { ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>