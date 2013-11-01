<?php

/**
 * @package Task
 */
class SGL_Task_EnsureFC extends SGL_Task
{
    function run($conf = array())
    {
        //  load BC functions depending on PHP version detected
        if (version_compare(phpversion(), "5.3.0", '>=')) {
            date_default_timezone_set('UTC');
            error_reporting(E_COMPILE_ERROR|E_RECOVERABLE_ERROR|E_ERROR|E_CORE_ERROR);
        }
    }
}