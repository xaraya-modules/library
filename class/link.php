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

class LibraryLinkObject extends DataObject
{
    public $linktype = 'object';          // optional link type for use in getActionURL() (defaults to 'user' for module URLs, 'object' for object URLs, 'other' for middleware)
    public $titlefield = 'id';

    public function getActionURL($action = '', $itemid = null, $extra = [])
    {
        //return parent::getActionURL($action, $itemid, $extra);
        $extra['entity'] ??= substr($this->name, strlen(LibraryObject::PREFIX));
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
            $this->action_urls['display'] = $this->getDisplayLink('1234567890');
        }
        $item ??= [];
        $replace = [
            '1234567890' => $itemid,
        ];
        $options = [];
        $options['display'] = [
            'otitle' => $this->ml('Display'),
            'oicon'  => 'display.png',
            'olink'  => str_replace(array_keys($replace), array_values($replace), $this->action_urls['display']),
            'ojoin'  => '',
        ];
        return $options;
    }

    public function getDisplayLink($itemid = null, $item = null, $extra = [])
    {
        // do something with item here, e.g. add title to extra params for nicer links
        //if (!empty($item) && !empty($item[$this->titlefield])) {
        //    $slug = $this->mls()->slug($item[$this->titlefield]);
        //    $extra = array_merge($extra, ['title' => $slug]);
        //}
        return $this->getActionURL('display', $itemid, $extra);
    }

    public function getActionURL($action = '', $itemid = null, $extra = [])
    {
        //return parent::getActionURL($action, $itemid, $extra);
        $extra['entity'] ??= substr($this->name, strlen(LibraryObject::PREFIX));
        if (!empty($action)) {
            $extra['action'] ??= $action;
        }
        if (!empty($itemid)) {
            $extra['itemid'] ??= $itemid;
        }
        return $this->ctl()->getModuleURL('library', 'user', 'view', $extra);
    }
}
