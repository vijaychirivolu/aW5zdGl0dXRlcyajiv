<?php

/**
 * Default Layout
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
 * @link        http://localhost/Ourwebsites/Admin
 * @dateCreated 07/10/2015  MM/DD/YYYY
 * @dateUpdated 07/10/2015  MM/DD/YYYY  
 */
?>
<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>INSPINIA | Data Tables</title>
        <?php
            $cssArray = array(
                'bootstrap.min',
                //'/font-awesome/css/font-awesome',
               'plugins/dataTables/dataTables.bootstrap',
                'plugins/dataTables/dataTables.responsive',
                'plugins/dataTables/dataTables.tableTools.min',
                'plugins/steps/jquery.steps',
                'animate',
                'plugins/dropzone/basic',
                'plugins/dropzone/dropzone',
                'plugins/sweetalert/sweetalert',
                'plugins/summernote/summernote',
                'plugins/summernote/summernote-bs3',
                'style',
                'plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox',
                'plugins/datapicker/datepicker3',
                'plugins/tree-multiselect/jquery.tree-multiselect',
                'plugins/iCheck/custom',
                'jquery-checktree',
                'jquery-ui.min.css',
                'developer'
            );
            if (ENVIRONMENT == "development") {
                echo $this->Html->css('bootstrap.min');
                echo $this->Html->css('/font-awesome/css/font-awesome');

                echo $this->Html->css('plugins/dataTables/dataTables.bootstrap');
                echo $this->Html->css('plugins/dataTables/dataTables.responsive');
                echo $this->Html->css('plugins/dataTables/dataTables.tableTools.min');

                echo $this->Html->css('plugins/steps/jquery.steps');

                echo $this->Html->css('animate');

                echo $this->Html->css('plugins/dropzone/basic');
                echo $this->Html->css('plugins/dropzone/dropzone');
                echo $this->Html->css('plugins/sweetalert/sweetalert');

                echo $this->Html->css('plugins/summernote/summernote');
                echo $this->Html->css('plugins/summernote/summernote-bs3');

                echo $this->Html->css('style');

                echo $this->Html->css('plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox');
                echo $this->Html->css('plugins/datapicker/datepicker3');

                echo $this->Html->css('plugins/tree-multiselect/jquery.tree-multiselect');
                echo $this->Html->css('plugins/iCheck/custom');
                echo $this->Html->css('jquery-checktree');
                echo $this->Html->css('jquery-ui.min');
                
                echo $this->Html->css('token-input');
                echo $this->Html->css('token-input-facebook');
                echo $this->Html->css('developer');
                
            } else {
               echo $this->Minify->css($cssArray);
               echo $this->Html->css('/font-awesome/css/font-awesome');
            }
            
        ?>
        <script>
            var SITEURL = '<?php echo Router::url('/', true); ?>';
        </script>
    </head>

    <body>

        <div id="wrapper">

            <?php echo $this->element("leftbar");?>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <?php echo $this->element("topbar");?>
                </div>

                <?php echo $this->fetch('content'); ?>
                <?php echo $this->element('footer'); ?>

            </div>
        </div>
        <?php
            $jsArray = array(
              'jquery-2.1.1',
                'bootstrap.min',
                'plugins/metisMenu/jquery.metisMenu',
                'plugins/slimscroll/jquery.slimscroll.min',
                'plugins/datapicker/bootstrap-datepicker',
                'plugins/jeditable/jquery.jeditable',
                'plugins/dataTables/jquery.dataTables',
                'plugins/dataTables/dataTables.bootstrap',
                'plugins/dataTables/dataTables.responsive',
                'plugins/dataTables/dataTables.tableTools.min',
                'inspinia',
                'plugins/pace/pace.min',
                'plugins/staps/jquery.steps.min',
                'plugins/validate/jquery.validate.min',
                'bootstrap-filestyle.min',
                'plugins/dropzone/dropzone',
                'plugins/sweetalert/sweetalert.min',
                'plugins/summernote/summernote.min',
                'plugins/iCheck/icheck.min',
                'plugins/tree-multiselect/jquery.tree-multiselect',
                'jquery-checktree',
                'plugins/jquery-ui/jquery-ui.min',
                'Admin'
            );
            if (ENVIRONMENT == "development") {
                echo $this->Html->script('jquery.min');
                echo $this->Html->script('jquery-2.1.1');
                echo $this->Html->script('bootstrap.min');
                
                echo $this->Html->script('plugins/metisMenu/jquery.metisMenu');
                echo $this->Html->script('plugins/slimscroll/jquery.slimscroll.min');

                echo $this->Html->script('plugins/datapicker/bootstrap-datepicker');

                echo $this->Html->script('plugins/jeditable/jquery.jeditable');

                echo $this->Html->script('plugins/dataTables/jquery.dataTables');
                echo $this->Html->script('plugins/dataTables/dataTables.bootstrap');
                echo $this->Html->script('plugins/dataTables/dataTables.responsive');
                echo $this->Html->script('plugins/dataTables/dataTables.tableTools.min');

                echo $this->Html->script('inspinia');
                echo $this->Html->script('plugins/pace/pace.min');

                echo $this->Html->script('plugins/staps/jquery.steps.min');
                echo $this->Html->script('plugins/validate/jquery.validate.min');

                echo $this->Html->script('bootstrap-filestyle.min');

                echo $this->Html->script('plugins/dropzone/dropzone');
                echo $this->Html->script('plugins/sweetalert/sweetalert.min');

                echo $this->Html->script('plugins/summernote/summernote.min');
                //echo $this->Html->script('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places');
                echo $this->Html->script('plugins/iCheck/icheck.min');
                echo $this->Html->script('plugins/tree-multiselect/jquery.tree-multiselect');
                echo $this->Html->script('jquery-checktree');
                echo $this->Html->script('plugins/jquery-ui/jquery-ui.min');
                echo $this->Html->script('jquery.tokeninput');
                echo $this->Html->script('Admin');
            } else {
                echo $this->Minify->script($jsArray);
            }
            
        ?>
    </body>

</html>
