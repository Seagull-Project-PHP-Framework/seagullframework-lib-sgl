<?php

/**
 * A void object.
 *
 * @package Task
 * @author  Demian Turner <demian@phpkitchen.com>
 */
class SGL_Void extends SGL_ProcessRequest
{
    function process($input)
    {
        SGL::logMessage(null, PEAR_LOG_DEBUG);
    }
}