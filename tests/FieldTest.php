<?php

use FilesByPositions\FieldDefinition;

class FieldTest extends PHPUnit_Framework_TestCase
{
    function test_field_parameters()
    {
        $fieldDefinition = new FieldDefinition('money');
        $fieldDefinition->size(9)->string('0')->type('left');

        $this->assertEquals('money', $fieldDefinition->name);
        $this->assertEquals(9, $fieldDefinition->size);
        $this->assertEquals('0', $fieldDefinition->string);
        $this->assertEquals('left', $fieldDefinition->type);
    }

    public function test_build_field_with_parameters_passed_with_methods()
    {
        $fieldDefinition = new FieldDefinition('money');
        $fieldDefinition->size(9)->string('0')->type('left');

        $this->assertEquals('000019.58', $fieldDefinition->build('19.58'));
    }

    public function test_build_field_with_parameters_passed_to_constructor()
    {
        $fieldDefinition = new FieldDefinition('money', [
            'size' => 9,
            'string' => '0',
            'type' => 'left',
        ]);

        $this->assertEquals('000019.58', $fieldDefinition->build('19.58'));
    }

    function test_value_with_longer_than_field_size()
    {
        $fieldDefinition = new FieldDefinition('money', 20);

        $this->assertEquals('A Very Long Product ', $fieldDefinition->build('A Very Long Product Name'));
    }

    function test_fields_without_value()
    {
        $fieldDefinition = new FieldDefinition('money', 20);

        $this->assertEquals('                    ', $fieldDefinition->build());
    }

    function test_values_with_special_characters()
    {
        $nameFieldDefinition = new FieldDefinition('name', 20);
        $priceFieldDefinition = new FieldDefinition('price', 9);

        $this->assertEquals('Jamón Serrano       ', $nameFieldDefinition->build('Jamón Serrano'));
        $this->assertEquals('49.99€   ', $priceFieldDefinition->build('49.99€'));
    }
}
