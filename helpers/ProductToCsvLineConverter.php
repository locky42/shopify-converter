<?php

namespace app\helpers;

use app\models\Option;

class ProductToCsvLineConverter
{
    /**
     * @param $product
     * @return array
     */
    public static function toCsvLine($product): array
    {
        $product = $product->toArray();
        $product = self::optionsToArray($product, 3);
        $product = self::getProductFiledToArray($product, 'googleShopping_CustomLabels', 5);
        $product['tags'] = implode(',', $product['tags']) ? : null;
        return $product;
    }

    protected static function optionsToArray(array $product, ?int $count = null)
    {
        $keyId = array_search('options', array_keys($product), true);
        $part1 = array_slice($product, 0, $keyId, true);
        $part2 = array_slice($product, ++$keyId, null, true);

        $options = [];
        foreach ($product['options'] as $option) {
            if ($option['value']) {
                $options[] = $option;
            } else {
                $emptyOption = new Option();
                $options[] = $emptyOption->toArray();
            }
        }

        $data = ArrayHelper::arrayFlat($options);

        if ($count && count($product['options']) < $count) {
            $dataRangeSize = $count - count($product['options']);
            $arrayFullSize = (count(ArrayHelper::arrayFlat(array_shift($product['options']))) ? : 1);
            $dataRange = array_fill(0, $dataRangeSize * $arrayFullSize, null);
            $data = array_merge($data, $dataRange);
        }

        return array_merge($part1, $data, $part2);
    }

    /**
     * @param array $product
     * @param string $key
     * @param int|null $count
     * @return array
     */
    protected static function getProductFiledToArray(array $product, string $key, ?int $count = null): array
    {
        $keyId = array_search($key, array_keys($product), true);
        $part1 = array_slice($product, 0, $keyId, true);
        $part2 = array_slice($product, ++$keyId, null, true);
        $data = ArrayHelper::arrayFlat($product[$key]);

        if ($count && count($product[$key]) < $count) {
            $dataRangeSize = $count - count($product[$key]);
            $arrayFullSize = (count(ArrayHelper::arrayFlat(array_shift($product[$key]))) ? : 1);
            $dataRange = array_fill(0, $dataRangeSize * $arrayFullSize, null);
            $data = array_merge($data, $dataRange);
        }

        return array_merge($part1, $data, $part2);
    }
}
