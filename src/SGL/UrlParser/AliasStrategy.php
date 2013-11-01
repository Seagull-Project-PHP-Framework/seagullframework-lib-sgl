<?php
/**
 * Strategy for handling URL aliases.
 *
 * @package SGL
 * @author  Demian Turner <demian@phpkitchen.com>
 * @version $Revision: 1.5 $
 */

require_once SGL_MOD_DIR . '/navigation/classes/NavigationDAO.php';
require_once SGL_CORE_DIR . '/UrlParser/SimpleStrategy.php';


/**
 * Concrete alias url parser strategy
 *
 */
class SGL_UrlParser_AliasStrategy extends SGL_UrlParser_SimpleStrategy
{
    function __construct()
    {
        $this->da =  NavigationDAO::singleton();
    }
    /**
     * Analyzes querystring content and parses it into module/manager/action and params.
     *
     * @param SGL_Url $url
     * @return array        An array to be assigned to SGL_Url::aQueryData
     * @todo frontScriptName is already dealt with in SGL_Url constructor, remove from here
     */
    function parseQueryString(SGL_Url $url)
    {
        $aUriAliases = $this->da->getAllAliases();
        $aUriParts = SGL_Url::toPartialArray($url->url, SGL_Config::get('site.frontScriptName'));

        //    The alias will always be the second uri part in the array
        //    FIXME: needs to be more flexible
        $countUriParts = SGL_Config::get('site.frontScriptName') ? 1 : 0;
        $ret = array();
        if (count($aUriParts) > $countUriParts) {
            $alias = array_shift($aUriParts);
            if ($countUriParts) {
                $alias = array_shift($aUriParts);
            }

            //  If alias exists, update the alias in the uri with the specified resource
            if (array_key_exists($alias, $aUriAliases)) {
                $key = $aUriAliases[$alias]->resource_uri;

                // records stored in section table in following format:
                // uriAlias:10:default/bug
                // parse out SEF url from 2nd semi-colon onwards
                if (preg_match('/^(uriAlias:)([0-9]+:)(.*)$/', $key, $aMatches)) {
                    $aliasUri = $aMatches[3];

                    // check for uriExternal
                    if (preg_match('/^uriExternal:(.*)$/', $aliasUri, $aUri)) {
                        header('Location: ' . $aUri[1]);
                        exit;
                    }

                    $tmp = new stdClass();
                    $tmp->url = $aliasUri . '/' . implode('/', $aUriParts);
                    $ret = parent::parseQueryString($tmp);
                }
            }
        }
        return $ret;
    }
}
?>