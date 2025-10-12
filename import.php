<?php

/**
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.5.6
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
 *
 * @author mikespub <mikespub@xaraya.com>
 **/

namespace Xaraya\Modules\Library;

/**
 * Class to handle the Library Import GUI
 *
 * @method mixed importmain(array $args)
 */
class Import extends UserGui
{
    public function configure()
    {
        $this->setModType('import');
        // don't call xarMod:apiLoad() for library import API
    }

    /**
     * Import main GUI function
     * @param array<string, mixed> $args
     * @return array<mixed>
     */
    public function main(array $args = [])
    {
        $data = [];
        $data['tables'] = [];
        $data['name'] = 'done';
        $data['description'] = 'Already done...';
        return $data;
    }
}
