<?php

namespace Biologed\Revive\Entities;

/**
 * The Variable class extends the base Entity class and contains information about variable
 */
class Variable extends Entity
{
    public const string VARIABLE_DATATYPE_NUMERIC = 'numeric';
    public const string VARIABLE_DATATYPE_STRING = 'string';
    public const string VARIABLE_DATATYPE_DATE = 'date';
    public const string VARIABLE_PURPOSE_BASKET_VALUE = 'basket_value';
    public const string VARIABLE_PURPOSE_NUM_ITEMS = 'num_items';
    public const string VARIABLE_PURPOSE_POST_CODE = 'post_code';
    /**
     * The variableId variable is the unique ID for the variable.
     */
    public int $variableId;
    /**
     * The trackerId variable is the ID for the tracker.
     */
    public int $trackerId;
    /**
     * The variableName variable is the name of the variable.
     */
    public string $variableName;
    /**
     * This field provides a place for a description to be stored.
     */
    public string $description;
    /**
     * This field provides an optional data type
     *     MAX_CONNECTION_STATUS_IGNORE: 1
     *     MAX_CONNECTION_STATUS_PENDING: 2
     *     MAX_CONNECTION_STATUS_ONHOLD: 3
     *     MAX_CONNECTION_STATUS_APPROVED: 4
     *     MAX_CONNECTION_STATUS_DISAPPROVED: 5
     *     MAX_CONNECTION_STATUS_DUPLICATE: 6
     */
    public string $dataType;
    /**
     * The purpose variable is the purpose of this defined variable. basket_value, num_items, post_code
     */
    public string $purpose;
    /**
     * This field is a boolean to reject if empty.
     */
    public int $rejectIfEmpty;
    /**
     * This field is a boolean defining uniqueness.
     */
    public int $isUnique;
    /**
     * This field is a boolean if you use unique window.
     */
    public int $uniqueWindow;
    /**
     * The variableCode variable is the code of the variable.
     *
     * how it is used…
     * MAX_TrackVarJs('{$trackerJsCode}', '{$variable['name']}', '".addcslashes($variable['variablecode'], "'")."');";
     */
    public string $variableCode;
    /**
     * This field is a boolean for hidden variable.
     */
    public int $hidden;
    /**
     * This field is an array for hidden websites.
     */
    public array $hiddenWebsites;
    /**
     * This method returns an array of fields with their corresponding types.
     * @see Entity::getFieldsTypes
     */
    public function getFieldsTypes(): array
    {
        return [
            'variableId' => 'integer',
            'trackerId' => 'integer',
            'variableName' => 'string',
            'description' => 'string',
            'dataType' => 'string',
            'purpose' => 'string',
            'rejectIfEmpty' => 'boolean',
            'isUnique' => 'boolean',
            'uniqueWindow' => 'integer',
            'variableCode' => 'string',
            'hidden' => 'boolean',
            'hiddenWebsites' => 'array',
        ];
    }
}
