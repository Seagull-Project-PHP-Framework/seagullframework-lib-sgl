<?php

class SGL_Task_MaintenanceModeIntercept extends SGL_DecorateProcess
{
    function process($input, $output)
    {
        // check for maintenance mode "on"
        if (SGL_Config::get('site.maintenanceMode')) {
            // allow admin to access and to connect if provided a key
            $rid = SGL_Session::getRoleId();
            $adminMode = SGL_Session::get('adminMode');
            if ($rid != SGL_ADMIN && !$adminMode && !SGL::runningFromCLI()) {
                $req = $input->getRequest();
                // show mtnce page for browser requests
                if ($req->getType() == SGL_REQUEST_BROWSER) {
                    SGL::displayMaintenancePage($output);
                    header('HTTP/1.1 503 Service Temporarily Unavailable');
                }
            }
        }

        $this->processRequest->process($input, $output);
    }
}