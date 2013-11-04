<?php

/**
 * @package Task
 */
class SGL_Task_SetupORM extends SGL_DecorateProcess
{
    function process($input, $output)
    {
        $oTask = new SGL_Task_InitialiseDbDataObject();
        $ok = $oTask->run();

        $this->processRequest->process($input, $output);
    }
}
