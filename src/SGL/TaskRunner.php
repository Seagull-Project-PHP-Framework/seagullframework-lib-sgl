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
     * Method to register a new Task object in
     * the runner collection of tasks
     *
     * @param object $oTask of type Task
     * @return boolean true on add success false on failure
     * @access public
     */
    function addTask($oTask)
    {
        if (is_a($oTask, 'SGL_Task')) {
            $this->aTasks[] =  $oTask;
            return true;
        }
        return PEAR::raiseError('an SGL_Task object was expected');
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