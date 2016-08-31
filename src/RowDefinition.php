<?php

namespace FilesByPositions;

class RowDefinition
{
    protected $fields = [];

    public function __construct(array $fields = [])
    {
        foreach ($fields as $fieldName => $properties) {
            $this->addFieldDefinition($fieldName, $properties);
        }
    }

    public function addFieldDefinitions($fieldName, $fieldDefinition = null)
    {
        if (!$fieldDefinition instanceof FieldDefinition) {
            $fieldDefinition = new FieldDefinition($fieldName, $fieldDefinition);
        }

        $this->fields[] = $fieldDefinition;

        return $fieldDefinition;
    }

    public function getFieldDefinitions()
    {
        return $this->fields;
    }

    public function build(array $data = [])
    {
        return array_reduce($this->fields, function ($line, $fieldDefinition) use ($data) {
            $value = isset($data[$fieldDefinition->name]) ? $data[$fieldDefinition->name] : '';
            return $line . $fieldDefinition->build($value);
        }, '');
    }

    public function read($row)
    {
        throw new Exception('Method not implemented');

        return [];
    }
}
