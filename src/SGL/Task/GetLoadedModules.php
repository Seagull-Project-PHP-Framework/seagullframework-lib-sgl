<?php

/**
 * @package Task
 */
class SGL_Task_GetLoadedModules extends SGL_Task_EnvSummary
{
    public static $title = 'Available Modules';
    public static $key = 'loaded_modules';
    public static $aRequirements = array(
        'curl' => array(SGL_RECOMMENDED => 1),
        'gd' => array(SGL_RECOMMENDED => 1),
        'iconv' => array(SGL_RECOMMENDED => 1),
        'mysql' => array(SGL_NEUTRAL => 0),
        'mysqli' => array(SGL_NEUTRAL => 0),
        'oci8' => array(SGL_NEUTRAL => 0),
        'odbc' => array(SGL_NEUTRAL => 0),
        'openssl' => array(SGL_RECOMMENDED => 1),
        'pcre' => array(SGL_REQUIRED => 1),
        'pgsql' => array(SGL_NEUTRAL => 0),
        'posix' => array(SGL_RECOMMENDED => 1),
        'session' => array(SGL_REQUIRED => 1),
        'tidy' => array(SGL_RECOMMENDED => 1),
        'zlib' => array(SGL_RECOMMENDED => 1),
    );
    public static $aErrors = array(
        'session' => 'You need the session extension to run Seagull',
        'pcre' => 'You need the pcre extension to run Seagull',
        'apc' => 'Problems have been reported running apc, please disable to continue',
    );

    public static function run()
    {
        self::$aData = array();
        self::$aRequirements['dom'] = array(SGL_RECOMMENDED => 1);

        foreach (self::$aRequirements as $m => $dep) {
            self::$aData[$m] = bool2int(extension_loaded($m));
        }
        return self::render(self::$aData);
    }
}