<?php

namespace app\models;

use app\helpers\Format;
use yii\base\Model;

class ShopifyProduct extends Model
{
    const DEFAULT_PUBLISHED = true;

    public ?string $handle = null;
    public ?string $title = null;
    public ?string $bodyHtml = null;
    public ?string $vendor = null;
    public ?string $standardizedProductType = null;
    public ?string $customProductType = null;
    public array $tags = [];
    public bool $published = self::DEFAULT_PUBLISHED;
    /** @var array */
    public array $options = [];
    public string $variantSku = '';
    public $variantGrams = '0.00';
    public string $variantInventoryTracker = 'shopify';
    public int $variantInventoryQty = 1;
    public string $variantInventoryPolicy = 'continue';
    public string $variantFulfillmentService = 'manual';
    public $variantPrice = '0.00';
    public ?string $variantCompareAtPrice = null;
    public bool $variantRequiresShipping = true;
    public bool $variantTaxable = true;
    public ?string $variantBarcode = null;
    public ?string $imageSrc = null;
    public int $imagePosition = 1;
    public ?string $imageAltText = null;
    public bool $giftCard = false;
    public ?string $seoTitle = null;
    public ?string $seoDescription = null;
    public $googleShopping_GoogleProductCategory = null;
    public $googleShopping_Gender = null;
    public $googleShopping_AgeGroup = null;
    public $googleShopping_MPN = null;
    public $googleShopping_AdWordsGrouping = null;
    public $googleShopping_AdWordsLabels = null;
    public $googleShopping_Condition = null;
    public $googleShopping_CustomProduct = null;
    /** @var array|string[] */
    public array $googleShopping_CustomLabels = [];
    public ?string $variantImage = null;
    /** @var string */
    public string $variantWeightUnit = 'g';
    public $variantTaxCode = null;
    public ?float $costPerItem = null;
    public string $status = 'active';
    public ?string $collection = null;

    public function setHandle($handle): self
    {
        $this->handle = $handle;
        return $this;
    }

    public function setTitle($title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setBodyHtml($bodyHtml): self
    {
        if ($this->bodyHtml) {
            $this->bodyHtml .= $bodyHtml;
        } else {
            $this->bodyHtml = $bodyHtml;
        }
        return $this;
    }

    public function setArrayJsonHtml(array $data): self
    {
        $html = '<script>';
        $html .= 'product_data = ' . json_encode($data) . ';';
        $html .= '</script>';
        $this->setBodyHtml($html);
        return $this;
    }

    public function setVendor($vendor): self
    {
        $this->vendor = $vendor;
        return $this;
    }

    public function setStandardizedProductType($standardizedProductType): self
    {
        $this->standardizedProductType = $standardizedProductType;
        return $this;
    }

    public function setCustomProductType($customProductType): self
    {
        $this->customProductType = $customProductType;
        return $this;
    }

    public function setTags($tags): self
    {
        $this->tags = $tags;
        return $this;
    }

    public function setTag(string $tag): self
    {
        $this->tags[] = $tag;
        return $this;
    }

    public function setPublished($published): self
    {
        $this->published = $published;
        return $this;
    }

    public function setOptions($options): self
    {
        $this->options = $options;
        return $this;
    }

    public function setVariantSku($variantSku): self
    {
        $this->variantSku = $variantSku;
        return $this;
    }

    public function setVariantGrams($variantGrams): self
    {
        $this->variantGrams = number_format($variantGrams, 2, '.', '');
        return $this;
    }

    public function setVariantInventoryTracker($variantInventoryTracker): self
    {
        $this->variantInventoryTracker = $variantInventoryTracker;
        return $this;
    }

    public function setVariantInventoryQty($variantInventoryQty): self
    {
        $this->variantInventoryQty = $variantInventoryQty;
        return $this;
    }

    public function setVariantInventoryPolicy($variantInventoryPolicy): self
    {
        $this->variantInventoryPolicy = $variantInventoryPolicy;
        return $this;
    }

    public function setVariantFulfillmentService($variantFulfillmentService): self
    {
        $this->variantFulfillmentService = $variantFulfillmentService;
        return $this;
    }

    public function setVariantPrice($variantPrice): self
    {
        $this->variantPrice = number_format(Format::toFloat($variantPrice), 2, '.', '');
        return $this;
    }

    public function setVariantCompareAtPrice($variantCompareAtPrice): self
    {
        $this->variantCompareAtPrice = $variantCompareAtPrice;
        return $this;
    }

    public function setImageSrc($imageSrc): self
    {
        $this->imageSrc = $imageSrc;
        return $this;
    }

    public function setImagePosition($imagePosition): self
    {
        $this->imagePosition = $imagePosition;
        return $this;
    }

    public function setImageAltText($imageAltText): self
    {
        $this->imageAltText = $imageAltText;
        return $this;
    }

    public function setGiftCard($giftCard): self
    {
        $this->giftCard = $giftCard;
        return $this;
    }

    public function setSeoTitle($seoTitle): self
    {
        $this->seoTitle = $seoTitle;
        return $this;
    }

    public function setSeoDescription($seoDescription): self
    {
        $this->seoDescription = $seoDescription;
        return $this;
    }

    public function setVariantImage($variantImage): self
    {
        $this->variantImage = $variantImage;
        return $this;
    }

    public function setVariantWeightUnit($variantWeightUnit): self
    {
        $this->variantWeightUnit = $variantWeightUnit;
        return $this;
    }

    public function setVariantTaxCode($variantTaxCode): self
    {
        $this->variantTaxCode = $variantTaxCode;
        return $this;
    }

    public function setCostPerItem($costPerItem): self
    {
        $this->costPerItem = $costPerItem;
        return $this;
    }

    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    public function setCollection(?string $collection = null): self
    {
        $this->collection = $collection;
        return $this;
    }
}
