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

use Xaraya\Core\Traits\DatabaseInterface;
use Xaraya\Core\Traits\DatabaseTrait;
use Xaraya\DataObject\Traits\UserApiInterface;
use Xaraya\DataObject\Traits\UserApiTrait;
use DataObject;
use DataObjectList;
use DataObjectFactory;
use Query;
use sys;

sys::import('modules.dynamicdata.class.objects.factory');
sys::import('modules.dynamicdata.class.traits.userapi');
sys::import('xaraya.traits.databasetrait');
sys::import('xaraya.structures.query');

/**
 * Class to handle the Library User API (static for now)
 */
class UserApi implements DatabaseInterface, UserApiInterface
{
    use DatabaseTrait;
    use UserApiTrait;

    protected static string $moduleName = 'library';
    protected static int $moduleId = 18257;
    protected static int $itemtype = 0;
    protected static string $prefix = 'lb_';

    /**
     * Summary of getBooksQuery
     * @param string $name
     * @return array|mixed|null
     */
    public static function getBooksQuery($name)
    {
        $result = [];
        $dbConnIndex = static::connectDatabase($name);
        if (empty($dbConnIndex)) {
            return $result;
        }
        $q = new Query('SELECT', 'books', ['id', 'title'], $dbConnIndex);
        if (!$q->run()) {
            return null;
        }
        return $q->output();
    }

    /**
     * Summary of getBooksObject
     * @param string $name
     * @param mixed $context
     * @return DataObject|null
     */
    public static function getBooksObject($name, $context = null)
    {
        static::setCurrentDatabase($name, $context);
        $object = DataObjectFactory::getObject(['name' => static::$prefix . 'books'], $context);
        return $object;
    }

    /**
     * Summary of getBooksObjectList
     * @param string $name
     * @param mixed $context
     * @return DataObjectList|null
     */
    public static function getBooksObjectList($name, $context = null)
    {
        static::setCurrentDatabase($name, $context);
        $object = DataObjectFactory::getObjectList(['name' => static::$prefix . 'books'], $context);
        return $object;
    }
}
