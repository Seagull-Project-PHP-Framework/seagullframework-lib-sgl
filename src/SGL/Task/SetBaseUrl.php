<?php

/**
 * Routine to discover the base url of the installation.
 *
 * Only gets invoked if user deletes URL in config, or if we're setting up.
 *
 * @package Task
 */
class SGL_Task_SetBaseUrl extends SGL_Task
{
    function run($conf = array())
    {
        if (!(isset($conf['site']['baseUrl']))) {

            //  defines SGL_BASE_URL constant
            require_once dirname(__FILE__)  . '/Install.php';
            SGL_Task_SetBaseUrlMinimal::run();
        }
    }
}