<?php

/**
 * Library Action Controller class
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

use xarRequest;
use ShortActionController;

/**
 * Use entity and action to avoid conflict with module & func or object & method
 *
 * Supported URLs :
 *
 * /library/
 * /library/admin/... (not used here)
 * /library/{entity}/
 * /library/{entity}/{itemid} (numeric)
 * /library/{entity}/{itemid}/{title}
 * /library/{entity}/{action} (non-numeric)
 * /library/{entity}/{action}/{itemid}
**/
class LibraryShortController extends ShortActionController
{
    public function decode(array $data = []): array
    {
        $token1 = $this->firstToken();
        switch ((string) $token1) {
            case 'admin':
                return parent::decode($data);
            case '':
                $data['type'] = 'user';
                $data['func'] = 'main';
                break;
            default:
                $data['type'] = 'user';
                $data['func'] = 'view';
                $data['entity'] = $token1;
                $token2 = $this->nextToken();
                if (empty($token2)) {
                    $data['action'] = 'view';
                } elseif (!is_numeric($token2)) {
                    $data['action'] = $token2;
                    $token3 = $this->nextToken();
                    if (!empty($token3)) {
                        $data['itemid'] = $token3;
                    }
                } else {
                    $data['action'] = 'display';
                    $data['itemid'] = $token2;
                }
                break;
        }
        return $data;
    }

    public function encode(xarRequest $request): string
    {
        if (!in_array($request->getType(), ['user'])) {
            return parent::encode($request);
        }
        if (!in_array($request->getFunction(), ['main', 'view'])) {
            return parent::encode($request);
        }

        $params = $request->getFunctionArgs();
        $path = [];
        if (empty($params['entity'])) {
            $path[] = '';
        } else {
            $path[] = $params['entity'];
            unset($params['entity']);
            if (!empty($params['itemid'])) {
                if (empty($params['action']) || $params['action'] == 'display') {
                    unset($params['action']);
                    $path[] = $params['itemid'];
                    unset($params['itemid']);
                    if (!empty($params['title'])) {
                        // @todo assume already slugified
                        $path[] = $params['title'];
                        unset($params['title']);
                    }
                } else {
                    $path[] = $params['action'];
                    unset($params['action']);
                    $path[] = $params['itemid'];
                    unset($params['itemid']);
                }
            } elseif (empty($params['action']) || $params['action'] == 'view') {
                unset($params['action']);
            } else {
                $path[] = $params['action'];
                unset($params['action']);
            }
        }

        // Encode the processed params
        $request->setFunction($this->getFunction($path));

        // Send the unprocessed params back
        $request->setFunctionArgs($params);
        return parent::encode($request);
    }
}
