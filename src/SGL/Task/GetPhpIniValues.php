<?php

/**
 * @package Task
 */
class SGL_Task_GetPhpIniValues extends SGL_Task_EnvSummary
{
    public static $title = 'php.ini Settings';
    public static $key = 'php.ini_settings';
    public static $aRequirements = array(
        'safe_mode' => array(SGL_REQUIRED => 0),
        'register_globals' => array(SGL_RECOMMENDED => 0),
        'magic_quotes_gpc' => array(SGL_RECOMMENDED => 0),
        'magic_quotes_runtime' => array(SGL_RECOMMENDED => 0),
        'session.use_trans_sid' => array(SGL_RECOMMENDED => 0),
        'allow_url_fopen' => array(SGL_RECOMMENDED => 0),
        'file_uploads' => array(SGL_RECOMMENDED => 1),
        'post_max_size' => array(SGL_RECOMMENDED => '10M'),
        'upload_max_filesize' => array(SGL_RECOMMENDED => '10M'),
    );

    public static $aErrors = array(
        'safe_mode' => "This software will not work correctly if safe_mode is enabled",
        'memory_limit' => "Please set the option 'memory_limit' in your php.ini to a minimum of 16MB",
    );

    public static function run()
    {
        self::$aData = array();

        self::$aData['safe_mode'] = ini_get2('safe_mode');
        self::$aData['register_globals'] = ini_get2('register_globals');
        self::$aData['magic_quotes_gpc'] = ini_get2('magic_quotes_gpc');
        self::$aData['magic_quotes_runtime'] = ini_get2('magic_quotes_runtime');
        self::$aData['session.use_trans_sid'] = ini_get2('session.use_trans_sid');
        self::$aData['allow_url_fopen'] = ini_get2('allow_url_fopen');
        self::$aData['file_uploads'] = ini_get2('file_uploads');
        self::$aData['post_max_size'] = ini_get('post_max_size');
        self::$aData['upload_max_filesize'] = ini_get('upload_max_filesize');
        if (ini_get('memory_limit')) {
            self::$aRequirements['memory_limit'] = array(SGL_REQUIRED => '>8M');
            self::$aData['memory_limit'] = ini_get('memory_limit');
        }
        return self::render(self::$aData);
    }
}