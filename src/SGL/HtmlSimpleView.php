<?php

/**
 * Wrapper for simple HTML views.
 *
 * @package SGL
 */
class SGL_HtmlSimpleView extends SGL_View
{

    /**
     * HTML renderer decorator.
     *
     * @param $data
     * @param null $templateEngine
     */
    function __construct(&$data, $templateEngine = null)
    {
        //  prepare renderer class
        if (!$templateEngine) {
            $templateEngine = SGL_Config::get('site.templateEngine');
        }
        $templateEngine = ucfirst($templateEngine);
        $rendererClass  = 'SGL_HtmlRenderer_' . $templateEngine . 'Strategy';

        parent::SGL_View($data, new $rendererClass);
    }
}