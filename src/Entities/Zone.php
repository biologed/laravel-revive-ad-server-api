<?php

namespace Biologed\Revive\Entities;

/**
 *  The Zone class extends the base Entity class and contains information about the zone.
 */
class Zone extends Entity
{
    /**
     * The zoneId variable is the unique ID for the zone.
     */
    public int $zoneId;
    /**
     * The publisherID is the ID of the publisher associated with the zone.
     *
     * @public integer $publisherId
     */
    public int $publisherId;
    /**
     * The zoneName is the name of the zone.
     */
    public string $zoneName;
    /**
     * The type variable type of zone, one of the following: banner, interstitial, popup, text, email.
     */
    public int $type;
    /**
     * The width variable is the width of the zone.
     */
    public int $width;
    /**
     * The height variable is the height of the zone.
     */
    public int $height;
    /**
     * Frequency capping: total views per user.
     */
    public int $capping;
    /**
     * Frequency capping: total views per period.
     * (defined in seconds by “block”).
     */
    public int $sessionCapping;
    /**
     * Frequency capping: reset period, in seconds.
     */
    public int $block;
    /**
     * This field provides any additional comments to be stored.
     */
    public string $comments;
    /**
     * The appended code for this zone.
     */
    public string $append;
    /**
     * The prepended code of the zone.
     */
    public string $prepend;
    /**
     * The chained zone of the current zone.
     */
    public int $chainedZoneId;
    /**
     * This method sets all default values when adding a new zone.
     */
    public function setDefaultForAdd(): void
    {
        if (is_null($this->type)) {
            $this->type = 0;
        }
        if (is_null($this->width)) {
            $this->width = 0;
        }
        if (is_null($this->height)) {
            $this->height = 0;
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
        if (is_null($this->chainedZoneId)) {
            // Leave null
        }*/
    }
    /**
     * This method returns an array of fields with their corresponding types.
     * @see Entity::getFieldsTypes
     */
    public function getFieldsTypes(): array
    {
        return [
            'zoneId' => 'integer',
            'publisherId' => 'integer',
            'zoneName' => 'string',
            'type' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
            'capping' => 'integer',
            'sessionCapping' => 'integer',
            'block' => 'integer',
            'comments' => 'string',
            'append' => 'string',
            'prepend' => 'string',
            'chainedZoneId' => 'integer',
        ];
    }
}
