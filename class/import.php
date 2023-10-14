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

//use Xaraya\DataObject\Export\PhpExporter;
use DataObject;
use DataObjectMaster;
use TableObjectDescriptor;
use Throwable;
use xarModVars;
use sys;

sys::import('modules.dynamicdata.class.objects.master');
sys::import('modules.dynamicdata.class.objects.virtual');

/**
 * Class to import the library database structure
 */
class Import
{
    protected static int $moduleid = 18257;
    protected static int $itemtype = 0;
    protected static string $prefix = 'lb_';
    /** @var array<string, mixed> */
    protected static array $tables = [];
    /** @var array<string, mixed> */
    protected static array $links = [];
    protected static ?int $dbConnIndex = 0;
    protected static ?DataObject $dataobject = null;
    protected static ?DataObject $dataproperty = null;

    /**
     * User import GUI function
     * @param array<string, mixed> $args
     * @return array<mixed>
     */
    public static function main(array $args = [])
    {
        // use 'test' database to import
        $name = $args['name'] ?? 'test';

        $databases = UserApi::getDatabases();
        $tables = UserApi::getDatabaseTables($name);
        static::$dbConnIndex = UserApi::connectDatabase($name);

        $primary = ['authors', 'books', 'data', 'identifiers', 'languages', 'publishers', 'ratings', 'series', 'tags'];
        $status = [];
        foreach ($tables as $table) {
            if (in_array($table, $primary)) {
                $status[] = $table . ' ' . static::importTable($table);
                continue;
            }
            if (!str_ends_with($table, '_link')) {
                $status[] = $table . ' SKIPPED';
                continue;
            }
            [$first, $second, $link] = explode('_', $table);
            if (!in_array($first, $primary) || !in_array($second, $primary)) {
                $status[] = $table . ' SKIPPED';
                continue;
            }
            $status[] = $table . ' ' . static::importLink($table, $first, $second);
        }
        static::linkObjects();
        static::createObjects();
        static::saveObjects();
        //static::deleteObjects();

        $args = array_merge($args, $databases[$name]);
        $args['tables'] = $status;
        $args['name'] = $name;
        $args['description'] ??= '';
        return $args;
    }

    /**
     * Summary of importTable
     * @param string $table
     * @return string
     */
    public static function importTable($table)
    {
        static::$itemtype += 1;
        $config = ['dbConnIndex' => static::$dbConnIndex, 'dbConnArgs' => json_encode([UserApi::class, 'getDbConnArgs'])];
        $descriptor = new TableObjectDescriptor([
            'name' => static::$prefix . $table,
            'label' => 'Library ' . ucfirst($table),
            'moduleid' => static::$moduleid,
            'itemtype' => static::$itemtype,
            'table' => $table,
            'dbConnIndex' => static::$dbConnIndex,
            'config' => serialize($config),
            // ensure proper initialisation even when autoload is disabled
            'class' => 'Xaraya\Modules\Library\LibraryObject',
            'filepath' => 'modules/library/class/object.php',
        ]);
        // set the actual connection index here
        //$descriptor->set('dbConnIndex', static::$dbConnIndex);
        //$descriptor->set('config', serialize($config));
        static::$tables[$table] = $descriptor;
        //$dataobject = new DataObject($descriptor);
        $filepath = dirname(__DIR__) . '/xardata/' . static::$prefix . $table . '-def.php';
        //return static::exportDefinition($dataobject, $filepath);
        return $filepath;
    }

    /**
     * Summary of importLink
     * @param string $table
     * @param string $first
     * @param string $second
     * @return string
     */
    public static function importLink($table, $first, $second)
    {
        $link = $first . '_' . $second;
        static::$itemtype += 1;
        $config = ['dbConnIndex' => static::$dbConnIndex, 'dbConnArgs' => json_encode([UserApi::class, 'getDbConnArgs'])];
        $descriptor = new TableObjectDescriptor([
            'name' => static::$prefix . $link,
            'label' => 'Library ' . ucfirst($first) . ' ' . ucfirst($second),
            'moduleid' => static::$moduleid,
            'itemtype' => static::$itemtype,
            'table' => $table,
            'dbConnIndex' => static::$dbConnIndex,
            'config' => serialize($config),
            // ensure proper initialisation even when autoload is disabled
            'class' => 'Xaraya\Modules\Library\LibraryObject',
            'filepath' => 'modules/library/class/object.php',
        ]);
        // set the actual connection index here
        //$descriptor->set('dbConnIndex', static::$dbConnIndex);
        //$descriptor->set('config', serialize($config));
        static::$links[$link] = $descriptor;
        //$dataobject = new DataObject($descriptor);
        $filepath = dirname(__DIR__) . '/xardata/' . static::$prefix . $link . '-def.php';
        //return static::export_def($dataobject, $filepath);
        return $filepath;
    }

    /**
     * Summary of linkObjects
     * @return void
     */
    public static function linkObjects()
    {
        foreach (static::$tables as $table => $descriptor) {
            if ($table == 'books') {
                continue;
            }
            $link = 'books_' . $table;
            if (empty(static::$links[$link])) {
                continue;
            }
            // add many-to-many relationship with books
            $field = static::getLinkField($link);
            // linkobject:lb_books_authors.author.book:lb_books.id,title
            $default = 'linkobject:' . static::$prefix . 'books_' . $table . '.' . $field . '.book:' . static::$prefix . 'books.title';
            static::$tables[$table]->addProperty([
                'name' => 'books',
                'label' => 'Books',
                'type' => '18283',
                'source' => '',
                'defaultvalue' => $default,
                'status' => '2',
            ]);
            // add many-to-many relationship for books
            $title = static::getTitleField($table);
            // linkobject:lb_books_authors.book.author:lb_authors.id,name
            $default = 'linkobject:' . static::$prefix . 'books_' . $table . '.book.' . $field . ':' . static::$prefix . $table . '.' . $title;
            static::$tables['books']->addProperty([
                'name' => $table,
                'label' => ucfirst($table),
                'type' => '18283',
                'source' => '',
                'defaultvalue' => $default,
                'status' => ($table == 'authors') ? '1' : '2',
            ]);
            // add one-to-many relationship for links
            $propertyargs = static::$links[$link]->get('propertyargs');
            $newpropargs = [];
            foreach ($propertyargs as $propertyarg) {
                if ($propertyarg['name'] == $field) {
                    $propertyarg['type'] = '18281';
                    // dataobject:lb_authors.name
                    $propertyarg['defaultvalue'] = 'dataobject:' . static::$prefix . $table . '.' . $title;
                    $newpropargs[] = $propertyarg;
                    continue;
                }
                if ($propertyarg['name'] == 'book') {
                    $propertyarg['type'] = '18281';
                    // dataobject:lb_books.title
                    $propertyarg['defaultvalue'] = 'dataobject:' . static::$prefix . 'books.title';
                    $newpropargs[] = $propertyarg;
                    continue;
                }
                $newpropargs[] = $propertyarg;
            }
            static::$links[$link]->set('propertyargs', $newpropargs);
        }
    }

    /**
     * Summary of getLinkField
     * @param string $link
     * @return string
     */
    public static function getLinkField($link)
    {
        $descriptor = static::$links[$link];
        $field = 'missing';
        foreach ($descriptor->get('propertyargs') as $propertyarg) {
            if ($propertyarg['name'] == 'id' || $propertyarg['name'] ==  'book') {
                continue;
            }
            $field = $propertyarg['name'];
            break;
        }
        return $field;
    }

    /**
     * Summary of getTitleField
     * @param string $table
     * @return string
     */
    public static function getTitleField($table)
    {
        $descriptor = static::$tables[$table];
        $field = 'missing';
        foreach ($descriptor->get('propertyargs') as $propertyarg) {
            if ($propertyarg['name'] == 'id' || $propertyarg['type'] != '2') {
                continue;
            }
            $field = $propertyarg['name'];
            break;
        }
        return $field;
    }

    /**
     * Summary of createObjects
     * @return void
     */
    public static function createObjects()
    {
        static::$dataobject ??= DataObjectMaster::getObject(['name' => 'objects']);
        //static::$dataobject->dataquery->debugflag = true;
        static::$dataproperty ??= DataObjectMaster::getObject(['name' => 'properties']);
        //static::$dataproperty->dataquery->debugflag = true;
        $dd_objects = [];
        foreach (static::$tables as $table => $descriptor) {
            $objectid = static::createObject($descriptor);
            //static::$tables[$table]->set('objectid', $objectid);
            $dd_objects[$descriptor->get('name')] = $objectid;
        }
        foreach (static::$links as $link => $descriptor) {
            $objectid = static::createObject($descriptor);
            //static::$links[$link]->set('objectid', $objectid);
            $dd_objects[$descriptor->get('name')] = $objectid;
        }
        // see modules standardinstall - used by standarddeinstall later
        xarModVars::set('library', 'dd_objects', serialize($dd_objects));
    }

    /**
     * Summary of createObject
     * @param TableObjectDescriptor $descriptor
     * @return int|mixed
     */
    public static function createObject($descriptor)
    {
        assert(isset(static::$dataobject));
        assert(isset(static::$dataproperty));
        $info = $descriptor->getArgs();
        $propertyargs = $info['propertyargs'];
        unset($info['propertyargs']);
        $objectid = static::$dataobject->createItem($info);
        $sequence = 1;
        foreach ($propertyargs as $propertyarg) {
            $propertyarg = array_filter($propertyarg, function ($key) {
                return !str_starts_with($key, 'object_');
            }, ARRAY_FILTER_USE_KEY);
            $propertyarg['itemid'] = 0;
            $propertyarg['objectid'] = $objectid;
            unset($propertyarg['_objectid']);
            $propertyarg['seq'] ??= $sequence;
            $propertyarg['configuration'] ??= '';
            $propid = static::$dataproperty->createItem($propertyarg);
            $sequence += 1;
        }
        return $objectid;
    }

    /**
     * Summary of saveObjects
     * @return void
     */
    public static function saveObjects()
    {
        foreach (static::$tables as $table => $descriptor) {
            //$dataobject = new DataObject($descriptor);
            $filepath = dirname(__DIR__) . '/xardata/' . $descriptor->get('name') . '-def.php';
            static::exportDefinition($descriptor, $filepath);
        }
        foreach (static::$links as $link => $descriptor) {
            //$dataobject = new DataObject($descriptor);
            $filepath = dirname(__DIR__) . '/xardata/' . $descriptor->get('name') . '-def.php';
            static::exportDefinition($descriptor, $filepath);
        }
    }

    /**
     * Summary of exportDefinition
     * @param TableObjectDescriptor $descriptor
     * @param string $filepath
     * @return string
     */
    public static function exportDefinition($descriptor, $filepath)
    {
        $info = $descriptor->getArgs();
        $propertyargs = $info['propertyargs'];
        unset($info['propertyargs']);
        $arrayargs = ['access', 'config', 'sources', 'relations', 'objects', 'category'];
        foreach ($arrayargs as $name) {
            if (!empty($info[$name]) && is_string($info[$name])) {
                try {
                    $value = unserialize($info[$name]);
                    if ($value !== false) {
                        $info[$name] = $value;
                    }
                } catch (Throwable $e) {
                }
            }
        }
        $output = "<?php\n\n\$object = " . var_export($info, true) . ";\n";
        $output .= "\$properties = array();\n";
        foreach ($propertyargs as $propertyarg) {
            $propertyarg = array_filter($propertyarg, function ($key) {
                return !str_starts_with($key, 'object_');
            }, ARRAY_FILTER_USE_KEY);
            unset($propertyarg['_objectid']);
            $output .= "\$properties[] = " . var_export($propertyarg, true) . ";\n";
        }
        $output .= "\$object['propertyargs'] = \$properties;\nreturn \$object;\n";
        file_put_contents($filepath, $output);
        return '<pre>' . str_replace('<', '&lt;', $output) . '</pre>';
    }

    /**
     * Summary of deleteObjects
     * @return void
     */
    public static function deleteObjects()
    {
        $objects = DataObjectMaster::getObjects();
        foreach ($objects as $objectid => $objectinfo) {
            if (intval($objectinfo['moduleid']) !== self::$moduleid) {
                continue;
            }
            $objectname = $objectinfo['name'];
            $result = DataObjectMaster::deleteObject(['name' => $objectname]);
            if (empty($result)) {
                echo 'Error deleting object ' . $objectname;
            }
        }
    }
}
