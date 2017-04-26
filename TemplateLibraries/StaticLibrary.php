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
use Phact\Template\TemplateLibrary;

class StaticLibrary extends TemplateLibrary
{

    protected static function getVersionFromContent($content)
    {
        $space = strpos($content, ' ');
        if ($space !== false) {
            return substr($content, 0, $space);
        }
        return null;
    }

    protected static function getVersion($file, $default = 1)
    {
        if (is_file($file) && ($content = file_get_contents($file)) && ($version = self::getVersionFromContent($content))) {
            return $version;
        }
        return $default;
    }

    /**
     * @kind function
     * @name frontend_css_version
     * @return int|void
     */
    public static function getFrontendCssVersion()
    {
        return self::getVersion(Paths::file('www.static.frontend.dist.css.version', 'yml'));
    }

    /**
     * @kind function
     * @name frontend_js_version
     * @return int|void
     */
    public static function getFrontendJsVersion()
    {
        return self::getVersion(Paths::file('www.static.frontend.dist.js.version', 'yml'));
    }

    /**
     * @kind function
     * @name backend_css_version
     * @return int|void
     */
    public static function getBackendCssVersion()
    {
        return self::getVersion(Paths::file('www.static.backend.dist.css.version', 'yml'));
    }

    /**
     * @kind function
     * @name backend_js_version
     * @return int|void
     */
    public static function getBackendJsVersion()
    {
        return self::getVersion(Paths::file('www.static.backend.dist.js.version', 'yml'));
    }
}