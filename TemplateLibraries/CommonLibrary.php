<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @date 08/09/16 07:25
 */

namespace Modules\Base\TemplateLibraries;

use Phact\Components\BreadcrumbsInterface;
use Phact\Components\FlashInterface;
use Phact\Components\PathInterface;
use Phact\Main\Phact;
use Phact\Pagination\Pagination;
use Phact\Request\HttpRequestInterface;
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

        /** @var BreadcrumbsInterface $breadcrumbs */
        $breadcrumbs = Phact::app()->getComponent(BreadcrumbsInterface::class);

        return self::renderTemplate($template, [
            'breadcrumbs' => $breadcrumbs->get($name)
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

        /** @var FlashInterface $flash */
        $flash = Phact::app()->getComponent(FlashInterface::class);

        return self::renderTemplate($template, [
            'messages' => $flash->read()
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
        /** @var PathInterface $paths */
        $paths = Phact::app()->getComponent(PathInterface::class);
        $iconPath = $paths->file("{$path}.{$name}", ['svg']);
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
        $request = Phact::app()->getComponent(HttpRequestInterface::class);
        $data = isset($params['data']) ? $params['data'] : [];
        $query = $request->getQueryArray();
        foreach ($data as $key => $value) {
            $query[$key] = $value;
        }
        return $request->getPath() . '?' . http_build_query($query);
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