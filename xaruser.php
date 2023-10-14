<?php
/**
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.4.1
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://xaraya.info/index.php/release/18257.html
 */
sys::import('modules.library.class.usergui');
sys::import('modules.library.class.import');
use Xaraya\Modules\Library\UserGui;
use Xaraya\Modules\Library\Import;

/**
 * User main
 *
 * @uses Xaraya\Modules\Library\UserGui::main()
 * @param array<string, mixed> $args
 * @return mixed template output in HTML
 */
function library_user_main(array $args = [])
{
    return UserGui::main($args);
}

/**
 * User import
 *
 * @uses Xaraya\Modules\Library\Import::main()
 * @param array<string, mixed> $args
 * @return mixed template output in HTML
 */
function library_user_import(array $args = [])
{
    return Import::main($args);
}
