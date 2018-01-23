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

use DirectoryIterator;
use Phact\Helpers\Paths;
use Phact\Template\Renderer;
use Phact\Template\TemplateLibrary;

class StaticLibrary extends TemplateLibrary
{
    use Renderer;

    /**
     * @kind accessorFunction
     * @name frontend_css_file
     * @return string|null
     */
    public static function getFrontendCssFile($name)
    {
        return self::getStaticFile('static.frontend.dist.css', $name);
    }

    /**
     * @kind accessorFunction
     * @name frontend_js_file
     * @return string|null
     */
    public static function getFrontendJsFile($name)
    {
        return self::getStaticFile('static.frontend.dist.js', $name);
    }

    /**
     * @kind accessorFunction
     * @name backend_css_file
     * @return string|null
     */
    public static function getBackendCssFile($name)
    {
        return self::getStaticFile('static.backend.dist.css', $name);
    }

    /**
     * @kind accessorFunction
     * @name backend_js_file
     * @return string|null
     */
    public static function getBackendJsFile($name)
    {
        return self::getStaticFile('static.backend.dist.js', $name);
    }

    /**
     * @kind accessorFunction
     * @name static_file
     * @return string|null
     */
    public static function getStaticFile($path, $name)
    {
        return self::getFileName(Paths::get($path), $name);
    }

    public static function getFileName($dir, $name)
    {
        $dir = new DirectoryIterator($dir);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $filename = $fileinfo->getFilename();
                $cleanName = mb_substr($filename, 0, mb_strrpos($filename, '-', null, 'UTF-8'), 'UTF-8');
                $rawName = mb_substr($filename, 0, mb_strrpos($filename, '.', null, 'UTF-8'), 'UTF-8');
                if ($cleanName == $name || $rawName == $name) {
                    return $fileinfo->getFilename();
                }
            }
        }
        return null;
    }
}