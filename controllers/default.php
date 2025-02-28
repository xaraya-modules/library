<?php

/**
 * Library Action Controller class
 *
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

use xarController;
use xarVar;
use sys;

sys::import('xaraya.mapper.controllers.default');
use DefaultActionController;

/**
 * Use entity and action to avoid conflict with module & func or object & method
 */
class LibraryDefaultController extends DefaultActionController
{
    /**
     * Summary of decode
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    public function decode(array $data = []): array
    {
        xarVar::fetch('module', 'regexp:/^[a-z][a-z_0-9]*$/', $module, null, xarVar::NOT_REQUIRED);
        if (null != $module) {
            xarVar::fetch('type', "regexp:/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/:", $data['type'], xarController::getRequest()->getType(), xarVar::NOT_REQUIRED);
            xarVar::fetch('func', "regexp:/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/:", $data['func'], xarController::getRequest()->getFunction(), xarVar::NOT_REQUIRED);
        }
        xarVar::fetch('entity', 'regexp:/^[a-z][a-z_0-9]*$/', $entity, null, xarVar::NOT_REQUIRED);
        if (null != $entity) {
            $data['entity'] = $entity;
            xarVar::fetch('action', "regexp:/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/:", $data['action'], null, xarVar::NOT_REQUIRED);
        }
        // basically ignore object & method here, e.g. in POST of query ui handler
        return $data;
    }
}
