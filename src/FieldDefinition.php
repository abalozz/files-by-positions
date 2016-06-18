<?php

namespace FilesByPositions;

class FieldDefinition
{
    public $name;
    public $size = 0;
    public $string = ' ';
    public $type = 'right';

    public function __construct($name, $properties = null)
    {
        $this->name = $name;

        if ($properties && !is_array($properties)) {
            $properties = ['size' => $properties];
        }
        if (isset($properties['size'])) {
            $this->size($properties['size']);
        }
        if (isset($properties['string'])) {
            $this->string($properties['string']);
        }
        if (isset($properties['type'])) {
            $this->type($properties['type']);
        }
    }

    public function size($size)
    {
        $this->size = $size;

        return $this;
    }

    public function string($string)
    {
        $this->string = $string;

        return $this;
    }

    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    public function build($value = '')
    {
        $types = [
            'left' => STR_PAD_LEFT,
            'right' => STR_PAD_RIGHT,
            'both' => STR_PAD_BOTH,
        ];

        $value = mb_substr($value, 0, $this->size, 'utf-8');
        $value = multibyte_str_pad($value, $this->size, $this->string, $types[$this->type], 'utf-8');

        return $value;
    }
}
