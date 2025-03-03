<?php

/**
 * Library handler class for routing & dispatching outside Xaraya
 *
 * @todo experiment using module classes and methods as handler
 */

namespace Xaraya\Modules\Library;

use Xaraya\Routing\ModuleHandler;

/**
 * Library handler class for routing & dispatching outside Xaraya
 *
 * Supported URLs :
 *
 * ```
 * /library/
 * /library/admin/{func} (not used here)
 * /library/admin/{func}/{more} (not used here)
 * /library/user/{func} (not used here)
 * /library/user/{func}/{more} (not used here)
 * /library/{entity}/
 * /library/{entity}/{itemid} (numeric)
 * /library/{entity}/{itemid}/{title}
 * /library/{entity}/{action} (non-numeric)
 * /library/{entity}/{action}/{itemid}
 * ```
 */
class LibraryHandler extends ModuleHandler
{
    public static string $moduleName = 'library';
    public static string $objectName = 'library';
    /** @var class-string */
    public static string $handlerClass = UserGui::class;

    /**
     * Get supported handler routes (in generic format)
     * @return array<mixed> array of name => [method(s), path, handler, options = []]
     */
    public static function getRoutes(string $pathPrefix = '', string $namePrefix = ''): array
    {
        return parent::getRoutes($pathPrefix, $namePrefix);
    }
}
