<?php
/**
 * Initialise the library module
 *
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.4.1
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://xaraya.info/index.php/release/18257.html
 */

namespace Xaraya\Modules\Library;

use xarMod;
use xarModVars;

/**
 * Initialise this module
 *
 * @access public
 * @return  boolean true on success or false on failure
 */
function library_init()
{
    $module = 'library';
    $objects = [
        /**
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
         */
    ];

    if (!xarMod::apiFunc('modules', 'admin', 'standardinstall', ['module' => $module, 'objects' => $objects])) {
        return false;
    }

    // Set up module variables
    $databases = [];
    $databases['test'] = [
        'name' => 'test',
        'description' => 'Test Database',
        //'filepath' => __DIR__ . '/xardata/metadata.db',
        'filepath' => 'code/modules/library/xardata/metadata.db',
    ];
    xarModVars::set($module, 'databases', serialize($databases));

    // Installation complete; check for upgrades
    return library_upgrade('2.4.0');
}

/**
 * Activate this module
 *
 * @access public
 * @return boolean
 */
function library_activate()
{
    return true;
}

/**
 * Deactivate this module
 *
 * @access public
 * @return boolean
 */
function library_deactivate()
{
    return true;
}

/**
 * Upgrade this module from an old version
 *
 * @param string $oldversion
 * @return boolean true on success, false on failure
 */
function library_upgrade($oldversion)
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
 *
 * @return boolean
 */
function library_delete()
{
    return xarMod::apiFunc('modules', 'admin', 'standarddeinstall', ['module' => 'library']);
}
