<?php

/**
 * Ensure proper initialisation even when autoload is disabled
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

use DataObject;
use DataObjectList;
use sys;

sys::import('modules.dynamicdata.class.objects');
sys::import('modules.library.userapi');

class LibraryLinkObject extends DataObject
{
    public $linktype = 'object';          // optional link type for use in getActionURL() (defaults to 'user' for module URLs, 'object' for object URLs, 'other' for middleware)
    public $titlefield = 'id';

    public function getActionURL($action = '', $itemid = null, $extra = [])
    {
        //return parent::getActionURL($action, $itemid, $extra);
        $extra['entity'] ??= substr($this->name, 3);
        if (!empty($action)) {
            $extra['action'] ??= $action;
        }
        if (!empty($itemid)) {
            $extra['itemid'] ??= $itemid;
        }
        return $this->ctl()->getModuleURL('library', 'user', 'view', $extra);
    }
}

class LibraryLinkObjectList extends DataObjectList
{
    /** @var array<string, string>|null */
    private $action_urls = null;
    public $linktype = 'object';          // optional link type for use in getActionURL() (defaults to 'user' for module URLs, 'object' for object URLs, 'other' for middleware)
    public $titlefield = 'id';

    /**
     * Get List to fill showView template options
     *
     * @param mixed $itemid
     * @return array<mixed>
     */
    public function getViewOptions($itemid = null, $item = null)
    {
        if (!isset($this->action_urls)) {
            $this->action_urls = [];
            $this->action_urls['display'] = $this->getDisplayLink('[itemid]');
        }
        $item ??= [];
        $replace = [
            '[itemid]' => $itemid,
        ];
        $options = [];
        $options['display'] = [
            'otitle' => xarML('Display'),
            'oicon'  => 'display.png',
            'olink'  => str_replace(array_keys($replace), array_values($replace), $this->action_urls['display']),
            'ojoin'  => '',
        ];
        return $options;
    }

    public function getDisplayLink($itemid = null, $item = null, $extra = [])
    {
        //if (!empty($item) && !empty($item[$this->titlefield])) {
        //    $extra = array_merge($extra, ['title' => $item[$this->titlefield]]);
        //}
        return $this->getActionURL('display', $itemid, $extra);
    }

    public function getActionURL($action = '', $itemid = null, $extra = [])
    {
        //return parent::getActionURL($action, $itemid, $extra);
        $extra['entity'] ??= substr($this->name, 3);
        if (!empty($action)) {
            $extra['action'] ??= $action;
        }
        if (!empty($itemid)) {
            $extra['itemid'] ??= $itemid;
        }
        return $this->ctl()->getModuleURL('library', 'user', 'view', $extra);
    }
}
