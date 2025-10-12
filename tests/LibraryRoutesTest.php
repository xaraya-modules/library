<?php

namespace Xaraya\Modules\Library\Tests;

use Xaraya\Modules\TestHelper;
use Xaraya\Routing\Dispatcher;
use Xaraya\Routing\RouterInterface;
use Xaraya\Routing\Routing;
use Xaraya\Modules\Library\LibraryRoutes;
use Xaraya\Modules\Library\UserGui;
use xarClassMap;
use xarTpl;

final class LibraryRoutesTest extends TestHelper
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
    }

    public function testClasssMap(): void
    {
        $modName = 'library';

        $handlers = xarClassMap::getHandlers($modName);
        $expected = 0;
        $this->assertCount($expected, $handlers);

        $routes = xarClassMap::getRoutes($modName);
        $expected = LibraryRoutes::class;
        $this->assertArrayHasKey($expected, $routes);
        $expected = 1;
        $this->assertCount($expected, $routes);

        $classTypes = xarClassMap::getModuleClassTypes($modName);
        $expected = 'usergui';
        $this->assertArrayHasKey($expected, $classTypes);
        $expected = 4;
        $this->assertCount($expected, $classTypes);

        $classType = 'usergui';
        $methods = xarClassMap::getModuleClassMethods($modName, $classType);
        $expected = 0;
        $this->assertCount($expected, $methods);

        $dataobjects = xarClassMap::getDataObjects($modName);
        $expected = 'Xaraya\Modules\Library\LibraryObject';
        $this->assertArrayHasKey($expected, $dataobjects);
        $expected = 4;
        $this->assertCount($expected, $dataobjects);
    }

    public function testGetRoutes(): void
    {
        $expected = 8;
        $routes = LibraryRoutes::getRoutes();
        $this->assertCount($expected, $routes);

        $expected = 'library-main';
        $route = array_key_first($routes);
        $this->assertEquals($expected, $route);
    }

    public function testLibraryMain(): void
    {
        xarTpl::init();

        $router = new Routing(function () {
            return LibraryRoutes::getRoutes();
        });
        $path = '/library/';
        [$handler, $vars] = $router->match($path);

        $expected = [LibraryRoutes::class, 'main'];
        $this->assertEquals($expected, $handler);

        $route = 'library-main';
        $expected = ['_route' => $route];
        $this->assertEquals($expected, $vars);

        $context = $this->createContext();
        [$routesClass, $method] = $handler;
        $moduleHandler = $routesClass::getHandler($route, $context);
        $expected = UserGui::class;
        $this->assertInstanceOf($expected, $moduleHandler->getInstance());

        [$result, $context] = $moduleHandler->callHandler($handler, $vars);

        // @todo depends on whether we apply template in callHandler() or output()
        $expected = 'View Library';
        $this->assertStringContainsString($expected, $result);

        $output = $moduleHandler->output($result);

        $expected = 'View Library';
        $this->assertStringContainsString($expected, $output);
    }

    public function testLibraryEntity(): void
    {
        xarTpl::init();

        $router = new Routing(function () {
            return LibraryRoutes::getRoutes();
        });
        $path = '/library/authors/1';
        [$handler, $vars] = $router->match($path);

        $expected = [LibraryRoutes::class, 'handle'];
        $this->assertEquals($expected, $handler);

        $route = 'library-entity-itemid';
        $expected = [
            '_route' => $route,
            'entity' => 'authors',
            'itemid' => '1',
        ];
        $this->assertEquals($expected, $vars);

        $context = $this->createContext();
        [$routesClass, $method] = $handler;
        $moduleHandler = $routesClass::getHandler($route, $context);
        [$result, $context] = $moduleHandler->callHandler($handler, $vars);

        $output = $moduleHandler->output($result);
        $output = preg_replace('/<!--.*?-->/s', '', $output);

        $expected = 'Name</label></div><div class="xar-col">Arthur Conan Doyle</div>';
        $this->assertStringContainsString($expected, $output);
    }

    public static function getRouteProvider(): array
    {
        $moduleName = 'library';
        $class = LibraryRoutes::class;
        return [
            // uri => [route, callable, path, params]
            '/library/' => ['library-main', [$class, 'main'], '/library/', ['module' => $moduleName]],
            '/library/admin/func' => ['library-admin', [$class, 'admingui'], '/library/admin/func', ['module' => $moduleName, 'type' => 'admin', 'func' => 'func']],
            '/library/admin/func?more=more' => ['library-admin', [$class, 'admingui'], '/library/admin/func?more=more', ['module' => $moduleName, 'type' => 'admin', 'func' => 'func', 'more' => 'more']],
            '/library/user/func' => ['library-user', [$class, 'usergui'], '/library/user/func', ['module' => $moduleName, 'type' => 'user', 'func' => 'func']],
            '/library/user/func?more=more' => ['library-user', [$class, 'usergui'], '/library/user/func?more=more', ['module' => $moduleName, 'type' => 'user', 'func' => 'func', 'more' => 'more']],
            '/library/authors' => ['library-entity', [$class, 'handle'], '/library/authors', ['module' => $moduleName, 'entity' => 'authors']],
            '/library/authors/1' => ['library-entity-itemid', [$class, 'handle'], '/library/authors/1', ['module' => $moduleName, 'entity' => 'authors', 'itemid' => '1']],
            '/library/authors/1/Johnny' => ['library-entity-itemid-title', [$class, 'handle'], '/library/authors/1/Johnny', ['module' => $moduleName, 'entity' => 'authors', 'itemid' => '1', 'title' => 'Johnny']],
            '/library/authors/search' => ['library-entity-action', [$class, 'handle'], '/library/authors/search', ['module' => $moduleName, 'entity' => 'authors', 'action' => 'search']],
            '/library/authors/update/1' => ['library-entity-action-itemid', [$class, 'handle'], '/library/authors/update/1', ['module' => $moduleName, 'entity' => 'authors', 'action' => 'update', 'itemid' => '1']],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('getRouteProvider')]
    public function testRouterMatch(string $route, array $callable, string $path, array $params): void
    {
        $router = new Routing(function () {
            return LibraryRoutes::getRoutes();
        });
        $query = parse_url($path, PHP_URL_QUERY);
        $path = parse_url($path, PHP_URL_PATH);
        [$handler, $vars] = $router->match($path);
        if (!empty($query)) {
            $extra = [];
            parse_str($query, $extra);
            $vars = array_merge($vars, $extra);
        }

        $expected = $callable;
        $this->assertEquals($expected, $handler);

        $expected = [
            '_route' => $route,
        ];
        unset($params['module']);
        unset($params['type']);
        $expected = array_merge($expected, $params);
        $this->assertEquals($expected, $vars);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('getRouteProvider')]
    public function testFindRoute(string $route, array $callable, string $path, array $params): void
    {
        $router = new Routing(function () {
            return LibraryRoutes::getRoutes();
        });
        $uri = LibraryRoutes::findRoute($router, $params);

        $expected = $path;
        $this->assertEquals($expected, $uri);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('getRouteProvider')]
    public function testRouterGenerate(string $route, array $callable, string $path, array $params): void
    {
        $router = new Routing(function () {
            return LibraryRoutes::getRoutes();
        });
        unset($params['module']);
        unset($params['type']);
        $uri = $router->generate($route, $params);

        $expected = $path;
        $this->assertEquals($expected, $uri);
    }

    public function testDispatcher(): void
    {
        $dispatcher = new Dispatcher();

        $path = '/library/authors/1';
        $params = [];
        $method = 'GET';
        [$result, $context] = $dispatcher->dispatch($path, $params, $method);

        $output = $dispatcher->output($result);
        $output = preg_replace('/<!--.*?-->/s', '', $output);

        $expected = 'Name</label></div><div class="xar-col">Arthur Conan Doyle</div>';
        $this->assertStringContainsString($expected, $output);

        // make sure we reset the Controller here for later tests
        $dispatcher->resetController();
    }
}
