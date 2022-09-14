<?php

namespace app\helpers;

class ArrayHelper
{
    /**
     * @param array|null $array
     * @return array
     */
    public static function arrayFlat(?array $array): array
    {
        $data = [];
        if ($array) {
            foreach ($array as $item) {
                if (is_array($item)) {
                    $data = array_merge($data, self::arrayFlat($item));
                } else {
                    $data[] = $item;
                }
            }
        }

        return $data;
    }
}
