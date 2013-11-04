<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Copyright (c) 2013, Demian Turner                                         |
// | All rights reserved.                                                      |
// |                                                                           |
// | Redistribution and use in source and binary forms, with or without        |
// | modification, are permitted provided that the following conditions        |
// | are met:                                                                  |
// |                                                                           |
// | o Redistributions of source code must retain the above copyright          |
// |   notice, this list of conditions and the following disclaimer.           |
// | o Redistributions in binary form must reproduce the above copyright       |
// |   notice, this list of conditions and the following disclaimer in the     |
// |   documentation and/or other materials provided with the distribution.    |
// | o The names of the authors may not be used to endorse or promote          |
// |   products derived from this software without specific prior written      |
// |   permission.                                                             |
// |                                                                           |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS       |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT         |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR     |
// | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT      |
// | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,     |
// | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT          |
// | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,     |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY     |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT       |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE     |
// | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.      |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Seagull 1.0                                                               |
// +---------------------------------------------------------------------------+
// | Init.php                                                                  |
// +---------------------------------------------------------------------------+
// | Author:   Demian Turner <demian@phpkitchen.com>                           |
// +---------------------------------------------------------------------------+
// $Id: Init.php,v 1.85 2005/06/22 00:40:44 demian Exp $

/**
 * Basic init tasks: sets up paths, constants, include_path, etc.
 *
 * @author  Demian Turner <demian@phpkitchen.com>
 */

// if SGL_FrontController::init() called without index.php
if (!isset($GLOBALS['varDir'])) {
    $GLOBALS['varDir']  = realpath(dirname(__FILE__) . '/../../../var');
    $GLOBALS['rootDir'] = realpath(dirname(__FILE__) . '/../../../');
}

//          $userInfo = posix_getpwuid(fileowner($configFile));
//          $fileOwnerName = $userInfo['name'];
//          $allowedFileOwners = array('nobody', 'apache');
//
//          if (!in_array($fileOwnerName, $allowedFileOwners)) {
//                die("<br />Your config file in the seagull/var directory has the wrong " .
//                  "owner (currently set as: $fileOwnerName). " .
//                    "Please set the correct file owner to this directory and it's contents, eg:<br/>" .
//                    "<code>'chmod -R 777 seagull/var'</code>");
//          }


/**
 * Basic app process tasks: enables profiling and output buffering.
 *
 * @package Task
 * @author  Demian Turner <demian@phpkitchen.com>
 */
class SGL_Task_Init extends SGL_DecorateProcess
{
    function process($input, $output)
    {
        if (SGL_PROFILING_ENABLED && function_exists('apd_set_pprof_trace')) {
            apd_set_pprof_trace();
        }
        //  start output buffering
        if (SGL_Config::get('site.outputBuffering')) {
            ob_start();
        }

        $this->processRequest->process($input, $output);
    }
}

    // +---------------------------------------+
    // | Abstract classes                      |
    // +---------------------------------------+

/**
 * Abstract renderer strategy
 *
 * @abstract
 * @package SGL
 */
class SGL_OutputRendererStrategy
{
    /**
     * Prepare renderer options.
     *
     */
    function initEngine($data) {}

    /**
     * Abstract render method.
     *
     * @param SGL_View $view
     */
    function render(SGL_View $view) {}
}

?>
