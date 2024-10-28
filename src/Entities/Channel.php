<?php

namespace Biologed\Revive\Entities;

/**
 *  The Channel class extends the base Entity class and contains information about the channel.
 */
class Channel extends Entity
{
    /**
     * The channelID variable is the unique ID for the channel.
     */
    public int $channelId;
    /**
     * This field contains the ID of the agency account.
     */
    public int $agencyId;
    /**
     * This field contains the ID of the publisher.
     */
    public int $websiteId;
    /**
     * The channelName variable is the name of the channel.
     */
    public string $channelName;
    /**
     * The description variable is the description for the channel.
     */
    public string $description;
    /**
     * The comments variable is the comment for the channel.
     */
    public string $comments;
    /**
     * This method returns an array of fields with their corresponding types.
     * @see Entity::getFieldsTypes
     */
    public function getFieldsTypes(): array
    {
        return [
            'channelId' => 'integer',
            'agencyId' => 'integer',
            'websiteId' => 'integer',
            'channelName' => 'string',
            'description' => 'string',
            'comments' => 'string',
        ];
    }
}
