<?php

Router::connect('/timthumb/*', array('controller' => 'timthumb', 'action' => 'image', 'plugin' => 'Timthumb'));
Router::connect('/admin/timthumb/*', array('controller' => 'timthumb', 'action' => 'image', 'plugin' => 'Timthumb'));