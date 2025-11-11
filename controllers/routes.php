<?php

/**
 * Library routes class for routing & dispatching outside Xaraya
 *
 * Experiment using module classes and methods as handler
 */

namespace Xaraya\Modules\Library;

use Xaraya\Routing\ModuleRoutes;
use Xaraya\Routing\RouterInterface;

/**
 * Library routes class for routing & dispatching outside Xaraya
 *
 * Supported URLs :
 *
 * ```
 * /library/
 * /library/admin/{func} (not used here)
 * /library/user/{func} (not used here)
 * /library/{entity}/
 * /library/{entity}/{itemid} (numeric)
 * /library/{entity}/{itemid}/{title}
 * /library/{entity}/{action} (non-numeric)
 * /library/{entity}/{action}/{itemid}
 * ```
 * @phpstan-import-type RouteDef from ModuleRoutes
 */
class LibraryRoutes extends ModuleRoutes
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

    /**
     * Find route uri based on params
     * @param array<string, mixed> $params
     */
    public static function findRoute(RouterInterface $router, array $params): ?string
    {
        return parent::findRoute($router, $params);
    }
}
