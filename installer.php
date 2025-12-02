<?php

/**
 * Handle module installer functions
 *
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.5.7
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
**/

namespace Xaraya\Modules\Library;

use Xaraya\Modules\InstallerClass;

/**
 * Handle module installer functions
 *
 * @todo add extra use ...; statements above as needed
 * @todo replaced library_*() function calls with $this->*() calls
 * @extends InstallerClass<Module>
 */
class Installer extends InstallerClass
{
    /**
     * Configure this module - override this method
     *
     * @todo use this instead of init() etc. for standard installation
     * @return void
     */
    public function configure()
    {
        $this->objects = [
            // add your DD objects here
            //'library_object',
        ];
        $this->variables = [
            // add your module variables here
            'hello' => 'world',
        ];
        $this->oldversion = '2.4.1';
    }

    /** xarinit.php functions imported by bermuda_cleanup */

    /**
     * Initialise this module
     * @access public
     * @return bool true on success or false on failure
     */
    public function init()
    {
        $module = 'library';
        $objects = [
            'lb_authors',
            'lb_books',
            'lb_books_authors',
            'lb_books_languages',
            'lb_books_publishers',
            'lb_books_ratings',
            'lb_books_series',
            'lb_books_tags',
            'lb_data',
            'lb_identifiers',
            'lb_languages',
            'lb_publishers',
            'lb_ratings',
            'lb_series',
            'lb_tags',
        ];

        if (!$this->mod()->apiFunc('modules', 'admin', 'standardinstall', ['module' => $module, 'objects' => $objects])) {
            return false;
        }

        // Set up module variables
        $databases = [];
        $databases['test'] = [
            'name' => 'test',
            'description' => 'Test Database',
            'databaseType' => 'sqlite3',
            //'databaseName' => __DIR__ . '/xardata/metadata.db',
            'databaseName' => 'code/modules/library/xardata/metadata.db',
            //... other DSN parameters for mysql/mariadb
        ];
        $this->mod()->setVar('databases', serialize($databases));
        $this->mod()->setVar('dbName', 'test');

        // Installation complete; check for upgrades
        return $this->upgrade('2.4.0');
    }

    /**
     * Activate this module
     * @access public
     * @return bool
     */
    public function activate()
    {
        return true;
    }

    /**
     * Deactivate this module
     * @access public
     * @return bool
     */
    public function deactivate()
    {
        return true;
    }

    /**
     * Upgrade this module from an old version
     * @param string $oldversion
     * @return bool true on success, false on failure
     */
    public function upgrade($oldversion)
    {
        // Upgrade dependent on old version number
        switch ($oldversion) {
            case '2.4.0':
                break;
            default:
                break;
        }
        return true;
    }

    /**
     * Delete this module
     * @return bool
     */
    public function delete()
    {
        return $this->mod()->apiFunc('modules', 'admin', 'standarddeinstall', ['module' => 'library']);
    }
}
