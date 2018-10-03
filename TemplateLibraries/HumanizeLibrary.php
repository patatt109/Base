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

    /**
     * @name plural
     * @kind modifier
     * @return string
     */
    public static function plural($forms, $num)
    {
        $forms = explode('|', $forms);
        if ($num == 0) {
            return $forms[2];
        }

        $value = $num % 100;

        if ($value == 0) {
            return $forms[2];
        }

        if ($value > 10 && $value < 20)
            return $forms[2];
        else
        {
            $value = $num % 10;
            if ($value == 1)
                return $forms[0];
            else if ($value > 1 && $value < 5)
                return $forms[1];
            else
                return $forms[2];
        }
    }
}