<?php

namespace Camaleao\Bimgo\CoreBundle\Service;

class TextHelper
{
    /**
     * Transform any text in url friendly format.
     */
    public static function urlFriendly($text, $delimiter = '-')
    {
        setlocale(LC_CTYPE, 'en_US.UTF-8');

        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', $delimiter, $text);

        // trim
        $text = trim($text, $delimiter);

        // transliterate
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        return $text;
    }
}