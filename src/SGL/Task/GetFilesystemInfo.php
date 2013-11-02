<?php

/**
 * @package Task
 */
class SGL_Task_GetFilesystemInfo extends SGL_Task_EnvSummary
{
    var $title = 'Filesystem info';
    var $key = 'filesystem_info';
    var $mandatory = true;

    var $aRequirements = array(
        'installRoot' => array(SGL_NEUTRAL => 0),
        'varDirExists' => array(SGL_REQUIRED => 1),
        'varDirIsWritable' => array(SGL_REQUIRED => 1),
        'wwwDirIsWritable' => array(SGL_REQUIRED => 1),
    );
    var $aErrors = array(
        'installRoot' => '',
        'varDirExists' => 'It appears you do not have a "var" folder, please create a folder with this name in the root of your Seagull install',
        'varDirIsWritable' => "Your \"var\" dir is not writable by the webserver, to make it writable type the following at the command line: chmod 777 %e",
        'wwwDirIsWritable' => "Your \"www\" dir is not writable by the webserver, to make it writable type the following at the command line: chmod 777 %e",
    );

    function run()
    {
        $this->aData['installRoot'] = SGL_PATH;
        $this->aData['varDirExists'] = bool2int(file_exists(SGL_VAR_DIR));
        $this->aData['varDirIsWritable'] = bool2int(is_writable(SGL_VAR_DIR));
        $this->aData['wwwDirIsWritable'] = bool2int(is_writable(SGL_WEB_ROOT));
        return $this->render($this->aData);
    }
}