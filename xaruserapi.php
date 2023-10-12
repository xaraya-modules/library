<?php
/**
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.4.1
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://xaraya.info/index.php/release/18257.html
 */
sys::import('modules.library.class.userapi');
use Xaraya\Modules\Library\UserApi;

/**
 * Utility function to retrieve the list of itemtypes of this module (if any).
 * @uses Xaraya\Modules\Library\UserApi::itemtypes()
 * @param array    $args array of optional parameters
 * @return array the itemtypes of this module and their description
 */
function library_userapi_getitemtypes(array $args = [])
{
    return UserApi::itemtypes($args);
}

/**
 * utility function to pass individual item links to whoever
 * @uses Xaraya\Modules\Library\UserApi::itemlinks()
 * @param array    $args array of optional parameters
 *        string   $args['itemtype'] item type (optional)
 *        array    $args['itemids'] array of item ids to get
 * @return array containing the itemlink(s) for the item(s).
 */
function library_userapi_getitemlinks(array $args = [])
{
    return UserApi::itemlinks($args);
}
