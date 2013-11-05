<?php

class SGL_Task_PostInstallSetup extends SGL_Task
{
    function run($conf = array())
    {
        file_put_contents("/tmp/FOO", "test");
    }
}