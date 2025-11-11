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

use DefaultActionController;
use Xaraya\Services\xar;

/**
 * Use entity and action to avoid conflict with module & func or object & method
 *
 * Supported URLs :
 *
 * index.php?module=library&entity={entity}
 * index.php?module=library&entity={entity}&itemid={itemid}
 * index.php?module=library&entity={entity}&itemid={itemid}&title={title}
 * index.php?module=library&entity={entity}&action={action}
 * index.php?module=library&entity={entity}&action={action}&itemid={itemid}
 *
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
        $xar = xar::getServicesClass();
        // @todo avoid duplication of param parsing - see xarRequest::setURL()
        $request = $xar->req()->getRequest();
        $xar->var()->find('module', $module, 'regexp:/^[a-z][a-z_0-9]*$/');
        if (null != $module) {
            $xar->var()->find('type', $data['type'], "regexp:/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/:", $request->getType());
            $xar->var()->find('func', $data['func'], "regexp:/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/:", $request->getFunction());
        }
        $xar->var()->find('entity', $entity, 'regexp:/^[a-z][a-z_0-9]*$/');
        if (null != $entity) {
            $data['entity'] = $entity;
            $xar->var()->find('action', $data['action'], "regexp:/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/:");
        }
        // basically ignore object & method here, e.g. in POST of query ui handler
        return $data;
    }
}
