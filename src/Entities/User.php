<?php

namespace Biologed\Revive\Entities;

/**
 * The User class extends the base Entity class and contains information about the user.
 */
class User extends Entity
{
    /**
     * This fields provides the ID of the user
     */
    public int $userId;
    /**
     * This option provides the name of the contact for the user.
     */
    public string $contactName;
    /**
     * This field provides the email address of the user.
     */
    public string $emailAddress;
    /**
     * This option provides the username of the user.
     */
    public string $username;
    /**
     * This field provides the password of the user.
     */
    public string $password;
    /**
     * This field provides the default account ID of the user.
     */
    public int $defaultAccountId;
    /**
     * This field provides the status of the user.
     */
    public int $active;
    /**
     * This method returns an array of fields with their corresponding types.
     * @see Entity::getFieldsTypes
     */
    public function getFieldsTypes(): array
    {
        return [
            'userId' => 'integer',
            'contactName' => 'string',
            'emailAddress' => 'string',
            'username' => 'string',
            'password' => 'string',
            'defaultAccountId' => 'integer',
            'active' => 'integer',
        ];
    }
}
