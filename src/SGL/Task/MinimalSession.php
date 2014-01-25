<?php
/**
 * Created by PhpStorm.
 * User: demian
 * Date: 23/01/2014
 * Time: 18:33
 */

class SGL_Task_MinimalSession extends SGL_DecorateProcess
{
    function process(SGL_Registry $input, SGL_Output $output)
    {
        session_start();
        $_SESSION['uid'] = 1;
        $_SESSION['rid'] = 1;
        $_SESSION['aPrefs'] = array();

        $this->processRequest->process($input, $output);
    }
}