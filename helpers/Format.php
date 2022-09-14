<?php

namespace app\helpers;

class Format
{
    /**
     * @param string $sku
     * @return string
     */
    public static function skuFormat(string $sku): string
    {
        return str_replace('/', '-', $sku);
    }

    /**
     * @param string $handle
     * @return string
     */
    public static function handleFormat(string $handle): string
    {
        return strtolower(self::skuFormat($handle));
    }
}
