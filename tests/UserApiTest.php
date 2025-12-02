<?php

namespace Xaraya\Modules\Library\Tests;

use Xaraya\Modules\TestHelper;
use Xaraya\Modules\Library\UserApi;
use Xaraya\Services\xar;
use FunctionNotFoundException;

final class UserApiTest extends TestHelper
{
    protected function setUp(): void {}

    protected function tearDown(): void {}

    public function testUserApi(): void
    {
        /** @var UserApi $userapi */
        $userapi = xar::mod()->userapi('library');
        $itemtypes = $userapi->getItemTypes();
        $expected = 15;
        $this->assertCount($expected, $itemtypes);
    }

    public function testXarModApiFunc(): void
    {
        // initialize modules
        //xar::mod()->init();
        $result = xar::mod()->apiFunc('library', 'user', 'getitemtypes');
        $expected = 15;
        $this->assertCount($expected, $result);
    }

    public function testXarModApiFuncInvalidName(): void
    {
        // initialize modules
        //xar::mod()->init();
        $this->expectException(FunctionNotFoundException::class);
        $expected = 'The function "library_userapi_invalid" could not be found or not be loaded.';
        $this->expectExceptionMessage($expected);
        $result = xar::mod()->apiFunc('library', 'user', 'invalid');
    }
}
