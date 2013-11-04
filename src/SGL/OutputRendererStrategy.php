<?php

/**
 * Abstract renderer strategy
 *
 * @abstract
 * @package SGL
 */
abstract class SGL_OutputRendererStrategy
{
    /**
     * Prepare renderer options.
     *
     */
    function initEngine($data) {}

    /**
     * Abstract render method.
     *
     * @param SGL_View $view
     */
    function render(SGL_View $view) {}
}