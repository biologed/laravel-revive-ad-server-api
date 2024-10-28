<?php

namespace Biologed\Revive\Entities;

use PhpXmlRpc\Value;

/**
 *  The Banner class extends the base Entity class and contains information about the banner.
 */
class Banner extends Entity
{
    /**
     * The bannerID variable is the unique ID of the banner.
     */
    public int $bannerId;
    /**
     * The campaignID variable is the ID of the campaign associated with the banner.
     */
    public int $campaignId;
    /**
     * The bannerName variable is the name of the banner.
     */
    public int $bannerName;
    /**
     * The storageType variable is one of the following: 'sql','web','url','html',,'txt'.
     */
    public string $storageType;
    /**
     * The imageURL variable is the URL for an image file for network banners.
     */
    public string $imageURL;
    /**
     * The htmlTemplate variable is the HTML template for HTML banners.
     */
    public string $htmlTemplate;
    /**
     * The width variable contains the width of a banner.
     */
    public int $width;
    /**
     * The height variable contains the height of the banner.
     */
    public int $height;
    /**
     * This field provides the priority weight of the banner.
     */
    public int $weight;
    /**
     * This field provides the HTML target of the banner (e.g. _blank, _self)
     */
    public string $target;
    /**
     * The url variable is the destination URL of the banner.
     */
    public string $url;
    /**
     * This field provides the Text value of the text banner.
     */
    public string $bannerText;
    /**
     * A boolean field to indicate if the banner is active
     */
    public int $status;
    /**
     * A text field for HTML banners to indicate which adserver this ad is from
     */
    public string $adserver;
    /**
     * This field provides transparency information for SWF banners
     */
    public bool $transparent;
    /**
     * Frequency capping: total views per user.
     */
    public int $capping;
    /**
     * Frequency capping: total views per period.
     * (defined in seconds by "block").
     */
    public int $sessionCapping;
    /**
     * Frequency capping: reset period, in seconds.
     */
    public int $block;
    /**
     * An array field for SQL/Web banners to contain the image name and binary data
     * [filename] => banner.swf
     * [content]  => {binarydata}
     * [editswf]  => true
     * If the editswf member is present and true, any SWF files will be scanned for hardcoded
     * links and eventually converted
     */
    public array $image;
    /**
     * An array field for SQL/Web banners to contain the backup image name and binary data
     * in case the primary image is a swf file
     * [filename] => banner.gif
     * [content] => {binarydata}
     */
    public array $backupImage;
    /**
     * This field provides any additional comments to be stored.
     */
    public string $comments;
    /**
     * This field provides the alt value for SQL/Web/External banners.
     */
    public string $alt;
    /**
     * This field provides the filename of the banner.
     */
    public string $filename;
    /**
     * This method sets all default values when adding a new banner.
     */
    public function setDefaultForAdd(): void
    {
        if (is_null($this->storageType)) {
            $this->storageType = 'sql';
        }
        if (is_null($this->width)) {
            $this->width = 0;
        }
        if (is_null($this->height)) {
            $this->height = 0;
        }
        if (is_null($this->weight)) {
            $this->weight = 1;
        }
        if (is_null($this->status)) {
            $this->status = 0;
        }
        if (!isset($this->transparent)) {
            $this->transparent = false;
        }
        /*
        if (is_null($this->capping)) {
            // Leave null
        }
        if (is_null($this->sessionCapping)) {
            // Leave null
        }
        if (is_null($this->block)) {
            // Leave null
        }
        */
    }
    public function toArray(): array
    {
        $array = parent::toArray();
        if (isset($this->image)) {
            $array['image'] = $this->encodeImage($this->image);
        }
        if (isset($this->backupImage)) {
            $array['backupImage'] = $this->encodeImage($this->backupImage);
        }
        return $array;
    }
    public function encodeImage($image): Value
    {
        return new Value([
            'filename' => new Value($image['filename']),
            'content' => new Value($image['content'], 'base64'),
            'editswf' => new Value(! empty($image['editswf']), 'boolean'),
        ], 'struct');
    }
    /**
     * This method returns an array of fields with their corresponding types.
     * @see Entity::getFieldsTypes
     */
    public function getFieldsTypes(): array
    {
        return [
            'bannerId' => 'integer',
            'campaignId' => 'integer',
            'bannerName' => 'string',
            'storageType' => 'string',
            'imageURL' => 'string',
            'htmlTemplate' => 'string',
            'width' => 'integer',
            'height' => 'integer',
            'weight' => 'integer',
            'target' => 'string',
            'url' => 'string',
            'bannerText' => 'string',
            'status' => 'integer',
            'adserver' => 'string',
            'transparent' => 'integer',
            'capping' => 'integer',
            'sessionCapping' => 'integer',
            'block' => 'integer',
            'image' => 'custom',
            'backupImage' => 'custom',
            'comments' => 'string',
            'alt' => 'string',
            'filename' => 'string',
            'append' => 'string',
            'prepend' => 'string',
        ];
    }
}
