<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<li>
    <a href="<?php echo $this->Html->Url(array("controller"=>"dashboards","action"=>"admin_index"));?>"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo __("Dashboards");?></span></a>
</li>
<li>
    <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label"><?php echo __("Schools");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo $this->Html->Url(array("controller"=>"schools","action"=>"admin_setup"));?>"><?php echo __("Add School");?></a></li>
        <li><a href="<?php echo $this->Html->Url(array("controller"=>"schools","action"=>"admin_index"));?>"><?php echo __("Manage Schools");?></a></li>
        <li><a href="<?php echo $this->Html->Url(array("controller"=>"schools","action"=>"admin_uploadHistories"));?>"><?php echo __("Upload History");?></a></li>
    </ul>
</li>
<li class="<?php echo (trim($this->params['controller']) == 'users')?'active':""; ?>">
    <a href="#"><i class="fa fa-user-md"></i> <span class="nav-label"><?php echo __("Users");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="<?php echo (trim($this->params['controller']) == 'users' && (trim($this->action) == 'admin_setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"users","action"=>"admin_setup"));?>"><?php echo __("Add User");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'users' && (trim($this->action) == 'admin_manage'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"users","action"=>"admin_manage"));?>"><?php echo __("Manage Users");?></a></li>
    </ul>
</li>
<li>
    <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label"><?php echo __("Reports");?> </span></a>
</li>
