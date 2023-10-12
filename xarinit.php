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
    ];

    if (!xarMod::apiFunc('modules', 'admin', 'standardinstall', ['module' => $module, 'objects' => $objects])) {
        return false;
    }

    // Set up module variables
    $databases = [];
    $databases['test'] = [
        'name' => 'test',
        'description' => 'Test Database',
        'filepath' => __DIR__ . '/xardata/metadata.db',
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
    return true;
}
