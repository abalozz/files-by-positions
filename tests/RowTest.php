<?php

use FilesByPositions\RowDefinition;

class Row extends PHPUnit_Framework_TestCase
{
    function test_build_row_with_default_parameters()
    {
        $definition = new RowDefinition([
            'type' => 1,
            'name' => 20,
            'price' => 9,
        ]);

        $line = $definition->build([
            'type' => 1,
            'name' => 'A Product Name',
            'price' => 49.99,
        ]);

        $expected = '1A Product Name      49.99    ';
        $this->assertEquals($expected, $line);
    }

    function test_build_row_with_defined_parameters()
    {
        $definition = new RowDefinition([
            'type' => [
                'size' => 1,
                'string' => ' ',
                'type' => 'right',
            ],
            'name' => [
                'size' => 20,
                'string' => ' ',
                'type' => 'both',
            ],
            'price' => [
                'size' => 9,
                'string' => '0',
                'type' => 'left',
            ],
        ]);

        $line = $definition->build([
            'type' => 1,
            'name' => 'A Product Name',
            'price' => 49.99,
        ]);

        $expected = '1   A Product Name   000049.99';
        $this->assertEquals($expected, $line);
    }
}
