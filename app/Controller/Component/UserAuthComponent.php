<?php

/**
 * UserAuth Component
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category    UserAuthComponent
 * @package     Component
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 * @dateCreated 07/17/2015  MM/DD/YYYY
 * @dateUpdated 07/17/2015  MM/DD/YYYY 
 * @functions   2
 */
app::import('Component', 'Auth');

/**
 * UserAuth Component: Based on user type we are redirecting
 *
 * @category    UserAuthComponent
 * @package     Component
 * @author      Vijay.Ch <vijay.ch@vendus.com>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT License
 * @link        http://localhost/cacsv2/index
 */
class UserAuthComponent extends AuthComponent {

    public function redirectUrl($url = null) {
        if ($url !== null) {
            $redir = $url;
        } else {
            $userRole = $this->user('user_role');
            switch ($userRole) {
                case 1001:
                    $redir = '/admin/dashboards/index';
                    break;
                case 1002:
                    $redir = '/admin/dashboards/index';
                    break;
                case 1003:
                    $redir = '/dashboards/index';
                    break;
                case 1004:
                    $redir = '/admin/dashboards/index';
                    break;
                case 1005:
                    $redir = '/admin/dashboards/index';
                    break;
                case 1006:
                    $redir = '/admin/dashboards/index';
                    break;
                case 1007:
                    $redir = '/admin/dashboards/index';
                    break;
                default:
                    $redir = '/users/login';
                    break;
            }
        }
        if (is_array($redir)) {
            return Router::url($redir + array('base' => false));
        }
        return $redir;
    }

}
