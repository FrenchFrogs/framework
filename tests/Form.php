<?php

/**
 * TODO: Test action's methods
 * TODO: Test __call / __toString
**/

use FrenchFrogs\Form\Form;
use FrenchFrogs\Form\Element;

class FormEntity extends Form
{
    public function _get_attribute()
    {
        return $this->attribute;
    }

    public function _get_element()
    {
        return $this->element;
    }

    public function _get_action()
    {
        return $this->action;
    }
}
class FormElementEntity extends Element
{
    public function _get_tag()
    {
        return $this->tag;
    }

    public function _get_attribute()
    {
        return $this->attribute;
    }

    public function _get_content()
    {
        return $this->content;
    }
}

class FormTest extends PHPUnit_Framework_TestCase
{

    protected $entity;

    public function setUp()
    {
        parent::setUp();
        $this->entity = new FormEntity();
    }

    public function testConstruct()
    {
        $Form1 = new Form();
        $Form2 = new Form();
        $Form1->field_name = 'field_value';
        $this->assertNotEquals($Form1, $Form2);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testAddElement_InvalidParamsNull()
    {
        $this->entity->addElement(null);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testAddElement_InvalidParamsObject()
    {
        $stdObject = new stdClass();
        $this->entity->addElement($stdObject);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testAddElement_InvalidParamsArray()
    {
        $this->entity->addElement(array());
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testAddElement_InvalidParamsString()
    {
        $this->entity->addElement('string');
    }

    public function testAddElement_Empty()
    {
        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertEmpty($fields);

        $element = new FormElementEntity();
        $result = $this->entity->addElement($element);
        $this->assertEquals($result, $this->entity);

        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertNotEmpty($fields);
        $this->assertCount(1, $fields);
        $this->assertArrayHasKey('', $fields);
        $this->assertEquals($element, $fields['']);
    }

    public function testAddElement()
    {
        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertEmpty($fields);

        $element = new FormElementEntity();
        $element->setName('elementName');

        $result = $this->entity->addElement($element);
        $this->assertEquals($result, $this->entity);

        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertNotEmpty($fields);
        $this->assertCount(1, $fields);
        $this->assertArrayHasKey('elementName', $fields);
        $this->assertEquals($element, $fields['elementName']);
    }

    public function testAddElement_dublicates()
    {
        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertEmpty($fields);

        $element1 = new FormElementEntity();
        $element1->setName('elementName');
        $element1->specificField = 1;

        $element2 = new FormElementEntity();
        $element2->setName('elementName');
        $element2->specificField2 = 2;

        $result = $this->entity->addElement($element1);
        $this->assertEquals($result, $this->entity);

        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertNotEmpty($fields);
        $this->assertCount(1, $fields);
        $this->assertArrayHasKey('elementName', $fields);
        $this->assertEquals($element1, $fields['elementName']);

        $result = $this->entity->addElement($element2);
        $this->assertEquals($result, $this->entity);

        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertNotEmpty($fields);
        $this->assertCount(1, $fields);
        $this->assertArrayHasKey('elementName', $fields);
        $this->assertEquals($element2, $fields['elementName']);
    }

    public function testRemoveElement()
    {
        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertEmpty($fields);

        $element1 = new FormElementEntity();
        $element1->setName('elementName1');
        $this->entity->addElement($element1);

        $element2 = new FormElementEntity();
        $element2->setName('elementName2');
        $this->entity->addElement($element2);

        $element3 = new FormElementEntity();
        $element3->setName('elementName3');
        $this->entity->addElement($element3);

        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertCount(3, $fields);

        $result = $this->entity->removeElement('not existed key');
        $this->assertEquals($result, $this->entity);

        $fields2 = $this->entity->_get_element();
        $this->assertEquals($fields, $fields2);

        $result = $this->entity->removeElement('elementName2');
        $this->assertEquals($result, $this->entity);
        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertCount(2, $fields);
        $this->assertArrayHasKey('elementName1', $fields);
        $this->assertEquals($element1, $fields['elementName1']);
        $this->assertArrayHasKey('elementName3', $fields);
        $this->assertEquals($element3, $fields['elementName3']);
    }

    public function testClearElement()
    {
        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertEmpty($fields);

        $element1 = new FormElementEntity();
        $element1->setName('elementName1');
        $this->entity->addElement($element1);

        $element2 = new FormElementEntity();
        $element2->setName('elementName2');
        $this->entity->addElement($element2);

        $element3 = new FormElementEntity();
        $element3->setName('elementName3');
        $this->entity->addElement($element3);

        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertCount(3, $fields);

        $result = $this->entity->clearElement();
        $this->assertEquals($result, $this->entity);

        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertEmpty($fields);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetElement_notExistedElement()
    {
        $this->entity->getElement('not existed entity name');
    }

    public function testGetElement()
    {
        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertEmpty($fields);

        $element1 = new FormElementEntity();
        $element1->setName('elementName1');
        $this->entity->addElement($element1);

        $element2 = new FormElementEntity();
        $element2->setName('elementName2');
        $this->entity->addElement($element2);

        $element3 = new FormElementEntity();
        $element3->setName('elementName3');
        $this->entity->addElement($element3);

        $result = $this->entity->getElement('elementName2');
        $this->assertEquals($element2, $result);
    }

    public function testGetAllElement()
    {
        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertEmpty($fields);

        $elements = $this->entity->getAllElement();
        $this->assertEquals($fields, $elements);

        $element1 = new FormElementEntity();
        $element1->setName('elementName1');
        $this->entity->addElement($element1);

        $element2 = new FormElementEntity();
        $element2->setName('elementName2');
        $this->entity->addElement($element2);

        $element3 = new FormElementEntity();
        $element3->setName('elementName3');
        $this->entity->addElement($element3);

        $fields = $this->entity->_get_element();
        $this->assertInternalType('array', $fields);
        $this->assertCount(3, $fields);

        $elements = $this->entity->getAllElement();
        $this->assertEquals($fields, $elements);
    }

    public function testCreate_default()
    {
        $form = FormEntity::create();
        $this->assertInstanceOf('FormEntity', $form);

        $attribute = $form->_get_attribute();
        $this->assertArrayHasKey('action', $attribute);
        $this->assertEquals('', $attribute['action']);

        $this->assertArrayHasKey('method', $attribute);
        $this->assertEquals('POST', $attribute['method']);
    }

    public function testCreate()
    {
        $form = FormEntity::create('/path/to/submit', 'GET');
        $this->assertInstanceOf('FormEntity', $form);

        $attribute = $form->_get_attribute();
        $this->assertArrayHasKey('action', $attribute);
        $this->assertEquals('/path/to/submit', $attribute['action']);

        $this->assertArrayHasKey('method', $attribute);
        $this->assertEquals('GET', $attribute['method']);
    }

    public function testSetMethod()
    {
        $attribute = $this->entity->_get_attribute();
        $this->assertInternalType('array', $attribute);
        $this->assertEmpty($attribute);

        $result = $this->entity->setMethod('PUT');
        $this->assertEquals($this->entity, $result);

        $attribute = $this->entity->_get_attribute();
        $this->assertInternalType('array', $attribute);
        $this->assertArrayHasKey('method', $attribute);
        $this->assertEquals('PUT', $attribute['method']);
        $this->assertCount(1, $attribute);
    }

    public function testGetMethod()
    {
        $attribute = $this->entity->_get_attribute();
        $this->assertInternalType('array', $attribute);
        $this->assertEmpty($attribute);

        $result = $this->entity->getMethod();
        $this->assertEquals('', $result);

        $this->entity->setMethod('DELETE');
        $result = $this->entity->getMethod();
        $this->assertEquals('DELETE', $result);
    }

    public function testSetUrl()
    {
        $attribute = $this->entity->_get_attribute();
        $this->assertInternalType('array', $attribute);
        $this->assertEmpty($attribute);

        $result = $this->entity->setUrl('/url/to/post');
        $this->assertEquals($this->entity, $result);

        $attribute = $this->entity->_get_attribute();
        $this->assertInternalType('array', $attribute);
        $this->assertArrayHasKey('action', $attribute);
        $this->assertEquals('/url/to/post', $attribute['action']);
        $this->assertCount(1, $attribute);
    }

    public function testGetUrl()
    {
        $attribute = $this->entity->_get_attribute();
        $this->assertInternalType('array', $attribute);
        $this->assertEmpty($attribute);

        $result = $this->entity->getUrl();
        $this->assertEquals('', $result);

        $this->entity->setUrl('/path');
        $result = $this->entity->getUrl();
        $this->assertEquals('/path', $result);
    }


}

?>