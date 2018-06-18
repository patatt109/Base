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

use Phact\Helpers\Paths;
use Phact\Main\Phact;
use Phact\Pagination\Pagination;
use Phact\Template\Renderer;
use Phact\Template\TemplateLibrary;

class CommonLibrary extends TemplateLibrary
{
    use Renderer;

    /**
     * Render breadcrumbs list
     *
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
     * Render flash messages
     *
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
     * Render icon by template
     *
     * @name icon
     * @kind function
     * @return string
     */
    public static function icon($params)
    {
        $name = isset($params[0]) ? $params[0] : '';
        $template = isset($params[1]) ? $params[1] : 'base/_icon.tpl';
        return self::renderTemplate($template, [
            'name' => $name
        ]);
    }

    /**
     * Insert svg icon
     *
     * @name svg_icon
     * @kind function
     * @return string
     */
    public static function svgIcon($params)
    {
        $name = isset($params[0]) ? $params[0] : '';
        $path = isset($params[1]) ? $params[1] : 'www.static.frontend.svg';
        $iconPath = Paths::file("{$path}.{$name}", ['svg']);
        if ($iconPath) {
            $info = file_get_contents($iconPath);
            return preg_replace('/<\?.*?\?>/', '', $info);
        }
        return "";
    }

    /**
     * Build current url with required GET parameters
     *
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
     * Creates pager
     *
     * @name pager
     * @kind accessorFunction
     * @return Pagination
     */
    public static function pager($provider, $options = [])
    {
        return new Pagination($provider, $options);
    }

    /**
     * Check debug mode
     *
     * @name is_debug
     * @kind accessorProperty
     * @return bool
     */
    public static function isDebug()
    {
        return defined('PHACT_DEBUG') && PHACT_DEBUG;
    }
}