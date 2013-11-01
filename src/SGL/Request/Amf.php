<?php

require_once SGL_CORE_DIR . '/Request/Ajax.php';

/**
 * Class SGL_Request_Amf
 */
class SGL_Request_Amf extends SGL_Request_Ajax
{
    /**
     * @param null $type
     * @return array|bool|object|true
     */
    function init($type = null)
    {
        parent::init();
        $this->type = SGL_REQUEST_AMF;
        return true;
    }

    /**
     * @return string
     */
    function getActionName()
    {
        $container = ucfirst($this->getModuleName()) . 'AmfProvider';
        $ok = preg_match(
            "/$container\.([a-zA-Z_0-9]+)/",
            $GLOBALS['HTTP_RAW_POST_DATA'],
            $aMatches
        );
        return $ok ? $aMatches[1] : 'default';
    }
}
?>
