<?php

use FilesByPositions\FileReader;
use FilesByPositions\RowDefinition;

class FileReaderTest extends PHPUnit_Framework_TestCase
{
    function test_file_content_read()
    {
        $definitionHeader = new RowDefinition();
        $definitionHeader->addFieldDefinition('type', 1);
        $definitionHeader->addFieldDefinition('number_of_products', [
            'size' => 5,
            'string' => ' ',
            'type' => 'left',
        ]);
        $definitionHeader->addFieldDefinition('total_price')->size(9)->string('0')->type('left');
        $definitionHeader->setId('1');

        $definitionProduct = new RowDefinition([
            'type' => 1,
            'name' => 20,
            'price' => [
                'size' => 9,
                'string' => '0',
                'type' => 'left',
            ],
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

        $fileReader = new FileReader();
        $definitionProduct = new RowDefinition([
            'type' => 1,
            'name' => 20,
            'price' => [
                'size' => 9,
                'string' => '0',
                'type' => 'left',
            ],
        ]);
        
        $fileReader->addRowDefinition('product', $definitionProduct);


        $file = <<<FILE
2A Product Name 1    000049.99
FILE;

        $fileReader->readFile($file);
    }
}
