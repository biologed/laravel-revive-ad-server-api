<?php

namespace Biologed\Revive\Entities;

use Biologed\Revive\Utils;

/**
 * The Targeting class extends the base Entity class and contains
 * information about targeting
 */
class Targeting extends Entity
{
    /**
     * 99% will be “and” or “or”, but that's not enforced
     */
    public string $logical;
    /**
     * This is the plugin-component identifier
     */
    public string $type;
    /**
     * String showing the operation to be applied (e.g.: '==', '!=', '>=', 'ne')
     */
    public string $comparison;
    /**
     * The exact structure varies from component to component
     */
    public string $data;
    /**
     * This method returns an array of fields with their corresponding types.
     * @see Entity::getFieldsTypes
     */
    public function getFieldsTypes(): array
    {
        return [
            'logical' => 'string',
            'type' => 'string',
            'comparison' => 'string',
            'data' => 'string',
        ];
    }
    /**
     * quick settings for channel targeting
     * @example
     * $targeting[] = Targeting::getSettings();
     * $targeting[] = Targeting::getSettings('US','Country');
     * $targeting[] = Targeting::getSettings('KeyHere','Source','Site','==','or');
     * $rpc->setChannelTargeting($channel_id,$targeting);
     */
    public static function getSettings(string $csvFilter = 'EU', string $delivery_data = 'Continent', string $delivery_type = 'Geo', string $comparison = '=~', string $logical = 'and'): array
    {
        return [
            'logical' => Utils::getLogicalKey($logical),
            'type' => Utils::getDeliveryType($delivery_type, $delivery_data),
            'comparison' => Utils::getComparisonKey($comparison),// contains these
            'data' => $csvFilter // comma separated abbreviations Geo:Continent, varies per option...
        ];
    }
}
