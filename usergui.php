<?php

/**
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.7.0
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
 *
 * @author mikespub <mikespub@xaraya.com>
 **/

namespace Xaraya\Modules\Library;

use Xaraya\Modules\DynamicData\Traits\UserGuiInterface;
use Xaraya\Modules\DynamicData\Traits\UserGuiTrait;
use BadParameterException;
use xarMod;

/**
 * Class instance to handle the Library User GUI
 */
class UserGui implements UserGuiInterface
{
    /** @use UserGuiTrait<Module> */
    use UserGuiTrait;

    public static string $prefix = 'lb_';  // map entity to object by adding prefix in handle()

    /**
     * User main GUI function
     * @param array<string, mixed> $args
     * @return array<mixed>|string
     */
    public function main(array $args = [])
    {
        // use entity and action to avoid conflict with module & func or object & method
        if (!empty($args['entity'])) {
            return $this->view($args);
        }
        /** @var UserApi $userapi */
        $userapi = $this->userapi();

        $databases = $userapi->getDatabases();
        $selected = null;
        $this->var()->check('selected', $selected, 'array', []);
        if (!empty($selected) && is_array($selected) && $this->sec()->confirmAuthKey()) {
            foreach ($databases as $name => $database) {
                if (array_key_exists($name, $selected)) {
                    unset($database['disabled']);
                } else {
                    $database['disabled'] = true;
                }
                $databases[$name] = $database;
            }
            $new = null;
            $this->var()->check('new', $new, 'array', []);
            if (!empty($new) && is_array($new) && !empty($new['name'])) {
                if (!empty($new['filepath']) && is_file($new['filepath'])) {
                    $name = strtolower(str_replace(' ', '', $new['name']));
                    $database = [
                        'name' => $name,
                        'description' => $new['description'] ?: $new['name'],
                        'databaseType' => 'sqlite3',
                        'databaseName' => $new['filepath'],
                    ];
                    $databases[$name] = $database;
                } else {
                    throw new BadParameterException($new['filepath'], 'Invalid file path #(1)');
                }
            }
            // don't disable the only database here
            if (count($databases) < 2) {
                $first = array_key_first($databases);
                unset($databases[$first]['disabled']);
            }
            $userapi->saveDatabases($databases);
        }
        $args['databases'] = $databases;

        $this->var()->check('name', $args['name'], 'str:1');
        if (!empty($args['name']) && !empty($databases) && !empty($databases[$args['name']])) {
            $userapi->setCurrentDatabase($args['name'], $this->getContext());
            $database = $databases[$args['name']];
            $args = array_merge($args, $database);
            $args['dbConnIndex'] = $userapi->connectDatabase($args['name']);
            //$args['tables'] = $userapi::getDatabaseTables($args['name']);
            //$args['books'] = $userapi->getBooksQuery($args['name']);
            $args['objectlist'] = $userapi->getBooksObjectList($args['name'], $this->getContext());
            $params = [
                'fieldlist' => ['title', 'timestamp', 'pubdate', 'authors'],
                'numitems' => 100,
            ];
            $this->var()->check('sort', $args['sort']);
            if (!empty($args['sort'])) {
                $params['sort'] = $args['sort'];
            }
            $this->var()->check('startnum', $args['startnum'], 'int');
            if (!empty($args['startnum'])) {
                $params['startnum'] = $args['startnum'];
            }
            $args['objectlist']?->getItems($params);
            $args['objects'] = $userapi->getModuleObjects();
        } else {
            unset($args['name']);
        }
        $args['description'] ??= '';
        $args['current'] = $userapi->getCurrentDatabase($this->getContext());
        // use the 'default' template instead of the module 'user' template here
        \xarTpl::setPageTemplateName('default');
        return $args;
    }

    /**
     * User view GUI function
     * @param array<string, mixed> $args
     * @return string
     * @see \Xaraya\Modules\DynamicData\UserGui::handle()
     */
    public function view(array $args = [])
    {
        return $this->handle($args);
    }

    /**
     * User import GUI function
     * @param array<string, mixed> $args
     * @return array<mixed>|bool
     */
    public function import(array $args = [])
    {
        //$module = xarMod::getModule('library');
        ///** @var Import $import */
        //$import = $module->getComponent('Import');
        //$import->setContext($this->getContext());
        //return $import->main($args);
        $this->ctl()->redirect($this->mod()->getURL('import', 'main'));
        return true;
    }
}
