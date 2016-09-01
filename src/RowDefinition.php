<?php

namespace FilesByPositions;

class RowDefinition
{
    protected $fields = [];
    protected $id;

    public function __construct(array $fields = [])
    {
        foreach ($fields as $fieldName => $properties) {
            $this->addFieldDefinition($fieldName, $properties);
        }
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function addFieldDefinition($fieldName, $fieldDefinition = null)
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

    public function getId()
    {
        return $this->id;
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
        $data = [];
        $position = 0;

        foreach ($this->fields as $fieldName => $field) {
            $data[$field->name] = substr($row, $position, $field->size);
            $position = $position +  $field->size;
        }

        return $data;
    }
}
