<?php

use FrenchFrogs\Form\Element;

class ElementEntity extends Element {

    public function _get_attribute()
    {
        return $this->attribute;
    }
}

class ElementTest extends PHPUnit_Framework_TestCase
{

    protected $entity;

    public function setUp()
    {
        parent::setUp();
        $this->entity = new ElementEntity();
    }

    public function testSetName()
    {
        $attribute = $this->entity->_get_attribute();
        $this->assertInternalType('array', $attribute);
        $this->assertEmpty($attribute);

        $result = $this->entity->setName('myName');
        $this->assertEquals($this->entity, $result);

        $attribute = $this->entity->_get_attribute();
        $this->assertInternalType('array', $attribute);
        $this->assertArrayHasKey('name', $attribute);
        $this->assertEquals('myName', $attribute['name']);
        $this->assertCount(1, $attribute);
    }

    public function testGetName()
    {
        $attribute = $this->entity->_get_attribute();
        $this->assertInternalType('array', $attribute);
        $this->assertEmpty($attribute);

        $result = $this->entity->getName();
        $this->assertEquals('', $result);

        $this->entity->setName('myName2');
        $result = $this->entity->getName();
        $this->assertEquals('myName2', $result);
    }


}

?>