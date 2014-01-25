<?php

/**
 * @package Task
 */
class SGL_Task_LoadCustomConfig extends SGL_Task
{
    public static function run($conf = array())
    {
        if (!empty($conf['path']['pathToCustomConfigFile'])) {
            if (is_file($conf['path']['pathToCustomConfigFile'])) {
                require_once realpath($conf['path']['pathToCustomConfigFile']);
            }
        }
    }
}