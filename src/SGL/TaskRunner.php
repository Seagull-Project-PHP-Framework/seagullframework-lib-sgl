<?php

/**
 * Used for building and running a task list.
 *
 * @package SGL
 * @author  Demian Turner <demian@phpkitchen.com>
 */
class SGL_TaskRunner
{
    /**
     * collection of Task objects
     * @var array
     */
    var $aTasks = array();
    /**
     * @var null
     */
    var $data = null;

    /**
     * @param $data
     */
    function addData($data)
    {
        $this->data = $data;
    }

    /**
     * @param SGL_Task $oTask
     *
     * Method to register a new Task object in
     * the runner collection of tasks
     *
     * @return bool
     */
    function addTask(SGL_Task $oTask)
    {
        $this->aTasks[] =  $oTask;
        return true;
    }

    /**
     * @return string
     */
    function main()
    {
        $ret = array();
        foreach ($this->aTasks as $k => $oTask) {
            $return = $this->aTasks[$k]->run($this->data);
            // log to system tmp dir if we're installing
            if (!defined('SGL_INSTALLED') && !SGL::runningFromCLI()) {
                $err = is_a($return, 'PEAR_Error')
                    ? print_r($return, 1)
                    : 'ok';
                $data = get_class($oTask) .': '. $err;
                error_log($data);
            }
            if (!isset($err) || $err == 'ok') {
                $ret[] = $return;
            }
        }
        return implode('', $ret);
    }
}