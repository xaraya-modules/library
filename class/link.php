<?php

/**
 * Ensure proper initialisation even when autoload is disabled
 *
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.4.1
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
 *
 * @author mikespub <mikespub@xaraya.com>
 **/

namespace Xaraya\Modules\Library;

use DataObject;
use DataObjectList;
use sys;

sys::import('modules.dynamicdata.class.objects');
sys::import('modules.library.userapi');

class LibraryLinkObject extends DataObject
{
    // ...
}

class LibraryLinkObjectList extends DataObjectList
{
    /** @var array<string, string>|null */
    private $action_urls = null;

    /**
     * Get List to fill showView template options
     *
     * @param mixed $itemid
     * @return array<mixed>
     */
    public function getViewOptions($itemid = null)
    {
        if (!isset($this->action_urls)) {
            $this->action_urls = [];
            $this->action_urls['display'] = $this->getActionURL('display', '[itemid]');
        }
        $options = [];
        $options['display'] = [
            'otitle' => xarML('Display'),
            'oicon'  => 'display.png',
            'olink'  => str_replace('[itemid]', $itemid, $this->action_urls['display']),
            'ojoin'  => '',
        ];
        return $options;
    }
}
