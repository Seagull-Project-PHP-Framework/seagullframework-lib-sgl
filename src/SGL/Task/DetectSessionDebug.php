<?php

/**
 * Detects if session debug is allowed.
 *
 * @package Task
 * @author Dmitri Lakachauskis <lakiboy83@gmail.com>
 *
 * @todo think something better than checking for action to avoid
 *       saving config to file, when value was changed
 */
class SGL_Task_DetectSessionDebug extends SGL_DecorateProcess
{
    function process($input, $output)
    {
        SGL::logMessage(null, PEAR_LOG_DEBUG);

        $adminMode = SGL_Session::get('adminMode');
        $req       = $input->getRequest();
        //  if not in admin mode, but session debug was allowed
        if (!$adminMode && SGL_Config::get('debug.sessionDebugAllowed')
            && $req->get('action') != 'rebuildSeagull'
            && $req->getManagerName() != 'config') {
            //  flag it as not allowed
            SGL_Config::set('debug.sessionDebugAllowed', false);
        }

        $this->processRequest->process($input, $output);
    }
}