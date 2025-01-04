<?php
/**
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.4.1
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://xaraya.info/index.php/release/18257.html
 */
sys::import('modules.library.class.import');
use Xaraya\Modules\Library\Import;

/**
 * User main
 *
 * @uses Xaraya\Modules\Library\UserGui::main()
 * @param array<string, mixed> $args
 * @param mixed $context
 * @return mixed template output in HTML
 */
function library_user_main(array $args = [], $context = null)
{
    $usergui = xarMod::getGUI('library');
    $usergui->setContext($context);
    return $usergui->main($args);
}

/**
 * User import
 *
 * @uses Xaraya\Modules\Library\Import::main()
 * @param array<string, mixed> $args
 * @param mixed $context
 * @return mixed template output in HTML
 */
function library_user_import(array $args = [], $context = null)
{
    return Import::main($args);
}
