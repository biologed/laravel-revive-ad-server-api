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
    private int $zoneId;
    /**
     * The publisherID is the ID of the publisher associated with the zone.
     */
    private int $publisherId;
    /**
     * The zoneName is the name of the zone.
     */
    private string $zoneName;
    /**
     * The type variable type of zone, one of the following: banner, interstitial, popup, text, email.
     */
    private int $type;
    /**
     * The width variable is the width of the zone.
     */
    private int $width;
    /**
     * The height variable is the height of the zone.
     */
    private int $height;
    /**
     * Frequency capping: total views per user.
     */
    private  int $capping;
    /**
     * Frequency capping: total views per period.
     * (defined in seconds by “block”).
     */
    private int $sessionCapping;
    /**
     * Frequency capping: reset period, in seconds.
     */
    private int $block;
    /**
     * This field provides any additional comments to be stored.
     */
    private string $comments;
    /**
     * The appended code for this zone.
     */
    private string $append;
    /**
     * The prepended code of the zone.
     */
    private string $prepend;
    /**
     * The chained zone of the current zone.
     */
    private int $chainedZoneId;
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
