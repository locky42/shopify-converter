<?php

namespace app\services;

use app\helpers\ArrayHelper;
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
    const KEY_PRICE = 'Total Price CAD';
    const KEY_IMG = 'Image Link';
    const KEY_VIDEO = 'Video Link';
    const KEY_CERTIFICATE = 'Certificate Url';
    const KEY_SKU = 'Stock #';
    const KEY_WEIGHT = 'Weight';
    const KEY_TITLE = 'Stock #';
    const KEY_COLLECTION = 'Shape';
    const KEY_DESCRIPTION = ' Diamond Details';
    const KEY_SEO_TITLE = ' Seo title';
    const KEY_SEO_DESCRIPTION = ' Seo description';

    const KEY_OPTION_1 = 'Clarity';
    const KEY_OPTION_2 = 'Color';
    const KEY_OPTION_3 = 'Cut Grade';

    const VENDOR = 'EcoLight';
    const PRODUCT_TYPE = 'EcoLight';

    protected array $fileData = [];
    protected array $fileKeys = [];

    protected ?int $idPrice;
    protected ?int $idImg;
    protected ?int $idVideo;
    protected ?int $idCertificate;
    protected ?int $idSku;
    protected ?int $idWeight;
    protected ?int $idTitle;
    protected ?int $idCollection;
    protected ?int $idDescription;
    protected ?int $idSeoTitle;
    protected ?int $idSeoDescription;

    protected ?int $idOption1;
    protected ?int $idOption2;
    protected ?int $idOption3;

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
        $this->setKeysIds();
    }

    protected function setKeysIds()
    {
        $this->idPrice = ArrayHelper::getValueId($this->fileKeys, self::KEY_PRICE);
        $this->idImg = ArrayHelper::getValueId($this->fileKeys, self::KEY_IMG);
        $this->idVideo = ArrayHelper::getValueId($this->fileKeys, self::KEY_VIDEO);
        $this->idCertificate = ArrayHelper::getValueId($this->fileKeys, self::KEY_CERTIFICATE);
        $this->idSku = ArrayHelper::getValueId($this->fileKeys, self::KEY_SKU);
        $this->idWeight = ArrayHelper::getValueId($this->fileKeys, self::KEY_WEIGHT);
        $this->idTitle = ArrayHelper::getValueId($this->fileKeys, self::KEY_TITLE);
        $this->idCollection = ArrayHelper::getValueId($this->fileKeys, self::KEY_COLLECTION);
        $this->idDescription = ArrayHelper::getValueId($this->fileKeys, self::KEY_DESCRIPTION);
        $this->idSeoTitle = ArrayHelper::getValueId($this->fileKeys, self::KEY_SEO_TITLE);
        $this->idSeoDescription = ArrayHelper::getValueId($this->fileKeys, self::KEY_SEO_DESCRIPTION);

        $this->idOption1 = ArrayHelper::getValueId($this->fileKeys, self::KEY_OPTION_1);
        $this->idOption2 = ArrayHelper::getValueId($this->fileKeys, self::KEY_OPTION_2);
        $this->idOption3 = ArrayHelper::getValueId($this->fileKeys, self::KEY_OPTION_3);
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
                ->setHandle(Format::handleFormat($importProduct[$this->idTitle]))
                ->setTitle($importProduct[$this->idTitle])
                ->setBodyHtml($importProduct[$this->idDescription])
                ->setArrayJsonHtml([
                    'product_3d_video' => $importProduct[$this->idVideo],
                    'product_certificate' => $importProduct[$this->idCertificate]
                ])
                ->setSeoTitle($importProduct[$this->idSeoTitle])
                ->setSeoDescription($importProduct[$this->idSeoDescription])
                ->setVariantPrice($importProduct[$this->idPrice])
                ->setImageSrc($importProduct[$this->idImg])
                ->setImageAltText($importProduct[$this->idTitle])
                ->setVariantSku(Format::skuFormat($importProduct[$this->idSku]))
                ->setVariantGrams((float) $importProduct[$this->idWeight])
                ->setVendor(self::VENDOR)
                ->setCollection($importProduct[$this->idCollection])
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
            ->setName($this->fileKeys[$this->idOption1])
            ->setValue($product[$this->idOption1]);
        $options[] = $option;

        $option = new Option;
        $option
            ->setName($this->fileKeys[$this->idOption2])
            ->setValue($product[$this->idOption2]);
        $options[] = $option;

        $option = new Option;
        $option
            ->setName($this->fileKeys[$this->idOption3])
            ->setValue($product[$this->idOption3]);
        $options[] = $option;

        return $options;
    }
}
