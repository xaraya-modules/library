<?php
/**
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.4.1
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
 *
 * @author mikespub <mikespub@xaraya.com>
 **/

namespace Xaraya\Modules\Library;

use xarVar;
use sys;

sys::import('modules.dynamicdata.class.objects.master');

/**
 * Class to handle the library user GUI
 */
class UserGui
{
    protected static $moduleid = 18257;
    protected static $objects = [];
    protected static $dbConnIndex = 0;

    public static function main(array $args = [])
    {
        xarVar::fetch('name', 'str:1', $args['name'], null, xarVar::DONT_SET);

        $args['databases'] = UserApi::getDatabases();
        if (!empty($args['name']) && !empty($args['databases']) && !empty($args['databases'][$args['name']])) {
            $database = $args['databases'][$args['name']];
            $args = array_merge($args, $database);
            $args['dbConnIndex'] = UserApi::connectDatabase($args['name']);
            //$args['tables'] = UserApi::getTables($args['dbConnIndex']);
            $args['books'] = UserApi::getBooks($args['name']);
        }
        $args['description'] ??= '';
        return $args;
    }
}
