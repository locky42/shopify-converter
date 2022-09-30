<?php

namespace app\helpers;

class SeoMeta
{
    const KEY_MODEL = 'StoneNo';

    /**
     * @param array $fileKeys
     * @param array $originalProduct
     * @param int $seoTitleId
     * @return mixed|string
     */
    public static function generateTitle(array $fileKeys, array $originalProduct, int $seoTitleId)
    {
        return $originalProduct[$seoTitleId] ? : 'Shop Diamond ' . self::getModelName($fileKeys, $originalProduct) . ' | Luxury Diamonds';
    }

    /**
     * @param array $fileKeys
     * @param array $originalProduct
     * @param int $seoDescriptionId
     * @return mixed|string
     */
    public static function generateDescription(array $fileKeys, array $originalProduct, int $seoDescriptionId)
    {
        return $originalProduct[$seoDescriptionId] ? : 'Buy Diamond ' . self::getModelName($fileKeys, $originalProduct) . ' Online in Vancouver Canada.';
    }

    /**
     * @param array $fileKeys
     * @param array $originalProduct
     * @return mixed
     */
    public static function getModelName(array $fileKeys, array $originalProduct)
    {
        $idModel= ArrayHelper::getValueId($fileKeys, self::KEY_MODEL);
        return $originalProduct[$idModel];
    }
}
