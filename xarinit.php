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

/**
 * Initialise this module
 *
 * @access public
 * @return  boolean true on success or false on failure
 */
function library_init()
{
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
 * @param oldVersion
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
