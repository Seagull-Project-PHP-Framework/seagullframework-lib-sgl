<?php

/**
 * @package Task
 */
class SGL_Task_GetFilesystemInfo extends SGL_Task_EnvSummary
{
    public static $title = 'Filesystem info';
    public static $key = 'filesystem_info';
    public static $mandatory = true;

    public static $aRequirements = array(
        'installRoot' => array(SGL_NEUTRAL => 0),
        'varDirExists' => array(SGL_REQUIRED => 1),
        'varDirIsWritable' => array(SGL_REQUIRED => 1),
        'wwwDirIsWritable' => array(SGL_REQUIRED => 1),
    );
    public static $aErrors = array(
        'installRoot' => '',
        'varDirExists' => 'It appears you do not have a "var" folder, please create a folder with this name in the root of your Seagull install',
        'varDirIsWritable' => "Your \"var\" dir is not writable by the webserver, to make it writable type the following at the command line: chmod 777 %e",
        'wwwDirIsWritable' => "Your \"www\" dir is not writable by the webserver, to make it writable type the following at the command line: chmod 777 %e",
    );

    public static function run()
    {
        self::$aData = array();

        self::$aData['installRoot'] = SGL_PATH;
        self::$aData['varDirExists'] = bool2int(file_exists(SGL_VAR_DIR));
        self::$aData['varDirIsWritable'] = bool2int(is_writable(SGL_VAR_DIR));
        self::$aData['wwwDirIsWritable'] = bool2int(is_writable(SGL_WEB_ROOT));
        return self::render(self::$aData);
    }
}