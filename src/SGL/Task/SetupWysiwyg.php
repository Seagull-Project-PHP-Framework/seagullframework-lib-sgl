<?php

/**
 * Sets up wysiwyg params.
 *
 * @package Task
 * @author  Demian Turner <demian@phpkitchen.com>
 */
class SGL_Task_SetupWysiwyg extends SGL_DecorateProcess
{
    function process($input, $output)
    {
        $this->processRequest->process($input, $output);

        SGL::logMessage(null, PEAR_LOG_DEBUG);

        // set the default WYSIWYG editor
        if (isset($output->wysiwyg) && $output->wysiwyg == true && !SGL::runningFromCLI()) {

            // you can preset this var in your code
            if (!isset($output->wysiwygEditor)) {
                $output->wysiwygEditor = SGL_Config::get('site.wysiwygEditor')
                    ? SGL_Config::get('site.wysiwygEditor')
                    : 'fck';
            }
            switch ($output->wysiwygEditor) {

                case 'fck':
                case 'fckeditor':
                    $output->wysiwyg_fck = true;
                    $output->addOnLoadEvent('fck_init()');
                    break;
                case 'xinha':
                    $output->wysiwyg_xinha = true;
                    $output->addOnLoadEvent('xinha_init()');
                    break;
                case 'htmlarea':
                    $output->wysiwyg_htmlarea = true;
                    $output->addOnLoadEvent('HTMLArea.init()');
                    break;
                case 'tinyfck':
                    $output->wysiwyg_tinyfck = true;
                    // note: tinymce doesn't need an onLoad event to initialise
                    break;
            }
        }
    }
}