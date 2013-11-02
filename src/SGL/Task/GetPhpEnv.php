<?php

/**
 * @package Task
 */
class SGL_Task_GetPhpEnv extends SGL_Task_EnvSummary
{
    var $title = 'PHP Environment';
    var $key = 'php_environment';
    var $mandatory = true;
    var $aRequirements = array(
        'phpVersion' => array(SGL_REQUIRED => '>4.2.3'),
        'operatingSystem' => array(SGL_NEUTRAL => 0),
        'webserverSapi' => array(SGL_NEUTRAL => 0),
        'webserverPort' => array(SGL_NEUTRAL => 0),
        'webserverSoftware' => array(SGL_NEUTRAL => 0),
        'seagullVersion' => array(SGL_NEUTRAL => 0),
    );
    var $aErrors = array(
        'phpVersion' => 'As a minimum you need to be running PHP version 4.3.0 to run Seagull',
        'operatingSystem' => '',
        'webserverSapi' => '',
        'webserverPort' => '',
        'webserverSoftware' => '',
        'seagullVersion' => '',
    );

    function run()
    {
        $this->aData['phpVersion'] = phpversion();
        $this->aData['operatingSystem'] = php_uname('s') .' '. php_uname('r') .', '. php_uname('m');
        $this->aData['webserverSapi'] = php_sapi_name();
        $this->aData['webserverPort'] = $_SERVER['SERVER_PORT'];
        $this->aData['webserverSoftware'] = $_SERVER['SERVER_SOFTWARE'];
        $this->aData['seagullVersion'] = file_get_contents(SGL_PATH . '/VERSION.txt');
        return $this->render($this->aData);
    }
}