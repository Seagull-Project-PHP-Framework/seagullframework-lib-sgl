<?php

/**
 * @package Task
 */
class SGL_Task_InitialiseDbDataObject extends SGL_Task
{
    function run($conf = array())
    {
        $options = &PEAR::getStaticProperty('DB_DataObject', 'options');
        $options = array(
            'database'              => SGL_DB::getDsn(SGL_DSN_STRING),
            'schema_location'       => SGL_ENT_DIR,
            'class_location'        => SGL_ENT_DIR,
            'require_prefix'        => SGL_ENT_DIR . '/',
            'class_prefix'          => 'DataObjects_',
            'debug'                 => SGL_Config::get('debug.dataObject'),
            'production'            => 0,
            'ignore_sequence_keys'  => 'ALL',
            'generator_strip_schema'=> 1,
            'quote_identifiers'     => 1,
        );
    }
}