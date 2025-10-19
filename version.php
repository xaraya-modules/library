<?php

/**
 * Library version information
 *
 * @package modules\library
 * @copyright (C) 2023 Mike's Pub
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
 * @author mikespub
 */

namespace Xaraya\Modules\Library;

class Version
{
    /**
     * Get module version information
     *
     * @return array<string, mixed>
     */
    public function __invoke(): array
    {
        return [
            'name' => 'library',
            'id' => '18257',
            'version' => '2.5.3',
            'displayname' => 'Library',
            'description' => 'Library of books from Calibre or elsewhere',
            'credits' => '',
            'help' => '',
            'changelog' => '',
            'license' => '',
            'official' => false,
            'author' => 'mikespub',
            'contact' => 'https://github.com/mikespub/xaraya-modules',
            'admin' => false,
            'user' => true,
            'class' => 'Complete',
            'category' => 'Content',
            'namespace' => 'Xaraya\\Modules\\Library',
            'securityschema'
             => [
             ],
            'dependency'
             => [
             ],
            'twigtemplates' => true,
            'dependencyinfo'
             => [
                 0
                  => [
                      'name' => 'Xaraya Core',
                      'version_ge' => '2.4.1',
                  ],
             ],
        ];
    }
}
