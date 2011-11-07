<?php
/**
 * DokuWiki Plugin adexpire (Action Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Gohr <andi@splitbrain.org>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

if (!defined('DOKU_LF')) define('DOKU_LF', "\n");
if (!defined('DOKU_TAB')) define('DOKU_TAB', "\t");
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'action.php';

class action_plugin_adexpire extends DokuWiki_Action_Plugin {

    public function register(Doku_Event_Handler &$controller) {

       $controller->register_hook('AUTH_LOGIN_CHECK', 'AFTER', $this, 'handle_auth_login_check');

    }

    public function handle_auth_login_check(Doku_Event &$event, $param) {
        global $auth;
        if($event->data['user'] && !$_SERVER['REMOTE_USER']){ // log in failed?
            $info = $auth->getUserData($event->data['user']);
            if(isset($info['expiresin']) && $info['expiresin'] <=0 ){ // pass expired?
                msg($this->getLang('expired'),-1);
            }
        }
    }

}

// vim:ts=4:sw=4:et:
