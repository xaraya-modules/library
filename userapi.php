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
use Xaraya\Modules\DynamicData\Traits\UserApiInterface;
use Xaraya\Modules\DynamicData\Traits\UserApiTrait;
use DataObject;
use DataObjectList;
use DataObjectFactory;
use Query;

/**
 * Class to handle the Library User API
 */
class UserApi implements DatabaseInterface, UserApiInterface
{
    use DatabaseTrait;
    /** @use UserApiTrait<Module> */
    use UserApiTrait;
    // @see https://www.php.net/manual/en/language.oop5.traits.php Example #5 Conflict Resolution
    //use DatabaseTrait, UserApiTrait {
    //    UserApiTrait::getModName insteadof DatabaseTrait;
    //    UserApiTrait::setModName insteadof DatabaseTrait;
    //}

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
