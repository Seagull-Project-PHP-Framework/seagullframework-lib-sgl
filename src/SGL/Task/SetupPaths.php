<?php

// if SGL_FrontController::init() called without index.php
if (!isset($GLOBALS['varDir'])) {
    $GLOBALS['varDir']  = realpath(dirname(__FILE__) . '/../../../var');
    $GLOBALS['rootDir'] = realpath(dirname(__FILE__) . '/../../../');
}

/**
 * @package Task
 */
class SGL_Task_SetupPaths extends SGL_Task
{
    /**
     * Sets up the minimum paths required for framework execution.
     *
     * - SGL_SERVER_NAME must always be known in order to rewrite config file
     * - SGL_PATH is the filesystem root path
     * - pear include path is setup
     * - PEAR.php included for errors, etc
     *
     * @param array $conf
     * @internal param array $data
     * @return array|void
     */
    public function run($conf = array())
    {
        define('SGL_SERVER_NAME', $this->hostnameToFilename());

        $path = $GLOBALS['varDir']  . '/INSTALL_COMPLETE.php';
        if (is_file($path)) {
            $configFile = $GLOBALS['varDir']  . '/'
                . SGL_Task_SetupPaths::hostnameToFilename() . '.conf.php';
            require_once $configFile;
            if (!empty($conf['path']['installRoot'])) {
                define('SGL_PATH', $conf['path']['installRoot']);
            }
        } else {
            define('SGL_PATH', $GLOBALS['rootDir']);
        }
#FIXMESGL11
        define('SGL_LIB_PEAR_DIR', SGL_PATH . '/lib/pear');
        //  put sgl lib dir in include path
        $sglLibDir =  SGL_PATH . '/lib';


        $sglPath = '.' . PATH_SEPARATOR . SGL_LIB_PEAR_DIR . PATH_SEPARATOR . $sglLibDir .
            PATH_SEPARATOR . get_include_path();
#FIXMESGL11
//        $allowed = @ini_set('include_path', $sglPath);
//        if (!$allowed) {
//            //  depends on PHP version being >= 4.3.0
//            if (function_exists('set_include_path')) {
////                set_include_path($sglPath);
//            } else {
//                die('You need at least PHP 4.3.0 if you want to run Seagull
//                with safe mode enabled.');
//            }
//        }
//    }

    /**
     * Determines the name of the INI file, based on the host name.
     *
     * If PHP is being run interactively (CLI) where no $_SERVER vars
     * are available, a default 'localhost' is supplied.
     *
     * @return  string  the name of the host
     */
    public static  function hostnameToFilename()
    {
        //  start with a default
        $hostName = 'localhost';
        if (!SGL::runningFromCLI()) {

            // Determine the host name
            if (!empty($_SERVER['SERVER_NAME'])) {
                $hostName = $_SERVER['SERVER_NAME'];

            } elseif (!empty($_SERVER['HTTP_HOST'])) {
                //  do some spoof checking here, like
                //  if (gethostbyname($_SERVER['HTTP_HOST']) != $_SERVER['SERVER_ADDR'])
                $hostName = $_SERVER['HTTP_HOST'];
            } else {
                //  if neither of these variables are set
                //  we're going to have a hard time setting up
                die('Could not determine your server name');
            }
            // Determine if the port number needs to be added onto the end
            if (!empty($_SERVER['SERVER_PORT'])
                && $_SERVER['SERVER_PORT'] != 80
                && $_SERVER['SERVER_PORT'] != 443) {
                $hostName .= '_' . $_SERVER['SERVER_PORT'];
            }
        }
        return $hostName;
    }
}