<?php

/**
 * @package Task
 */
class SGL_Task_GetLoadedModules extends SGL_Task_EnvSummary
{
    var $title = 'Available Modules';
    var $key = 'loaded_modules';
    var $aRequirements = array(
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
    var $aErrors = array(
        'session' => 'You need the session extension to run Seagull',
        'pcre' => 'You need the pcre extension to run Seagull',
        'apc' => 'Problems have been reported running apc, please disable to continue',
    );

    function run()
    {
        $this->aRequirements['dom'] = array(SGL_RECOMMENDED => 1);

        foreach ($this->aRequirements as $m => $dep) {
            $this->aData[$m] = bool2int(extension_loaded($m));
        }
        return $this->render($this->aData);
    }
}