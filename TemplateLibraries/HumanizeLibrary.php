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

use Phact\Template\TemplateLibrary;

class HumanizeLibrary extends TemplateLibrary
{
    /**
     * @name humanize_size
     * @kind modifier
     * @return string
     */
    public static function humanizeSize($size)
    {
        if ($size < 1024) {
            $converted = $size;
            $message = ' Б';
        } elseif ($size < pow(1024, 2)) {
            $converted = round($size / 1024);
            $message = ' Кб';
        } elseif ($size < pow(1024, 3)) {
            $converted = round($size / pow(1024, 2));
            $message = ' Мб';
        } elseif ($size < pow(1024, 4)) {
            $converted = round($size / pow(1024, 3));
            $message = ' Гб';
        } else {
            $converted = round($size / pow(1024, 4));
            $message = ' Тб';
        }
        return $converted . $message;
    }
}