<?php

/**
 * Ensure proper initialisation even when autoload is disabled
 *
 * @package modules\library
 * @category Xaraya Web Applications Framework
 * @version 2.9.3
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
 *
 * @author mikespub <mikespub@xaraya.com>
 **/

namespace Xaraya\Modules\Library;

use sys;
use EmptyParameterException;

class LibraryBook extends LibraryObject
{
    public const COVER = 'cover.jpg';

    /** @var array<string, string> */
    public static $mimetypes = [
        'aac'   => 'audio/aac',
        'azw'   => 'application/x-mobipocket-ebook',
        'azw1'  => 'application/x-topaz-ebook',
        'azw2'  => 'application/x-kindle-application',
        'azw3'  => 'application/x-mobi8-ebook',
        'cbz'   => 'application/x-cbz',
        'cbr'   => 'application/x-cbr',
        'css'   => 'text/css',
        'djv'   => 'image/vnd.djvu',
        'djvu'  => 'image/vnd.djvu',
        'doc'   => 'application/msword',
        'epub'  => 'application/epub+zip',
        'fb2'   => 'text/fb2+xml',
        'gif'   => 'image/gif',
        'ibooks' => 'application/x-ibooks+zip',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpeg',
        'kepub' => 'application/epub+zip',
        'kobo'  => 'application/x-koboreader-ebook',
        'm4a'   => 'audio/mp4',
        'm4b'   => 'audio/mp4',
        'mobi'  => 'application/x-mobipocket-ebook',
        'mp3'   => 'audio/mpeg',
        'lit'   => 'application/x-ms-reader',
        'lrs'   => 'text/x-sony-bbeb+xml',
        'lrf'   => 'application/x-sony-bbeb',
        'lrx'   => 'application/x-sony-bbeb',
        'ncx'   => 'application/x-dtbncx+xml',
        'opf'   => 'application/oebps-package+xml',
        'otf'   => 'font/otf',
        'pdb'   => 'application/vnd.palm',
        'pdf'   => 'application/pdf',
        'png'   => 'image/png',
        'prc'   => 'application/x-mobipocket-ebook',
        'rtf'   => 'application/rtf',
        'svg'   => 'image/svg+xml',
        'ttf'   => 'font/ttf',
        'tpz'   => 'application/x-topaz-ebook',
        'txt'   => 'text/plain',
        'wav'   => 'audio/wav',
        'webp'  => 'image/webp',
        'wmf'   => 'image/wmf',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'xhtml' => 'application/xhtml+xml',
        'xml'   => 'application/xhtml+xml',
        'xpgt'  => 'application/adobe-page-template+xml',
        'zip'   => 'application/zip',
    ];
    /** @var ?string */
    protected $bookPath = null;

    /**
     * Summary of action
     * @param array<string, mixed> $args
     * @return mixed
     */
    public function action(array $args = [])
    {
        $itemid = $this->getItem($args);
        if (empty($itemid)) {
            return $this->ctl()->notFound('Invalid book');
        }
        $formats = $this->getFormats();
        $args['formats'] = [];
        // only logged-in users can download books here
        $isLoggedIn = $this->user()->isLoggedIn();
        foreach ($formats as $item) {
            $format = strtolower($item['format']);
            $size = intdiv($item['uncompressed_size'], 1024);
            $link = $this->getFormatURL($format, $item['filepath']);
            $args['formats'][$format] = [
                'name' => $format,
                'size' => $size,
                'format' => $item['format'],
                'link' => '',
            ];
            if (!empty($link) && $isLoggedIn) {
                $args['formats'][$format]['link'] = $link;
            }
        }
        $args['properties'] = $this->getProperties();
        //$args['properties']['title'] = & $this->properties['title'];
        $args['tplmodule'] ??= $this->getModName();
        $args['object'] = $this;
        return $this->tpl()->object($args['tplmodule'], $args['template'], 'action', $args);
    }

    /**
     * Summary of getFormats
     * @throws EmptyParameterException
     * @return array<mixed>
     */
    public function getFormats()
    {
        // did we get a book - call getItem() first
        if (empty($this->itemid)) {
            throw new EmptyParameterException('itemid');
        }
        $data = $this->data()->getObjectList(['name' => LibraryObject::PREFIX . 'data']);
        $formats = $data->getItems(['where' => 'book = ' . $this->itemid]);
        $found = $this->findFormats();
        foreach ($formats as $id => $item) {
            $format = strtolower($item['format']);
            if (!empty($found[$format])) {
                $formats[$id]['filepath'] = $found[$format];
            } else {
                $formats[$id]['filepath'] = '';
            }
        }
        return $formats;
    }

    /**
     * Summary of findFormats
     * @throws EmptyParameterException
     * @return array<string, string>
     */
    public function findFormats()
    {
        // did we get a book - call getItem() first
        if (empty($this->itemid)) {
            throw new EmptyParameterException('itemid');
        }
        $found = [];
        $this->bookPath ??= $this->getBookPath();
        if (empty($this->bookPath)) {
            return $found;
        }
        $handle = opendir($this->bookPath);
        while (false !== ($entry = readdir($handle))) {
            if ($entry === '.' || $entry === '..') {
                continue;
            }
            $file = $this->bookPath . '/' . $entry;
            if (!is_file($file)) {
                continue;
            }
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $found[$ext] = $file;
        }
        closedir($handle);
        return $found;
    }

    /**
     * Summary of getBookPath
     * @throws EmptyParameterException
     * @return string
     */
    public function getBookPath()
    {
        // did we get a book - call getItem() first
        if (empty($this->itemid)) {
            throw new EmptyParameterException('itemid');
        }
        // does this book have a book path
        if (empty($this->properties['path']?->value)) {
            return '';
        }
        // do we have a database connection
        if (!is_array($this->dbConnArgs)) {
            return '';
        }
        // do we have a database name (= filepath for sqlite3)
        if (empty($this->dbConnArgs['databaseName'])) {
            return '';
        }
        // can we access files in the book path under the database directory (relative to web or absolute)
        $bookPath = dirname($this->dbConnArgs['databaseName']) . '/' . $this->properties['path']->value;
        if (!is_dir($bookPath)) {
            return '';
        }
        return $bookPath;
    }

    /**
     * Summary of cover
     * @param array<string, mixed> $args
     * @return mixed
     */
    public function cover(array $args = [])
    {
        $itemid = $this->getItem($args);
        if (empty($itemid)) {
            return $this->ctl()->notFound('Invalid book');
        }
        $filePath = $this->getCoverPath();
        if (empty($filePath)) {
            return $this->ctl()->notFound('Invalid cover');
        }
        // @todo handle file paths when not directly accessible, e.g. via images module
        header('Content-Type: image/jpeg');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        $this->exit();
    }

    /**
     * Summary of getCoverPath
     * @throws EmptyParameterException
     * @return string|null
     */
    public function getCoverPath()
    {
        // did we get a book - call getItem() first
        if (empty($this->itemid)) {
            throw new EmptyParameterException('itemid');
        }
        // does this book have a cover (yes/no)
        if (empty($this->properties['has_cover']?->value)) {
            return null;
        }
        // does this book have a book path
        $this->bookPath ??= $this->getBookPath();
        if (empty($this->bookPath)) {
            return null;
        }
        // can we access the 'cover.jpg' file in the book path under the database directory (relative to web or absolute)
        $filePath = $this->bookPath . '/' . self::COVER;
        if (!file_exists($filePath)) {
            return null;
        }
        return $filePath;
    }

    /**
     * Summary of getCoverURL
     * @return string
     */
    public function getCoverURL()
    {
        $filePath = $this->getCoverPath();
        if (empty($filePath)) {
            return '';
        }

        // Turn relative path into an absolute URL
        $webDir = sys::web();
        if (!empty($webDir) && strpos($filePath, $webDir) === 0) {
            $filePath = substr($filePath, strlen($webDir));
        } elseif (str_starts_with($filePath, '/') || str_contains($filePath, ':')) {
            // handle file paths when not directly accessible, e.g. via images module
            return $this->getActionURL('cover', $this->itemid);
        }

        // URL-encode file path
        $filePath = implode('/', array_map('rawurlencode', explode('/', $filePath)));
        $filePath = $this->ctl()->getBaseURL() . $filePath;

        return $filePath;
    }

    /**
     * Summary of format
     * @param array<string, mixed> $args
     * @return mixed
     */
    public function format(array $args = [])
    {
        $itemid = $this->getItem($args);
        if (empty($itemid)) {
            return $this->ctl()->notFound('Invalid book');
        }
        if (empty($args['format'])) {
            return $this->ctl()->notFound('Missing format');
        }
        $filePath = $this->getFormatPath($args['format']);
        if (empty($filePath)) {
            return $this->ctl()->notFound('Invalid format');
        }
        $isLoggedIn = $this->user()->isLoggedIn();
        // only logged-in users can download books here
        if (!$isLoggedIn) {
            return $this->ctl()->forbidden('Invalid user');
        }
        // handle file paths when not directly accessible
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimetype = self::$mimetypes[$ext] ?? 'application/octet-stream';
        header('Content-Type: ' . $mimetype);
        header('Content-Length: ' . filesize($filePath));
        $fileName = str_replace('"', '\\"', basename($filePath));
        header('Content-Disposition: attachment; filename="' . $fileName . '";');
        readfile($filePath);
        $this->exit();
    }

    /**
     * Summary of getFormatPath
     * @param string $format
     * @return string|null
     */
    public function getFormatPath($format = 'epub')
    {
        $found = $this->findFormats();
        if (empty($found) || empty($found[$format])) {
            return null;
        }
        return $found[$format];
    }

    /**
     * Summary of getFormatURL
     * @param string $format
     * @param ?string $filePath
     * @return string
     */
    public function getFormatURL($format = 'epub', $filePath = null)
    {
        $filePath ??= $this->getFormatPath($format);
        if (empty($filePath)) {
            return '';
        }

        // Turn relative path into an absolute URL
        $webDir = sys::web();
        if (!empty($webDir) && strpos($filePath, $webDir) === 0) {
            $filePath = substr($filePath, strlen($webDir));
        } elseif (str_starts_with($filePath, '/') || str_contains($filePath, ':')) {
            // handle file paths when not directly accessible
            return $this->getActionURL('format', $this->itemid, ['format' => $format]);
        }

        // URL-encode file path
        $filePath = implode('/', array_map('rawurlencode', explode('/', $filePath)));
        $filePath = $this->ctl()->getBaseURL() . $filePath;

        return $filePath;
    }
}

class LibraryBookList extends LibraryObjectList
{
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
            $this->action_urls['action'] = $this->getActionURL('action', '1234567890');
            //$this->action_urls['cover'] = $this->getActionURL('cover', '1234567890');
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
        $options['action'] = [
            'otitle' => $this->ml('Action'),
            'oicon'  => 'go-next.png',
            'olink'  => str_replace('1234567890', $itemid, $this->action_urls['action']),
            'ojoin'  => '',
        ];
        /**
        $options['cover'] = [
            'otitle' => $this->ml('Cover'),
            'oicon'  => 'move.png',
            'olink'  => str_replace('1234567890', $itemid, $this->action_urls['cover']),
            'ojoin'  => '',
        ];
         */
        return $options;
    }
}
