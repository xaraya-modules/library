<?php

namespace Xaraya\Modules\Library\Tests;

use Xaraya\Modules\TestHelper;
use Xaraya\Modules\Library\UserGui;
use xarMod;
use xarTpl;

final class UserGuiTest extends TestHelper
{
    protected function setUp(): void {}

    protected function tearDown(): void {}

    public function testUserGui(): void
    {
        $expected = UserGui::class;
        /** @var UserGui $usergui */
        $usergui = xarMod::usergui('library');
        $this->assertEquals($expected, $usergui::class);
    }

    public function testUserMain(): void
    {
        $context = $this->createContext();
        /** @var UserGui $usergui */
        $usergui = xarMod::usergui('library');
        $usergui->setContext($context);

        $args = ['hello' => 'world'];
        $data = $usergui->main($args);

        $expected = array_merge($args, [
            'description' => '',
            'databases' => [
                'test' => [
                    'name' => 'test',
                    'description' => 'Test Database',
                    'databaseType' => 'sqlite3',
                    'databaseName' => 'code/modules/library/xardata/metadata.db',
                ],
            ],
            'current' => 'test',
        ]);
        $this->assertEquals($expected, $data);
    }

    public function testXarModGuiFunc(): void
    {
        // initialize modules
        //xarMod::init();
        // needed to initialize the template cache
        xarTpl::init();
        $expected = 'View Library';
        $output = (string) xarMod::guiFunc('library');
        $this->assertStringContainsString($expected, $output);
    }

    public function testXarModGuiFuncInvalidName(): void
    {
        // initialize modules
        //xarMod::init();
        // needed to initialize the template cache
        xarTpl::init();
        $expected = 'Function not found';
        $output = (string) xarMod::guiFunc('library', 'user', 'invalid');
        $this->assertStringContainsString($expected, $output);
    }
}
