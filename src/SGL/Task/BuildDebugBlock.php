<?php

/**
 * Builds data for debug block.
 *
 * @package Task
 * @author  Demian Turner <demian@phpkitchen.com>
 */
class SGL_Task_BuildDebugBlock extends SGL_DecorateProcess
{
    function process($input, $output)
    {
        $this->processRequest->process($input, $output);

        SGL::logMessage(null, PEAR_LOG_DEBUG);

        if (SGL_Config::get('debug.infoBlock')) {
            $output->debug_request = $output->request;
            $output->debug_session = $_SESSION;
            $output->debug_module = $output->moduleName;
            $output->debug_manager = isset($output->managerName)
                ? $output->managerName
                : '';
            $output->debug_action = $output->action;
            $output->debug_section = $output->sectionId;
            $output->debug_master_template = isset($output->masterTemplate)
                ? $output->masterTemplate
                : '';
            $output->debug_template = $output->template;
            $output->debug_theme = $output->theme;

        }
    }
}