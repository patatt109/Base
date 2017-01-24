<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company HashStudio
 * @site http://hashstudio.ru
 * @date 08/09/16 07:25
 */

namespace Modules\Base\TemplateLibraries;

use Phact\Main\Phact;
use Phact\Pagination\Pagination;
use Phact\Template\Renderer;
use Phact\Template\TemplateLibrary;

class CommonLibrary extends TemplateLibrary
{
    use Renderer;

    /**
     * @name render_breadcrumbs
     * @kind function
     * @return string
     */
    public static function renderBreadcrumbs($params)
    {
        $template = isset($params['template']) ? $params['template'] : '_breadcrumbs.tpl';
        $name = isset($params['name']) ? $params['name'] : 'DEFAULT';

        return self::renderTemplate($template, [
            'breadcrumbs' => Phact::app()->breadcrumbs->get($name)
        ]);
    }

    /**
     * @name render_flash
     * @kind function
     * @return string
     */
    public static function renderFlash($params)
    {
        $template = isset($params['template']) ? $params['template'] : '_flash.tpl';

        return self::renderTemplate($template, [
            'messages' => Phact::app()->flash->read()
        ]);
    }

    /**
     * @name build_url
     * @kind function
     * @return string
     */
    public static function buildUrl($params)
    {
        $data = isset($params['data']) ? $params['data'] : [];
        $query = Phact::app()->request->getQueryArray();
        foreach ($data as $key => $value) {
            $query[$key] = $value;
        }
        return Phact::app()->request->getPath() . '?' . http_build_query($query);
    }

    /**
     * @name pager
     * @kind accessorFunction
     * @return Pagination
     */
    public static function pager($provider, $options = [])
    {
        return new Pagination($provider, $options);
    }
}