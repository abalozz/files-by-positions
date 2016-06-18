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

    function test_value_with_longer_than_field_size()
    {
        $definition = new RowDefinition([
            'type' => 1,
            'name' => 20,
            'price' => 9,
        ]);

        $line = $definition->build([
            'type' => 1,
            'name' => 'A Very Long Product Name',
            'price' => 49.99,
        ]);

        $expected = '1A Very Long Product 49.99    ';
        $this->assertEquals($expected, $line);
    }

    function test_fields_without_value()
    {
        $definition = new RowDefinition([
            'type' => 1,
            'name' => 20,
            'price' => 9,
        ]);

        $line = $definition->build();

        $expected = '                              ';
        $this->assertEquals($expected, $line);
    }

    function test_values_with_special_characters()
    {
        $definition = new RowDefinition([
            'type' => 1,
            'name' => 20,
            'price' => 9,
        ]);

        $line = $definition->build([
            'type' => 1,
            'name' => 'Jamón Serrano',
            'price' => '49.99€',
        ]);

        $expected = '1Jamón Serrano       49.99€   ';
        $this->assertEquals($expected, $line);
    }
}
