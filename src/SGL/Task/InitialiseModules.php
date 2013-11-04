<?php

/**
 * @package Task
 */
class SGL_Task_InitialiseModules extends SGL_Task
{
    function run($conf = array())
    {
        $c = SGL_Config::singleton();
        $conf = $c->getAll();

        //  skip if we're in installer
        if (defined('SGL_INSTALLED')) {
            $locator = SGL_ServiceLocator::singleton();
            $dbh = $locator->get('DB');
            if (!$dbh) {
                $dbh =  SGL_DB::singleton();
                $locator->register('DB', $dbh);
            }
            //  this task can be called when installing a new module
            if (!empty($conf['aModuleList'])) {
                $oMod = new stdClass();
                $oMod->name = $conf['aModuleList'][0];
                $aRet[] = $oMod;
            } else {
                $query = "
                    SELECT  name
                    FROM    {$conf['table']['module']}
                    ";
                $aRet = $dbh->getAll($query);
            }
            if (is_array($aRet) && count($aRet)) {
                foreach ($aRet as $oModule) {
                    $moduleInitFile = SGL_MOD_DIR . '/' . $oModule->name . '/init.php';
                    if (is_file($moduleInitFile)) {
                        require_once $moduleInitFile;
                    }
                }
            }
        }
    }
}