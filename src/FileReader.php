<?php

namespace FilesByPositions;

class FileReader
{
    protected $definitions;

    public function addRowDefinition($type, RowDefinition $definition)
    {
        $this->definitions[$type] = $definition;
    }

    public function readFile($file)
    {
        $data = [];
        $line = 0;
        $rows = explode("\n", $file);
        foreach ($rows as $row) {
            foreach ($this->definitions as $type => $definition) {
                $id = $definition->getId();

                if (!isset($this->id)) {
                    throw new RowIdNotFoundException('Row identifier not found');
                }

                $id_size = $definition->getFieldDefinitions()[0]->size;
                if ($id == substr($row, 0, $id_size)) {
                    $data[$line] = $definition->read($row);
                    ++$line;
                }
            }
        }

        return $data;
    }
}
