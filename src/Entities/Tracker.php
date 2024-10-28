<?php

namespace Biologed\Revive\Entities;

/**
 * The Tracker class extends the base Entity class and contains information about tracker
 */
class Tracker extends Entity
{
    /**
     * The trackerId variable is the unique ID for the tracker.
     */
    public int $trackerId;
    /**
     * The clientId variable is the unique ID for the owner client.
     */
    public int $clientId;
    /**
     * The trackerName variable is the name of the tracker.
     */
    public string $trackerName;
    /**
     * This field provides a place for a description to be stored.
     */
    public string $description;
    /**
     * This field provides an optional connection status type if no status given, uses the tracker's default status.
     *     MAX_CONNECTION_STATUS_IGNORE: 1
     *     MAX_CONNECTION_STATUS_PENDING: 2
     *     MAX_CONNECTION_STATUS_ONHOLD: 3
     *     MAX_CONNECTION_STATUS_APPROVED: 4
     *     MAX_CONNECTION_STATUS_DISAPPROVED: 5
     *     MAX_CONNECTION_STATUS_DUPLICATE: 6
     */
    public string $status;
    /**
     * The type variable is the id of the type of tracker.
     *     SALE: 1
     *     LEAD: 2
     *     SIGNUP: 3
     */
    public int $type;
    /**
     * This field is a boolean true on successful link, false on error.
     */
    public int $linkCampaigns;
    /**
     * The variableMethod variable is the method of the tracker.
     * 'default','js','dom','custom'
     */
    public string $variableMethod;
    /**
     * This method returns an array of fields with their corresponding types.
     * @see Entity::getFieldsTypes
     */
    public function getFieldsTypes(): array
    {
        return [
            'trackerId' => 'integer',
            'clientId' => 'integer',
            'trackerName' => 'string',
            'description' => 'string',
            'status' => 'integer',
            'type' => 'integer',
            'linkCampaigns' => 'boolean',
            'variableMethod' => 'string',
        ];
    }
}
