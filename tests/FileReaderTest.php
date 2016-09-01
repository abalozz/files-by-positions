<?php

use FilesByPositions\FileReader;
use FilesByPositions\RowDefinition;

class FileReaderTest extends PHPUnit_Framework_TestCase
{
    function test_file_content_read()
    {
        $definitionHeader = new RowDefinition([
            'type' => 1,
            'number_of_products' => 5,
            'total_price' => 9,
        ]);
        $definitionHeader->setId('1');

        $definitionProduct = new RowDefinition([
            'type' => 1,
            'name' => 20,
            'price' => 9,
        ]);
        $definitionProduct->setId('2');

        $fileReader = new FileReader();
        $fileReader->addRowDefinition('header', $definitionHeader);
        $fileReader->addRowDefinition('product', $definitionProduct);

        $expected = [
            '0' => [
                'type' => '1',
                'number_of_products' => '    3',
                'total_price' => '000159.99',
            ],
            '1' => [
                'type' => '2',
                'name' => 'A Product Name 1    ',
                'price' => '000049.99'
            ],
            '2' => [
                'type' => '2',
                'name' => 'A Product Name 2    ',
                'price' => '000000050'
            ],
        ];

        $file = <<<FILE
1    3000159.99
2A Product Name 1    000049.99
2A Product Name 2    000000050
FILE;

        $this->assertEquals($expected, $fileReader->readFile($file));
    }

    function test_not_defined_row_identifier_throw_an_exception()
    {
        $this->setExpectedException(
            'FilesByPositions\RowIdNotFoundException',
            'Row identifier not found'
        );

        $file = '2A Product Name 1    000049.99';

        $definitionProduct = new RowDefinition([
            'type' => 1,
            'name' => 20,
            'price' => 9,
        ]);

        $fileReader = new FileReader();
        $fileReader->addRowDefinition('product', $definitionProduct);
        $fileReader->readFile($file);
    }
}
