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
        // $controller->register_hook('JQUERY_READY', 'BEFORE', $this, '_test');
    }

    function _test(&$event, $param) {
        $event->data[] = 'alert(\'Test successful!\');';
    }

    // output jQuery.noConflict(); so that it doesn't break current $() functionality
    function _addjquery(&$event, $param) {
        // script.js is automagically used by js.php
        $morecode = array();
        $addjs = '';
        trigger_event('JQUERY_READY', $morecode, NULL, false);
        foreach ($morecode as $id=>$mc) {
            $addjs .= '// BEGIN --- ' . $id . PHP_EOL;
            $addjs .= $mc . PHP_EOL;
            $addjs .= '// END --- ' . $id . PHP_EOL;
        }

        $fulljs = 'jQuery.noConflict();' . PHP_EOL;
        if (!empty($addjs)) {
            $fulljs .= 'jQuery(document).ready(function() {' . PHP_EOL;
            $fulljs .= $addjs . PHP_EOL;
            $fulljs .= '});' . PHP_EOL;
        }
        $event->data['script'][] = array(
            'type' => 'text/javascript',
            'charset' => 'utf-8',
            '_data' => $fulljs,
        );
    }

}
