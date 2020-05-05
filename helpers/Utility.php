<?php

namespace app\helpers;


/**
 * Clase auxiliar
 */
class Utility
{
    public static function media($array)
    {
        $array = array_filter($array);
        return array_sum($array) / count($array);
    }
    public static function moda($array)
    {
        $values = array_count_values($array);
        return  array_search(max($values), $values);
    }
}
