<?php

/**
 * @package Task
 */
class SGL_Task_GetPearInfo extends SGL_Task_EnvSummary
{
    public static $title = 'PEAR Environment';
    public static $key = 'pear_environment';
    public static $mandatory = true;

    public static $aRequirements = array(
        'pearFolderExists' => array(SGL_REQUIRED => 1),
        'pearLibIsLoadable' => array(SGL_REQUIRED => 1),
        'pearPath' => array(SGL_NEUTRAL => 0),
        'pearSystemLibIsLoadable' => array(SGL_REQUIRED => 1),
        'pearRegistryLibIsLoadable' => array(SGL_REQUIRED => 1),
        'pearRegistryIsObject' => array(SGL_REQUIRED => 1),
        'pearBundledPackages' => array(SGL_NEUTRAL => 0),
    );

    public static function run()
    {
//        $this->aData['pearFolderExists'] = bool2int(file_exists(SGL_LIB_PEAR_DIR));
//        $this->aData['pearLibIsLoadable'] = bool2int(include_once SGL_LIB_PEAR_DIR . '/PEAR.php');
        $includeSeparator = (substr(PHP_OS, 0, 3) == 'WIN') ? ';' : ':';
    #FIXMESGL11
    //            $ok = @ini_set('include_path',      '.' . $includeSeparator . SGL_LIB_PEAR_DIR);
        self::$aData['pearPath'] = @ini_get('include_path');
        self::$aData['pearSystemLibIsLoadable'] = bool2int(require_once 'System.php');
        self::$aData['pearRegistryLibIsLoadable'] = bool2int(require_once 'PEAR/Registry.php');
        $registry = new PEAR_Registry(SGL_LIB_PEAR_DIR);
        self::$aData['pearRegistryIsObject'] = bool2int(is_object($registry));
        $aPackages = $registry->_listPackages();
        sort($aPackages);
        self::$aData['pearBundledPackages'] = $aPackages;
        return self::render(self::$aData);
    }
}