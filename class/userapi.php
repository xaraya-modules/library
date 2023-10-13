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

use DataObjectDescriptor;
use DataObjectMaster;
use DataPropertyMaster;
use Query;
use xarDB;
use xarModVars;
use xarServer;
use xarVar;
use sys;

sys::import('modules.dynamicdata.class.objects.master');

/**
 * Class to handle the library user API
 */
class UserApi
{
    protected static $moduleid = 18257;
    protected static $objects = [];
    protected static $databases = [];
    protected static $connections = [];

    public static function getDatabases()
    {
        if (empty(static::$databases)) {
            static::$databases = unserialize(xarModVars::get('library', 'databases'));
        }
        return static::$databases;
    }

    public static function connectDatabase($name)
    {
        if (!empty(static::$connections[$name])) {
            return static::$connections[$name];
        }
        $databases = self::getDatabases();
        if (empty($databases[$name])) {
            return null;
        }
        $database = $databases[$name];
        if (empty($database['filepath']) || !is_file($database['filepath'])) {
            return null;
        }
        // open a new database connection
        $args = self::getDbConnArgs($name);
        $conn = xarDB::newConn($args);
        // save the connection index
        $dbConnIndex = xarDB::$count - 1;
        static::$connections[$name] = $dbConnIndex;
        // return the connection index
        return $dbConnIndex;
    }

    /**
     * Callable specified in object config to get dbConnArgs
     */
    public static function getDbConnArgs($object = null)
    {
        $databases = self::getDatabases();
        $database = $databases['test'];
        return ['databaseType' => 'sqlite3', 'databaseName' => $database['filepath']];
    }

    public static function getTables($name)
    {
        $result = [];
        $dbConnIndex = self::connectDatabase($name);
        if (empty($dbConnIndex)) {
            return $result;
        }
        $conn = xarDB::getConn($dbConnIndex);
        $dbInfo = $conn->getDatabaseInfo();
        $tables = $dbInfo->getTables();
        foreach ($tables as $table) {
            $result[] = $table->getName();
        }
        return $result;
    }

    public static function getBooks($name)
    {
        $result = [];
        $dbConnIndex = self::connectDatabase($name);
        if (empty($dbConnIndex)) {
            return $result;
        }
        $q = new Query('SELECT', 'books', ['id', 'title'], $dbConnIndex);
        if (!$q->run()) {
            return;
        }
        return $q->output();
    }

    public static function getObjects()
    {
        if (!empty(self::$objects)) {
            return self::$objects;
        }
        $objects = DataObjectMaster::getObjects();
        self::$objects = [];
        foreach ($objects as $objectid => $objectinfo) {
            if (intval($objectinfo['moduleid']) !== self::$moduleid) {
                continue;
            }
            self::$objects[$objectinfo['name']] = $objectinfo;
        }
        return self::$objects;
    }

    /**
     * Utility function to retrieve the list of itemtypes of this module (if any).
     * @param array    $args array of optional parameters
     * @return array the itemtypes of this module and their description
     */
    public static function itemtypes(array $args = [])
    {
        $objects = self::getObjects();
        $itemtypes = [];
        foreach ($objects as $name => $objectinfo) {
            $itemtypes[$objectinfo['itemtype']] = [
                'label' => xarVar::prepForDisplay($objectinfo['label']),
                'title' => xarVar::prepForDisplay(xarML('View #(1)', $objectinfo['label'])),
                'url'   => xarServer::getObjectURL($objectinfo['name'], 'view'),
            ];
        }
        return $itemtypes;
    }

    /**
     * utility function to pass individual item links to whoever
     * @param array    $args array of optional parameters
     *        string   $args['itemtype'] item type (optional)
     *        array    $args['itemids'] array of item ids to get
     * @return array containing the itemlink(s) for the item(s).
     */
    public static function itemlinks(array $args = [])
    {
        extract($args);

        $itemlinks = [];
        if (empty($itemtype)) {
            $itemtype = null;
        }
        if (empty($itemids)) {
            $itemids = null;
        }

        // for items managed by library itself only
        $args = DataObjectDescriptor::getObjectID(['moduleid'  => self::$moduleid,
                                        'itemtype'  => $itemtype]);
        if (empty($args['objectid'])) {
            return $itemlinks;
        }
        $status = DataPropertyMaster::DD_DISPLAYSTATE_ACTIVE;
        $object = DataObjectMaster::getObjectList(['objectid'  => $args['objectid'],
                                            'itemids' => $itemids,
                                            'status' => $status]);
        if (!isset($object) || (empty($object->objectid) && empty($object->table))) {
            return $itemlinks;
        }
        if (!$object->checkAccess('view')) {
            return $itemlinks;
        }

        $object->getItems();

        $properties = & $object->getProperties();
        $items = & $object->items;
        if (!isset($items) || !is_array($items) || count($items) == 0) {
            return $itemlinks;
        }

        // TODO: make configurable
        $titlefield = '';
        foreach ($properties as $name => $property) {
            // let's use the first textbox property we find for now...
            if ($property->type == 2) {
                $titlefield = $name;
                break;
            }
        }

        // if we didn't have a list of itemids, return all the items we found
        if (empty($itemids)) {
            $itemids = array_keys($items);
        }

        foreach ($itemids as $itemid) {
            if (!empty($titlefield) && isset($items[$itemid][$titlefield])) {
                $label = $items[$itemid][$titlefield];
            } else {
                $label = xarML('Item #(1)', $itemid);
            }
            // $object->getActionURL('display', $itemid)
            $itemlinks[$itemid] = ['url'   => xarServer::getObjectURL($object->name, 'display', ['itemid' => $itemid]),
                                   'title' => xarML('Display Item'),
                                   'label' => $label];
        }
        return $itemlinks;
    }
}
