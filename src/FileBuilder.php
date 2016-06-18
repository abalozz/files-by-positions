<?php

namespace FilesByPositions;

class FileBuilder
{
    protected $definitions = [];
    protected $rows = [];

    public function addRowDefinition($type, RowDefinition $definition)
    {
        $this->definitions[$type] = $definition;
    }

    public function addRow($type, array $content)
    {
        $this->rows[] = [
            'type' => $type,
            'content' => $content,
        ];
    }

    public function build()
    {
        return implode(PHP_EOL, array_map(function ($row) {
            if (!isset($this->definitions[$row['type']])) {
                throw new RowDefinitionNotFoundException("Row definition of type [{$row['type']}] not found");
            }

            $rowString = $this->definitions[$row['type']]->build($row['content']);

            return $rowString;
        }, $this->rows));
    }
}
