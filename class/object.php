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
        $itemid = $this->getItem($args);
        if ($this->name == 'lb_books') {
            return "Action for book $itemid!";
        } else {
            return "Action for item $itemid?";
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
     * Get text slug from title field
     * @param string $text
     * @return string
     */
    public function getSlug($text)
    {
        if (strlen($text) > 100) {
            $text = substr($text, 0, 100);
        }
        return $this->mls()->getSlug($text);
    }

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
            $this->action_urls['display'] = $this->getDisplayLink('1234567890', [$this->titlefield => 'replace_title']);
            if ($this->name == 'lb_books') {
                $this->action_urls['action'] = $this->getActionURL('action', '1234567890');
            }
        }
        $item ??= [];
        $title = (string) ($item[$this->titlefield] ?? '');
        $replace = [
            '1234567890' => $itemid,
            'replace_title' => $this->getSlug($title),
        ];
        $options = [];
        $options['display'] = [
            'otitle' => $this->ml('Display'),
            'oicon'  => 'display.png',
            'olink'  => str_replace(array_keys($replace), array_values($replace), $this->action_urls['display']),
            'ojoin'  => '',
        ];
        if ($this->name == 'lb_books') {
            $options['action'] = [
                'otitle' => $this->ml('Action'),
                'oicon'  => 'go-next.png',
                'olink'  => str_replace('1234567890', $itemid, $this->action_urls['action']),
                'ojoin'  => '',
            ];
        }
        return $options;
    }

    public function getDisplayLink($itemid = null, $item = null, $extra = [])
    {
        if (!empty($item) && !empty($item[$this->titlefield])) {
            $extra = array_merge($extra, ['title' => $this->getSlug($item[$this->titlefield])]);
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
