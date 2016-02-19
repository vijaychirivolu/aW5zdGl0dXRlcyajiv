<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<li>
    <a href="<?php echo $this->Html->Url(array("controller"=>"dashboards","action"=>"index"));?>"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo __("Dashboards");?></span></a>
</li>
<li>
    <a href="<?php echo $this->Html->Url(array("controller"=>"attendence","action"=>"index"));?>"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo __("Attendences");?></span></a>
</li>
<?php if ($userRole == 1001 || $userRole == 1002 || $userRole == 1003) { ?>
<li>
    <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label"><?php echo __("Branches");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo $this->Html->Url(array("controller"=>"branches","action"=>"setup"));?>"><?php echo __("Add Branch");?></a></li>
        <li><a href="<?php echo $this->Html->Url(array("controller"=>"branches","action"=>"index"));?>"><?php echo __("Manage Branches");?></a></li>
        <li><a href="<?php echo $this->Html->Url(array("controller"=>"branches","action"=>"uploadHistories"));?>"><?php echo __("Upload History");?></a></li>
    </ul>
</li>
<?php } ?>
<?php if ($userRole == 1001 || $userRole == 1002 || $userRole == 1003 || $userRole == 1004) { ?>
<li class="<?php echo (trim($this->params['controller']) == 'employees')?'active':""; ?>">
    <a href="#"><i class="fa fa-user-md"></i> <span class="nav-label"><?php echo __("Employees");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="<?php echo (trim($this->params['controller']) == 'employees' && (trim($this->action) == 'setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"employees","action"=>"setup"));?>"><?php echo __("Add Employee");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'employees' && (trim($this->action) == 'index'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"employees","action"=>"index"));?>"><?php echo __("Manage Employees");?></a></li>
    </ul>
</li>
<?php } ?>
<li class="<?php echo (trim($this->params['controller']) == 'students')?'active':""; ?>">
    <a href="#"><i class="fa fa-user-md"></i> <span class="nav-label"><?php echo __("Students");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="<?php echo (trim($this->params['controller']) == 'students' && (trim($this->action) == 'setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"students","action"=>"setup"));?>"><?php echo __("Add Student");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'students' && (trim($this->action) == 'index'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"students","action"=>"index"));?>"><?php echo __("Manage Students");?></a></li>
    </ul>
</li>
<li class="<?php echo (trim($this->params['controller']) == 'galleries')?'active':""; ?>">
    <a href="#"><i class="fa fa-user-md"></i> <span class="nav-label"><?php echo __("Galleries");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="<?php echo (trim($this->params['controller']) == 'galleries' && (trim($this->action) == 'setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"galleries","action"=>"setup"));?>"><?php echo __("Create Gallery");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'galleries' && (trim($this->action) == 'index' || trim($this->action) == 'images' || trim($this->action) == 'uploads'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"galleries","action"=>"index"));?>"><?php echo __("Manage Galleries");?></a></li>
    </ul>
</li>
<li class="<?php echo (trim($this->params['controller']) == 'employees')?'active':""; ?>">
    <a href="#"><i class="fa fa-user-md"></i> <span class="nav-label"><?php echo __("Events");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="<?php echo (trim($this->params['controller']) == 'events' && (trim($this->action) == 'setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"events","action"=>"setup"));?>"><?php echo __("Add Events");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'events' && (trim($this->action) == 'index'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"events","action"=>"index"));?>"><?php echo __("Manage Events");?></a></li>
    </ul>
</li>
<?php if ($userRole == 1001 || $userRole == 1002 || $userRole == 1003 || $userRole == 1004) { ?>
<li class="<?php echo (trim($this->params['controller']) == 'classes' || trim($this->params['controller']) == 'sections' || trim($this->params['controller']) == 'holidays' || trim($this->params['controller']) == 'skills' || (trim($this->params['controller']) == 'institutes' && (trim($this->params['action']) == 'timings' || trim($this->params['action']) == 'settings')))?'active':""; ?>">
    <a href="#"><i class="fa fa-user-md"></i> <span class="nav-label"><?php echo __("Settings");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="<?php echo (trim($this->params['controller']) == 'institutes' && trim($this->action) == 'timings')?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"institutes","action"=>"timings"));?>"><?php echo __("Timings");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'institutes' && trim($this->action) == 'settings')?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"institutes","action"=>"settings"));?>"><?php echo __("Settings");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'holidays' && (trim($this->action) == 'index' || trim($this->action) == 'setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"holidays","action"=>"index"));?>"><?php echo __("Holidays");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'skills' && (trim($this->action) == 'index' || trim($this->action) == 'setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"skills","action"=>"index"));?>"><?php echo __("Skills");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'classes' && (trim($this->action) == 'index' || trim($this->action) == 'setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"classes","action"=>"index"));?>"><?php echo __("Classes");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'sections' && (trim($this->action) == 'index' || trim($this->action) == 'setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"sections","action"=>"index"));?>"><?php echo __("Sections");?></a></li>
    </ul>
</li>
<?php } ?>
<li>
    <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label"><?php echo __("Reports");?> </span></a>
</li>