<?php

/**
 * Abstract url parser strategy
 *
 * @abstract
 */
class SGL_UrlParser_Strategy
{
    function parseQueryString(SGL_Url $url) {}

    function makeLink($action, $mgr, $mod, $aList, $params, $idx, $output) {}
}