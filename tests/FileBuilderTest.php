<?php

use FilesByPositions\FileBuilder;
use FilesByPositions\RowDefinition;

class FileBuilderTest extends PHPUnit_Framework_TestCase
{
    function test_file_content_generate()
    {
        $definitionHeader = new RowDefinition();
        $definitionHeader->addFieldDefinition('type', 1);
        $definitionHeader->addFieldDefinition('number_of_products', [
            'size' => 5,
            'string' => ' ',
            'type' => 'left',
        ]);
        $definitionHeader->addFieldDefinition('total_price')->size(9)->string('0')->type('left');

        $definitionProduct = new RowDefinition([
            'type' => 1,
            'name' => 20,
            'price' => [
                'size' => 9,
                'string' => '0',
                'type' => 'left',
            ],
        ]);

        $fileBuilder = new FileBuilder();
        $fileBuilder->addRowDefinition('header', $definitionHeader);
        $fileBuilder->addRowDefinition('product', $definitionProduct);
        $fileBuilder->addRow('header', [
            'type' => 1,
            'number_of_products' => 3,
            'total_price' => 159.99,
        ]);
        $fileBuilder->addRow('product', [
            'type' => 2,
            'name' => 'A Product Name 1',
            'price' => 49.99,
        ]);
        $fileBuilder->addRow('product', [
            'type' => 2,
            'name' => 'A Product Name 2',
            'price' => 50,
        ]);
        $fileBuilder->addRow('product', [
            'type' => 2,
            'name' => 'A Product Name 3',
            'price' => 60,
        ]);

        $expected = <<<EXPECTED
1    3000159.99
2A Product Name 1    000049.99
2A Product Name 2    000000050
2A Product Name 3    000000060
EXPECTED;
        $this->assertEquals($expected, $fileBuilder->build());
    }

    function test_not_defined_row_definition_throw_an_exception()
    {
        $this->setExpectedException(
            'FilesByPositions\RowDefinitionNotFoundException',
            'Row definition of type [product] not found'
        );
        $fileBuilder = new FileBuilder();
        $fileBuilder->addRow('product', [
            'type' => 2,
            'name' => 'A Product Name 1',
            'price' => 49.99,
        ]);
        $fileBuilder->build();
    }
}
