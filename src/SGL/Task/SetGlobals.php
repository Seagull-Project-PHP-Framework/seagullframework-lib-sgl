<?php

/**
 * @package Task
 */
class SGL_Task_SetGlobals extends SGL_Task
{
    public static function run($conf = array())
    {
        $GLOBALS['_SGL']['BANNED_IPS'] =        array();
        $GLOBALS['_SGL']['ERRORS'] =            array();
        $GLOBALS['_SGL']['QUERY_COUNT'] =       0;
        $GLOBALS['_SGL']['ERROR_OVERRIDE'] =    false;
        $GLOBALS['_SGL']['CHARSET'] =           '';
        // set $GLOBALS['_SGL']['LANGUAGE']
        require_once SGL_DAT_DIR . '/ary.languages.php';
    }
}