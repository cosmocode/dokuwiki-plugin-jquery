<?php
/**
 * jQuery Plugin
 *
 * @license    GPLv3 (http://www.gnu.org/licenses/gpl.html)
 * @link       http://www.dokuwiki.org/plugin:jquery
 * @author     Markus Birth <markus@birth-online.de>
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_jquery extends DokuWiki_Action_Plugin {

    /*
     * plugin should use this method to register its handlers with the dokuwiki's event controller
     */
    function register(&$controller) {
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, '_addjquery');
    }

    // output jQuery.noConflict(); so that it doesn't break current $() functionality
    function _addjquery(&$event, $param) {
        $event->data['script'][] = array(
            'type' => 'text/javascript',
            'charset' => 'utf-8',
            '_data' => 'jQuery.noConflict();' . PHP_EOL,
        );
    }
}
