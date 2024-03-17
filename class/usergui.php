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

use Xaraya\DataObject\Traits\UserGuiInterface;
use Xaraya\DataObject\Traits\UserGuiTrait;
use BadParameterException;
use xarSec;
use xarVar;
use sys;

sys::import('modules.dynamicdata.class.objects.factory');
sys::import('modules.dynamicdata.class.traits.usergui');
sys::import('modules.library.class.userapi');

/**
 * Class instance to handle the Library User GUI
 */
class UserGui implements UserGuiInterface
{
    use UserGuiTrait;

    /**
     * User main GUI function
     * @param array<string, mixed> $args
     * @return array<mixed>
     */
    public function main(array $args = [])
    {
        $databases = UserApi::getDatabases();
        $selected = null;
        xarVar::fetch('selected', 'array', $selected, [], xarVar::DONT_SET);
        if (!empty($selected) && is_array($selected) && xarSec::confirmAuthKey('library')) {
            foreach ($databases as $name => $database) {
                if (array_key_exists($name, $selected)) {
                    unset($database['disabled']);
                } else {
                    $database['disabled'] = true;
                }
                $databases[$name] = $database;
            }
            $new = null;
            xarVar::fetch('new', 'array', $new, [], xarVar::DONT_SET);
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
            UserApi::saveDatabases($databases);
        }
        $args['databases'] = $databases;

        xarVar::fetch('name', 'str:1', $args['name'], null, xarVar::DONT_SET);
        if (!empty($args['name']) && !empty($databases) && !empty($databases[$args['name']])) {
            UserApi::setCurrentDatabase($args['name'], $this->getContext());
            $database = $databases[$args['name']];
            $args = array_merge($args, $database);
            $args['dbConnIndex'] = UserApi::connectDatabase($args['name']);
            //$args['tables'] = UserApi::getDatabaseTables($args['name']);
            //$args['books'] = UserApi::getBooksQuery($args['name']);
            $args['objectlist'] = UserApi::getBooksObjectList($args['name'], $this->getContext());
            $params = [
                'fieldlist' => ['title', 'timestamp', 'pubdate', 'authors'],
                'numitems' => 100,
            ];
            xarVar::fetch('startnum', 'int', $args['startnum'], null, xarVar::DONT_SET);
            if (!empty($args['startnum'])) {
                $params['startnum'] = $args['startnum'];
            }
            $args['objectlist']?->getItems($params);
            $args['objects'] = UserApi::getModuleObjects();
        } else {
            unset($args['name']);
        }
        $args['description'] ??= '';
        $args['current'] = UserApi::getCurrentDatabase($this->getContext());
        return $args;
    }
}
