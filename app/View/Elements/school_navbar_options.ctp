<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
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
<li>
    <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label"><?php echo __("Branches");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li><a href="<?php echo $this->Html->Url(array("controller"=>"branches","action"=>"setup"));?>"><?php echo __("Add Branch");?></a></li>
        <li><a href="<?php echo $this->Html->Url(array("controller"=>"branches","action"=>"index"));?>"><?php echo __("Manage Branches");?></a></li>
        <li><a href="<?php echo $this->Html->Url(array("controller"=>"branches","action"=>"uploadHistories"));?>"><?php echo __("Upload History");?></a></li>
    </ul>
</li>
<li class="<?php echo (trim($this->params['controller']) == 'employees')?'active':""; ?>">
    <a href="#"><i class="fa fa-user-md"></i> <span class="nav-label"><?php echo __("Employees");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="<?php echo (trim($this->params['controller']) == 'employees' && (trim($this->action) == 'setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"employees","action"=>"setup"));?>"><?php echo __("Add Employee");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'employees' && (trim($this->action) == 'index'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"employees","action"=>"manage"));?>"><?php echo __("Manage Employees");?></a></li>
    </ul>
</li>
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
        <li class="<?php echo (trim($this->params['controller']) == 'galleries' && (trim($this->action) == 'index'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"galleries","action"=>"index"));?>"><?php echo __("Manage Galleries");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'galleries' && (trim($this->action) == 'manage'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"employees","action"=>"manage"));?>"><?php echo __("Manage Employees");?></a></li>
    </ul>
</li>
<li class="<?php echo (trim($this->params['controller']) == 'employees')?'active':""; ?>">
    <a href="#"><i class="fa fa-user-md"></i> <span class="nav-label"><?php echo __("Events");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="<?php echo (trim($this->params['controller']) == 'events' && (trim($this->action) == 'setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"events","action"=>"setup"));?>"><?php echo __("Add Events");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'events' && (trim($this->action) == 'index'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"events","action"=>"index"));?>"><?php echo __("Manage Events");?></a></li>
    </ul>
</li>
<li class="<?php echo (trim($this->params['controller']) == 'holidays')?'active':""; ?>">
    <a href="#"><i class="fa fa-user-md"></i> <span class="nav-label"><?php echo __("Holidays");?></span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="<?php echo (trim($this->params['controller']) == 'holidays' && (trim($this->action) == 'setup'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"holidays","action"=>"setup"));?>"><?php echo __("Add Holiday");?></a></li>
        <li class="<?php echo (trim($this->params['controller']) == 'holidays' && (trim($this->action) == 'index'))?'active':""; ?>"><a href="<?php echo $this->Html->Url(array("controller"=>"holidays","action"=>"index"));?>"><?php echo __("Manage Holidays");?></a></li>
    </ul>
</li>
<li>
    <a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label"><?php echo __("Reports");?> </span></a>
</li>