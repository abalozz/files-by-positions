<?php

namespace FilesByPositions;

class RowDefinition
{
    protected $format = [];

    public function __construct(array $format = [])
    {
        foreach ($format as $fieldName => $properties) {
            $this->addFieldDefinition($fieldName, $properties);
        }
    }

    public function addFieldDefinition($fieldName, $fieldDefinition = null)
    {
        if (!$fieldDefinition instanceof FieldDefinition) {
            $fieldDefinition = new FieldDefinition($fieldName, $fieldDefinition);
        }

        $this->format[] = $fieldDefinition;

        return $fieldDefinition;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function build(array $data = [])
    {
        return array_reduce($this->format, function ($line, $fieldDefinition) use ($data) {
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
