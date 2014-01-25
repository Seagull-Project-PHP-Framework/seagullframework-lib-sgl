<?php

/**
 * @package Task
 */
class SGL_Task_RegisterTrustedIPs extends SGL_Task
{
    public static function run($conf = array())
    {
        //  only IPs defined here can access debug sessions and delete config files
        $GLOBALS['_SGL']['TRUSTED_IPS'] = array(
            '127.0.0.1',
        );
    }
}