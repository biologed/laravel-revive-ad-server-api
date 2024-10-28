<?php

namespace Biologed\Revive\Entities;

/**
 *  The Publisher class extends the base Entity class and contains information about the publisher.
 */
class Publisher extends Entity
{
    /**
     * The publisherId variable is the unique ID for the publisher.
     */
    public int $publisherId;
    /**
     * This field contains the ID of the agency account.
     */
    public int $accountId;
    /**
     * The agencyID variable is the ID of the agency associated with the publisher.
     */
    public int $agencyId;
    /**
     * The publisherName variable is the name of the publisher.
     */
    public string $publisherName;
    /**
     * The contactName variable is the name of the contact for the publisher.
     */
    public string $contactName;
    /**
     * The emailAddress variable is the email address for the contact.
     */
    public string $emailAddress;
    /**
     * The website variable is the website address of the publisher.
     */
    public string $website;
    /**
     * This field provides any additional comments to be stored.
     */
    public string $comments;
    /**
     * This method returns an array of fields with their corresponding types.
     * @see Entity::getFieldsTypes
     */
    public function getFieldsTypes(): array
    {
        return [
            'publisherId' => 'integer',
            'accountId' => 'integer',
            'agencyId' => 'integer',
            'publisherName' => 'string',
            'contactName' => 'string',
            'emailAddress' => 'string',
            'website' => 'string',
            'comments' => 'string',
        ];
    }
}
