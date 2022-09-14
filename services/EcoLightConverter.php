<?php

namespace app\services;

use Yii;
use Exception;
use app\helpers\File;
use app\helpers\CsvReader;
use app\helpers\CsvWriter;
use app\helpers\Format;
use app\helpers\ProductToCsvLineConverter;
use app\helpers\EcoLightCsvColumns;
use app\models\ShopifyProduct;
use app\models\Option;

class EcoLightConverter
{
    const ID_PRICE = 10;
    const ID_IMG = 12;
    const ID_SKU = 0;
    const ID_WEIGHT = 3;
    const ID_TITLE = 0;
    const ID_COLLECTION = 2;

    const ID_OPTION_1 = 4;
    const ID_OPTION_2 = 5;
    const ID_OPTION_3 = 19;

    const VENDOR = 'EcoLight';
    const PRODUCT_TYPE = 'EcoLight';

    protected array $fileData = [];
    protected array $fileKeys = [];

    protected $csvWriter;

    /**
     * @throws Exception
     */
    public function __construct(string $filename)
    {
        $csvReader = new CsvReader(File::getFilePath($filename));
        $this->csvWriter = new CsvWriter(File::FILES_DIR, EcoLightCsvColumns::COLUMNS);
        $data = $csvReader->read();
        $this->fileKeys = array_shift($data);
        $this->fileData = $data;
    }

    public function convert()
    {
        $products = $this->getProducts(1);
        $productsToCsv = [];
        foreach ($products as $product) {
            $productsToCsv[] = ProductToCsvLineConverter::toCsvLine($product);
        }

        $this->csvWriter
            ->setData($productsToCsv)
            ->write();
        return Yii::$app->response->sendFile($this->csvWriter->getFilePath());
    }

    /**
     * @param int|null $count
     * @return array
     */
    protected function getProducts(?int $count = null): array
    {
        $products = [];
        foreach ($this->fileData as $iteration => $importProduct) {
            if ($count && $iteration >= $count) {
                break;
            }

            $product = new ShopifyProduct;

            $product
                ->setHandle(Format::handleFormat($importProduct[self::ID_TITLE]))
                ->setTitle($importProduct[self::ID_TITLE])
                ->setVariantPrice($importProduct[self::ID_PRICE])
                ->setImageSrc($importProduct[self::ID_IMG])
                ->setImageAltText($importProduct[self::ID_TITLE])
                ->setVariantSku(Format::skuFormat($importProduct[self::ID_SKU]))
                ->setVariantGrams((float) $importProduct[self::ID_WEIGHT])
                ->setVendor(self::VENDOR)
                ->setCollection($importProduct[self::ID_COLLECTION])
                ->setCustomProductType(self::PRODUCT_TYPE)
                ->setOptions($this->generateOptions($importProduct));
            $products[] = $product;
        }

        return $products;
    }

    /**
     * @param $product
     * @return array
     */
    protected function generateOptions($product): array
    {
        $options = [];

        $option = new Option;
        $option
            ->setName($this->fileKeys[self::ID_OPTION_1])
            ->setValue($product[self::ID_OPTION_1]);
        $options[] = $option;

        $option = new Option;
        $option
            ->setName($this->fileKeys[self::ID_OPTION_2])
            ->setValue($product[self::ID_OPTION_2]);
        $options[] = $option;

        $option = new Option;
        $option
            ->setName($this->fileKeys[self::ID_OPTION_3])
            ->setValue($product[self::ID_OPTION_3]);
        $options[] = $option;

        return $options;
    }
}
