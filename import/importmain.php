<?php

/**
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.5.6
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://xaraya.info/index.php/release/182.html
 *
 * @author mikespub <mikespub@xaraya.com>
 **/

namespace Xaraya\Modules\Library\Import;

use Xaraya\Modules\MethodClass;
use Xaraya\Modules\Library\Import;
use Xaraya\Modules\Library\UserApi;
use Xaraya\DataObject\Export\PhpExporter;
use Xaraya\DataObject\Import\PhpImporter;
use DataObjectFactory;
use TableObjectDescriptor;

/**
 * Class to import the library database structure
 * @extends MethodClass<Import>
 */
class ImportmainMethod extends MethodClass
{
    protected int $moduleId = 18257;
    protected int $itemtype = 0;
    /** @var array<string, mixed> */
    protected array $tables = [];
    /** @var array<string, mixed> */
    protected array $links = [];
    protected int|string|null $dbConnIndex = 0;
    protected string $basedir;

    /**
     * Summary of __invoke
     * @param array<string, mixed> $args
     * @return array<mixed>
     * @see Import::importmain()
     */
    public function __invoke(array $args = [])
    {
        $this->basedir = dirname(__DIR__, 2);
        // use 'test' database to import
        $name = $args['name'] ?? 'test';

        /** @var UserApi $userapi */
        $userapi = $this->userapi();

        $databases = $userapi->getDatabases();
        $tables = $userapi->getDatabaseTables($name);
        $this->dbConnIndex = $userapi->connectDatabase($name);

        $primary = ['authors', 'books', 'data', 'identifiers', 'languages', 'publishers', 'ratings', 'series', 'tags'];
        $status = [];
        foreach ($tables as $table) {
            if (in_array($table, $primary)) {
                //$status[] = $table . ' ' . $this->importTable($table);
                $status[] = $table . ' LOADED ' . $this->loadTable($table);
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
            //$status[] = $table . ' ' . $this->importLink($table, $first, $second);
            $status[] = $table . ' LOADED ' . $this->loadLink($table, $first, $second);
        }
        //$this->linkObjects();
        //$this->createObjects();
        //$this->saveObjects();
        //$this->deleteObjects();

        $args = array_merge($args, $databases[$name]);
        $args['tables'] = $status;
        $args['name'] = $name;
        $args['description'] ??= '';
        return $args;
    }

    /**
     * Summary of loadTable
     * @param string $table
     * @return string
     */
    public function loadTable($table)
    {
        $filepath = $this->basedir . '/xardata/' . UserApi::$prefix . $table . '-def.php';
        $descriptor = PhpImporter::importDefinition($filepath);
        $this->tables[$table] = $descriptor;
        return basename($filepath);
    }

    /**
     * Summary of loadLink
     * @param string $table
     * @param string $first
     * @param string $second
     * @return string
     */
    public function loadLink($table, $first, $second)
    {
        $link = $first . '_' . $second;
        $filepath = $this->basedir . '/xardata/' . UserApi::$prefix . $link . '-def.php';
        $descriptor = PhpImporter::importDefinition($filepath);
        $this->links[$link] = $descriptor;
        return basename($filepath);
    }

    /**
     * Summary of importTable
     * @param string $table
     * @return string
     */
    public function importTable($table)
    {
        $this->itemtype += 1;
        $config = ['dbConnIndex' => $this->dbConnIndex, 'dbConnArgs' => json_encode([UserApi::class, 'getDbConnArgs'])];
        $descriptor = new TableObjectDescriptor([
            'name' => UserApi::$prefix . $table,
            'label' => 'Library ' . ucfirst($table),
            'moduleid' => $this->moduleId,
            'itemtype' => $this->itemtype,
            'table' => $table,
            'dbConnIndex' => $this->dbConnIndex,
            'config' => serialize($config),
            // ensure proper initialisation even when autoload is disabled
            'class' => 'Xaraya\Modules\Library\LibraryObject',
            'filepath' => 'modules/library/class/object.php',
        ]);
        $this->tables[$table] = $descriptor;
        $filepath = $this->basedir . '/xardata/' . UserApi::$prefix . $table . '-def.php';
        return $filepath;
    }

    /**
     * Summary of importLink
     * @param string $table
     * @param string $first
     * @param string $second
     * @return string
     */
    public function importLink($table, $first, $second)
    {
        $link = $first . '_' . $second;
        $this->itemtype += 1;
        $config = ['dbConnIndex' => $this->dbConnIndex, 'dbConnArgs' => json_encode([UserApi::class, 'getDbConnArgs'])];
        $descriptor = new TableObjectDescriptor([
            'name' => UserApi::$prefix . $link,
            'label' => 'Library ' . ucfirst($first) . ' ' . ucfirst($second),
            'moduleid' => $this->moduleId,
            'itemtype' => $this->itemtype,
            'table' => $table,
            'dbConnIndex' => $this->dbConnIndex,
            'config' => serialize($config),
            // ensure proper initialisation even when autoload is disabled
            'class' => 'Xaraya\Modules\Library\LibraryLinkObject',
            'filepath' => 'modules/library/class/link.php',
        ]);
        $this->links[$link] = $descriptor;
        $filepath = $this->basedir . '/xardata/' . UserApi::$prefix . $link . '-def.php';
        return $filepath;
    }

    /**
     * Summary of linkObjects
     * @return void
     */
    public function linkObjects()
    {
        foreach ($this->tables as $table => $descriptor) {
            if ($table == 'books') {
                continue;
            }
            $link = 'books_' . $table;
            if (empty($this->links[$link])) {
                continue;
            }
            // add many-to-many relationship with books
            $field = $this->getLinkField($link);
            // linkobject:lb_books_authors.author.book:lb_books.id,title
            $default = 'linkobject:' . UserApi::$prefix . 'books_' . $table . '.' . $field . '.book:' . UserApi::$prefix . 'books.title';
            $this->tables[$table]->addProperty([
                'name' => 'books',
                'label' => 'Books',
                'type' => '18283',
                'source' => '',
                'defaultvalue' => $default,
                'status' => '2',
            ]);
            // add many-to-many relationship for books
            $title = $this->getTitleField($table);
            // linkobject:lb_books_authors.book.author:lb_authors.id,name
            $default = 'linkobject:' . UserApi::$prefix . 'books_' . $table . '.book.' . $field . ':' . UserApi::$prefix . $table . '.' . $title;
            $this->tables['books']->addProperty([
                'name' => $table,
                'label' => ucfirst($table),
                'type' => '18283',
                'source' => '',
                'defaultvalue' => $default,
                'status' => ($table == 'authors') ? '1' : '2',
            ]);
            // add one-to-many relationship for links
            $propertyargs = $this->links[$link]->get('propertyargs');
            $newpropargs = [];
            foreach ($propertyargs as $propertyarg) {
                if ($propertyarg['name'] == $field) {
                    $propertyarg['type'] = '18281';
                    // dataobject:lb_authors.name
                    $propertyarg['defaultvalue'] = 'dataobject:' . UserApi::$prefix . $table . '.' . $title;
                    $newpropargs[] = $propertyarg;
                    continue;
                }
                if ($propertyarg['name'] == 'book') {
                    $propertyarg['type'] = '18281';
                    // dataobject:lb_books.title
                    $propertyarg['defaultvalue'] = 'dataobject:' . UserApi::$prefix . 'books.title';
                    $newpropargs[] = $propertyarg;
                    continue;
                }
                $newpropargs[] = $propertyarg;
            }
            $this->links[$link]->set('propertyargs', $newpropargs);
        }
    }

    /**
     * Summary of getLinkField
     * @param string $link
     * @return string
     */
    public function getLinkField($link)
    {
        $descriptor = $this->links[$link];
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
    public function getTitleField($table)
    {
        $descriptor = $this->tables[$table];
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
    public function createObjects()
    {
        $dd_objects = [];
        foreach ($this->tables as $table => $descriptor) {
            $objectid = PhpImporter::createObject($descriptor);
            //$this->tables[$table]->set('objectid', $objectid);
            $dd_objects[$descriptor->get('name')] = $objectid;
        }
        foreach ($this->links as $link => $descriptor) {
            $objectid = PhpImporter::createObject($descriptor);
            //$this->links[$link]->set('objectid', $objectid);
            $dd_objects[$descriptor->get('name')] = $objectid;
        }
        // see modules standardinstall - used by standarddeinstall later
        $this->mod()->setVar('dd_objects', serialize($dd_objects));
    }

    /**
     * Summary of saveObjects
     * @return void
     */
    public function saveObjects()
    {
        foreach ($this->tables as $table => $descriptor) {
            //$dataobject = new DataObject($descriptor);
            $filepath = $this->basedir . '/xardata/' . $descriptor->get('name') . '-def.php';
            PhpExporter::exportDefinition($descriptor, $filepath);
        }
        foreach ($this->links as $link => $descriptor) {
            //$dataobject = new DataObject($descriptor);
            $filepath = $this->basedir . '/xardata/' . $descriptor->get('name') . '-def.php';
            PhpExporter::exportDefinition($descriptor, $filepath);
        }
    }

    /**
     * Summary of deleteObjects
     * @return void
     */
    public function deleteObjects()
    {
        $objects = $this->data()->getObjects();
        foreach ($objects as $objectid => $objectinfo) {
            if (intval($objectinfo['moduleid']) !== $this->moduleId) {
                continue;
            }
            $objectname = $objectinfo['name'];
            $result = DataObjectFactory::deleteObject(['name' => $objectname]);
            if (empty($result)) {
                echo 'Error deleting object ' . $objectname;
            }
        }
    }
}
