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

class LibraryObject extends DataObject
{
    public $linktype = 'object';          // optional link type for use in getActionURL() (defaults to 'user' for module URLs, 'object' for object URLs, 'other' for middleware)
    public $titlefield = '';

    /**
     * Summary of action
     * @param array<string, mixed> $args
     * @return mixed
     */
    public function action(array $args = [])
    {
        if ($this->name == 'lb_books') {
            return "Action!";
        } else {
            return "Action?";
        }
    }

    public function getActionURL($action = '', $itemid = null, $extra = [])
    {
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

class LibraryObjectList extends DataObjectList
{
    /** @var array<string, string>|null */
    private $action_urls = null;
    public $linktype = 'object';          // optional link type for use in getActionURL() (defaults to 'user' for module URLs, 'object' for object URLs, 'other' for middleware)
    public $titlefield = '';

    /**
     * Get List to fill showView template options
     *
     * @param mixed $itemid
     * @return array<mixed>
     */
    public function getViewOptions($itemid = null, $item = null)
    {
        sys::import('modules.library.controllers.short');
        if (!isset($this->action_urls)) {
            $this->action_urls = [];
            $this->action_urls['display'] = $this->getDisplayLink('[itemid]', [$this->titlefield => 'replace_title']);
            if ($this->name == 'lb_books') {
                $this->action_urls['action'] = $this->getActionURL('action', '[itemid]');
            }
        }
        $item ??= [];
        $title = (string) ($item[$this->titlefield] ?? '');
        $replace = [
            '[itemid]' => $itemid,
            'replace_title' => LibraryShortController::getSlug($title),
        ];
        $options = [];
        $options['display'] = [
            'otitle' => xarML('Display'),
            'oicon'  => 'display.png',
            'olink'  => str_replace(array_keys($replace), array_values($replace), $this->action_urls['display']),
            'ojoin'  => '',
        ];
        if ($this->name == 'lb_books') {
            $options['action'] = [
                'otitle' => xarML('Action'),
                'oicon'  => 'go-next.png',
                'olink'  => str_replace('[itemid]', $itemid, $this->action_urls['action']),
                'ojoin'  => '',
            ];
        }
        return $options;
    }

    public function getDisplayLink($itemid = null, $item = null, $extra = [])
    {
        if (!empty($item) && !empty($item[$this->titlefield])) {
            $extra = array_merge($extra, ['title' => $item[$this->titlefield]]);
        }
        return $this->getActionURL('display', $itemid, $extra);
    }

    public function getActionURL($action = '', $itemid = null, $extra = [])
    {
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
