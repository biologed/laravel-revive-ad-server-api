<?php

namespace Biologed\Revive\Entities;

use Carbon\CarbonImmutable;

/**
 * @package OpenXDll
 * The Entity class is the base class for all entities classes.
 */
abstract class Entity
{
    /**
     * get field type definition
     *
     * @see Utils::getRPCTypeForField
     * @return array ['fieldName' +> 'RPCdataType', ...]
     */
    abstract public function getFieldsTypes(): array;
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->readDataFromArray($data);
        }
    }
    /**
     * create/build $this from array data
     * @param array $data ['fieldName' +> 'RPCdataType', ...]
     * @see Entity::getFieldType;
     * @see Entity::getFieldsTypes;
     */
    public function readDataFromArray(array $data): void
    {
        $fieldsTypes = $this->getFieldsTypes();
        foreach ($fieldsTypes as $fieldName => $fieldType) {
            if (array_key_exists($fieldName, $data)) {
                if ($fieldType === 'date') {
                    $this->$fieldName = CarbonImmutable::parse($data[$fieldName]);
                } else {
                    $this->$fieldName = $data[$fieldName];
                }
            }
        }
    }
    /**
     * get RPCdataType for field
     * @param $fieldName
     * @return mixed
     */
    public function getFieldType($fieldName): mixed
    {
        $fieldsTypes = $this->getFieldsTypes();
        if (!isset($fieldsTypes)) {
            die('Please provide field types array for Entity object creation');
        }
        if (!array_key_exists($fieldName, $fieldsTypes)) {
            die('Unknown type for field \'' . $fieldName . '\'');
        }
        return $fieldsTypes[$fieldName];
    }
    /**
     * @return array
     */
    public function toArray(): array
    {
        return (array)$this;
    }
}
