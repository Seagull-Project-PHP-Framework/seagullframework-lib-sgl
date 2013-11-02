<?php

/**
 * @package Task
 */
class SGL_Task_GetPearInfo extends SGL_Task_EnvSummary
{
    var $title = 'PEAR Environment';
    var $key = 'pear_environment';
    var $mandatory = true;

    var $aRequirements = array(
        'pearFolderExists' => array(SGL_REQUIRED => 1),
        'pearLibIsLoadable' => array(SGL_REQUIRED => 1),
        'pearPath' => array(SGL_NEUTRAL => 0),
        'pearSystemLibIsLoadable' => array(SGL_REQUIRED => 1),
        'pearRegistryLibIsLoadable' => array(SGL_REQUIRED => 1),
        'pearRegistryIsObject' => array(SGL_REQUIRED => 1),
        'pearBundledPackages' => array(SGL_NEUTRAL => 0),
    );

    function run()
    {
        if (defined('SGL_PEAR_INSTALLED')) {
            $this->aData['pearFolderExists'] = true;
            $this->aData['pearLibIsLoadable'] = true;
            $includeSeparator = (substr(PHP_OS, 0, 3) == 'WIN') ? ';' : ':';
            $this->aData['pearPath'] = @ini_get('include_path');
            $this->aData['pearSystemLibIsLoadable'] = true;
            $this->aData['pearRegistryLibIsLoadable'] = true;
            require_once 'System.php';
            require_once 'PEAR/Registry.php';
            $registry = new PEAR_Registry();
            $this->aData['pearRegistryIsObject'] = bool2int(is_object($registry));
            $this->aData['pearBundledPackages'] = $registry->_listPackages();
        } else {
            $this->aData['pearFolderExists'] = bool2int(file_exists(SGL_LIB_PEAR_DIR));
            $this->aData['pearLibIsLoadable'] = bool2int(include_once SGL_LIB_PEAR_DIR . '/PEAR.php');
            $includeSeparator = (substr(PHP_OS, 0, 3) == 'WIN') ? ';' : ':';
#FIXMESGL11
//            $ok = @ini_set('include_path',      '.' . $includeSeparator . SGL_LIB_PEAR_DIR);
            $this->aData['pearPath'] = @ini_get('include_path');
            $this->aData['pearSystemLibIsLoadable'] = bool2int(require_once 'System.php');
            $this->aData['pearRegistryLibIsLoadable'] = bool2int(require_once 'PEAR/Registry.php');
            $registry = new PEAR_Registry(SGL_LIB_PEAR_DIR);
            $this->aData['pearRegistryIsObject'] = bool2int(is_object($registry));
            $aPackages = $registry->_listPackages();
            sort($aPackages);
            $this->aData['pearBundledPackages'] = $aPackages;
        }
        return $this->render($this->aData);
    }
}