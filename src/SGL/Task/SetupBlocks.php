<?php

/**
 * Initialises block loading.
 *
 * @package Task
 * @author  Demian Turner <demian@phpkitchen.com>
 */
class SGL_Task_SetupBlocks extends SGL_DecorateProcess
{
    function process($input, $output)
    {
        $this->processRequest->process($input, $output);

        SGL::logMessage(null, PEAR_LOG_DEBUG);

        //  load blocks
        if (SGL_Config::get('site.blocksEnabled')
            && !SGL::runningFromCli()) {
            $output->sectionId = empty($output->sectionId)
                ? 0
                : $output->sectionId;
            $blockLoader = new SGL_BlockLoader($output->sectionId);
            $aBlocks = $blockLoader->render($output);
            foreach ($aBlocks as $key => $value) {
                $blocksName = 'blocks'.$key;
                $output->$blocksName = $value;
            }
        }
    }
}