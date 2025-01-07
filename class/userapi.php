<?php

/**
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.5.6
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
 *
 * @author mikespub <mikespub@xaraya.com>
 **/

namespace Xaraya\Modules\Library;

use Xaraya\Database\DatabaseInterface;
use Xaraya\Database\DatabaseTrait;
use Xaraya\DataObject\Traits\UserApiInterface;
use Xaraya\DataObject\Traits\UserApiTrait;
use DataObject;
use DataObjectList;
use DataObjectFactory;
use Query;
use sys;

sys::import('modules.dynamicdata.class.objects.factory');
sys::import('modules.dynamicdata.class.traits.userapi');
sys::import('xaraya.database.databasetrait');
sys::import('xaraya.structures.query');

/**
 * Class to handle the Library User API
 */
class UserApi implements DatabaseInterface, UserApiInterface
{
    use DatabaseTrait;
    use UserApiTrait;

    public static string $prefix = 'lb_';

    /**
     * Summary of getBooksQuery
     * @param string $name
     * @return array|mixed|null
     */
    public function getBooksQuery($name)
    {
        $result = [];
        $dbConnIndex = $this->connectDatabase($name);
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
    public function getBooksObject($name, $context = null)
    {
        $this->setCurrentDatabase($name, $context);
        $object = DataObjectFactory::getObject(['name' => static::$prefix . 'books'], $context);
        return $object;
    }

    /**
     * Summary of getBooksObjectList
     * @param string $name
     * @param mixed $context
     * @return DataObjectList|null
     */
    public function getBooksObjectList($name, $context = null)
    {
        $this->setCurrentDatabase($name, $context);
        $object = DataObjectFactory::getObjectList(['name' => static::$prefix . 'books'], $context);
        return $object;
    }
}
