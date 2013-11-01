<?php

/**
 * @package Task
 */
class SGL_Task_EnsurePlaceholderDbPrefixIsNull extends SGL_Task
{
    function run($conf = array())
    {
        // for 0.6.x versions
        if (!empty($conf['db']['prefix'])
            && $conf['db']['prefix'] == 'not implemented yet') {
            $config = SGL_Config::singleton();
            $config->set('db', array('prefix' => ''));
            $config->save();
        }
    }
}