<?php

namespace FilesByPositions;

class RowDefinition
{
    protected $format = [];

    public function __construct(array $format = [])
    {
        $this->format = $format;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function build(array $data = [])
    {
        $line = '';
        foreach ($this->format as $field => $properties) {
            if (!is_array($properties)) {
                $properties = [
                    'size' => $properties,
                    'string' => ' ',
                    'type' => 'right',
                ];
            }

            $types = [
                'left' => STR_PAD_LEFT,
                'right' => STR_PAD_RIGHT,
                'both' => STR_PAD_BOTH,
            ];

            $attr = isset($data[$field]) ? $data[$field] : '';
            $attr = mb_substr($attr, 0, $properties['size'], 'utf-8');
            $attr = multibyte_str_pad($attr, $properties['size'], $properties['string'], $types[$properties['type']], 'utf-8');
            $line .= $attr;
        }

        return $line;
    }

    public function read($row)
    {
        throw new Exception('Method not implemented');

        return [];
    }
}
