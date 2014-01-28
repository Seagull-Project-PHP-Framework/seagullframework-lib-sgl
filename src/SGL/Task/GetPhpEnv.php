<?php

/**
 * @package Task
 */
class SGL_Task_GetPhpEnv extends SGL_Task_EnvSummary
{
    public static $title = 'PHP Environment';
    public static $key = 'php_environment';
    public static $mandatory = true;
    public static $aRequirements = array(
        'phpVersion' => array(SGL_REQUIRED => '>4.2.3'),
        'operatingSystem' => array(SGL_NEUTRAL => 0),
        'webserverSapi' => array(SGL_NEUTRAL => 0),
        'webserverPort' => array(SGL_NEUTRAL => 0),
        'webserverSoftware' => array(SGL_NEUTRAL => 0),
        'seagullVersion' => array(SGL_NEUTRAL => 0),
    );
    public static $aErrors = array(
        'phpVersion' => 'As a minimum you need to be running PHP version 4.3.0 to run Seagull',
        'operatingSystem' => '',
        'webserverSapi' => '',
        'webserverPort' => '',
        'webserverSoftware' => '',
        'seagullVersion' => '',
    );

    public static function run()
    {
        self::$aData = array();
        self::$aData['phpVersion'] = phpversion();
        self::$aData['operatingSystem'] = php_uname('s') .' '. php_uname('r') .', '. php_uname('m');
        self::$aData['webserverSapi'] = php_sapi_name();
        self::$aData['webserverPort'] = $_SERVER['SERVER_PORT'];
        self::$aData['webserverSoftware'] = $_SERVER['SERVER_SOFTWARE'];
        self::$aData['seagullVersion'] = file_get_contents(SGL_PATH . '/VERSION.txt');
        return self::render(self::$aData);
    }
}