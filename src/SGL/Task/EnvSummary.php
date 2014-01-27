<?php

define('EOL', "\n");

//  dependency types
define('SGL_NEUTRAL', 0);
define('SGL_RECOMMENDED', 1);
define('SGL_REQUIRED', 2);
define('SGL_FORBIDDEN', 3);

function bool2words($key)
{
    return ($key === true || $key === 1) ? 'Yes' : 'No';
}

function bool2int($key)
{
    return ($key === true || $key === 1) ? 1 : 0;
}

function ini_get2($key)
{
    return (ini_get($key) == '1' || $key === true ? 1 : 0);
}

/**
 * @package Task
 */
class SGL_Task_EnvSummary extends SGL_Task
{
    public static $aData = array();
    public static $aErrors = array();
    public static $aRequirements = array();
    public static $title = '';
    public static $mandatory = false;

    /**
     * @return string
     */
    function render()
    {
        $html = '<table width="70%" border=1>'.EOL;
        $html .= '<th colspan="3">'.$this->title.'</th>'.EOL;

        // check if in "php.ini Settings" portion of environment detection
        if (array_key_exists('register_globals', $this->aData)) {
            $cfg_file_path = (get_cfg_var("cfg_file_path"))
                ? get_cfg_var("cfg_file_path")
                : "<strong>php.ini not available</strong>";
            $html .= '<tr><td colspan="3"><strong>Note:</strong> Your php configuration file (php.ini) is located at: ' . $cfg_file_path . '</td></tr>';

            // check if open_basedir is set and warn user
            $open_basedir = ini_get('open_basedir');
            if (!empty($open_basedir)) {
                $html .= '<tr><td colspan="3"><span style="color: orange; font-weight: bold;">Warning:</span> ' .
                    'This server seems to be using the <strong>open_basedir</strong> php setting to limit ' .
                    'all file operations to the following directory: <strong>' . $open_basedir . '</strong>. ' .
                    'This may cause your installation and application ' .
                    'to work incorrectly.</td></tr>';
            }
        }
        if (!$this->mandatory) {
            $html .= '<tr><td>&nbsp;</td><td><em>Recommended</em></td><td><em>Actual</em></td></tr>'.EOL;
        }
        foreach (self::$aData as $k => $v) {
            $discoveredValue = (is_int($v)) ? bool2words($v) : $v;
            $html .= '<tr>'.EOL;
            $html .= '<td><strong>'.SGL_Inflector::getTitleFromCamelCase($k).'</strong></td>';
            if (is_array($v)) {
                $html .= '<td colspan="2">'.self::createComboBox($v).'</td>';
            } elseif ($this->mandatory) {
                $html .= '<td colspan="2">'.self::processDependency(self::$aRequirements[$k], @self::$aErrors[$k], $k, $v).$discoveredValue.'</span></td>';
            } else {
                $html .= '<td>'.$this->processRecommended(self::$aRequirements[$k]).'</td>';
                $html .= '<td>'.$this->processDependency(self::$aRequirements[$k], @self::$aErrors[$k], $k, $v).$discoveredValue.'</span></td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>'.EOL;
        return $html;
    }

    /**
     * @param $aRequirement
     * @param $error
     * @param $key
     * @param $actual
     * @return string
     */
    function processDependency($aRequirement, $error, $key, $actual)
    {
        $depType = key($aRequirement);
        $depValue = $aRequirement[$depType];// what value the dep requires

        if ($depType == SGL_REQUIRED) {

            //  exception for php version check
            if (preg_match("/>.*/", $depValue)) {
                $value = substr($depValue, 1);
                if (version_compare($actual, $value, 'g')) {
                    $status = 'green';
                } else {
                    $status = 'red';
                    SGL_Install_Common::errorPush(PEAR::raiseError($error));
                }
                //  else evaluate conventional values
            } else {
                if ($actual == $depValue) {
                    $status = 'green';
                } else {
                    $status = 'red';
                    SGL_Install_Common::errorPush(PEAR::raiseError($error));
                }
            }
        } elseif ($depType == SGL_RECOMMENDED) {
            if ($actual == $depValue) {
                $status = 'green';
            } else {
                $status = 'orange';
            }
        } elseif ($depType == SGL_FORBIDDEN) {
            if ($actual == $depValue) {
                $status = 'green';
            } else {
                $status = 'red';
                SGL_Install_Common::errorPush(PEAR::raiseError($error));
            }
        } else {
            //  neutral, no colour tag
            return '';
        }
        $html = "<span style=\"color:$status\">";
        return $html;
    }

    /**
     * @param $aRequirement
     * @return string
     */
    function processRecommended($aRequirement)
    {
        $depType = key($aRequirement);
        $depValue = $aRequirement[$depType];
        if ($depType == SGL_NEUTRAL) {
            $ret = '--';
        } else {
            $ret = is_int($depValue) ? bool2words($depValue) : $depValue;
        }
        return $ret;
    }

    /**
     * @param $aData
     * @return string
     */
    function createComboBox($aData)
    {
        $html = '<select name="pearPackages" multiple="multiple">';
        foreach ($aData as $option) {
            $html .= "<option value=\"$option\">$option";
        }
        $html .= '</select>';
        return $html;
    }
}
