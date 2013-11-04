<?php

/**
 * Builds navigation menus.
 *
 * @package Task
 * @author  Demian Turner <demian@phpkitchen.com>
 */
class SGL_Task_SetupNavigation extends SGL_DecorateProcess
{
    function process($input, $output)
    {
        $this->processRequest->process($input, $output);

        SGL::logMessage(null, PEAR_LOG_DEBUG);

        if (SGL_Config::get('navigation.enabled')
            && !SGL::runningFromCli())
        {
            //  prepare navigation driver
            $navDriver = SGL_Config::get('navigation.driver');
            $navDrvFile = SGL_MOD_DIR . '/navigation/classes/' . $navDriver . '.php';
            if (is_file($navDrvFile)) {
                require_once $navDrvFile;
            } else {
                return SGL::raiseError("specified navigation driver, $navDrvFile, does not exist",
                    SGL_ERROR_NOFILE);
            }
            if (!class_exists($navDriver)) {
                return SGL::raiseError('problem with navigation driver object',
                    SGL_ERROR_NOCLASS);
            }
            $nav = new $navDriver($output);

            //  render navigation menu
            $navRenderer = SGL_Config::get('navigation.renderer');
            $aRes        = $nav->render($navRenderer);
            if (!PEAR::isError($aRes)) {
                list($sectionId, $html)  = $aRes;
                $output->sectionId  = $sectionId;
                $output->navigation = $html;
                $output->currentSectionName = $nav->getCurrentSectionName();
            }
        }
    }
}