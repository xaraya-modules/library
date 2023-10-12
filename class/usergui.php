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

use sys;

sys::import('modules.dynamicdata.class.objects.master');

/**
 * Class to handle the library user GUI
 */
class UserGui
{
    protected static $moduleid = 18257;
    protected static $objects = [];

    public static function main(array $args = [])
    {
        return $args;
    }
}
