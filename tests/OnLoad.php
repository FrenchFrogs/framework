<?php

use FrenchFrogs\Jquery\OnLoad;

class OnLoadEntity extends OnLoad {

    public function _get_script()
    {
        return $this->script;
    }
}

class OnLoadTest extends PHPUnit_Framework_TestCase
{

    protected $entity;

    public function setUp()
    {
        parent::setUp();
        $this->entity = new OnLoadEntity();
    }

    public function testAdd()
    {
        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertEmpty($scripts);

        $result = $this->entity->add('myKey', 'myContent');
        $this->assertEquals($this->entity, $result);

        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertCount(1, $scripts);
        $this->assertArrayHasKey('myKey', $scripts);
        $this->assertEquals('myContent', $scripts['myKey']);

        $result = $this->entity->add('myKey2', 'myContentBis');
        $this->assertEquals($this->entity, $result);

        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertCount(2, $scripts);
        $this->assertArrayHasKey('myKey', $scripts);
        $this->assertEquals('myContent', $scripts['myKey']);
        $this->assertArrayHasKey('myKey2', $scripts);
        $this->assertEquals('myContentBis', $scripts['myKey2']);

        $result = $this->entity->add('myKey', 'myOtherContent');
        $this->assertEquals($this->entity, $result);

        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertCount(2, $scripts);
        $this->assertArrayHasKey('myKey', $scripts);
        $this->assertEquals('myOtherContent', $scripts['myKey']);
        $this->assertArrayHasKey('myKey2', $scripts);
        $this->assertEquals('myContentBis', $scripts['myKey2']);
    }

    public function testRemove()
    {
        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertEmpty($scripts);

        $this->entity->add('myKey', 'myContent');
        $this->entity->add('myKey2', 'myContentBis');
        $this->entity->add('myKey3', 'myOtherContent');

        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertCount(3, $scripts);

        $result = $this->entity->remove('undefined key');
        $this->assertEquals($this->entity, $result);

        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertCount(3, $scripts);
        $this->assertArrayHasKey('myKey', $scripts);
        $this->assertEquals('myContent', $scripts['myKey']);
        $this->assertArrayHasKey('myKey2', $scripts);
        $this->assertEquals('myContentBis', $scripts['myKey2']);
        $this->assertArrayHasKey('myKey3', $scripts);
        $this->assertEquals('myOtherContent', $scripts['myKey3']);

        $result = $this->entity->remove('myKey2');
        $this->assertEquals($this->entity, $result);

        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertCount(2, $scripts);
        $this->assertArrayHasKey('myKey', $scripts);
        $this->assertEquals('myContent', $scripts['myKey']);
        $this->assertArrayHasKey('myKey3', $scripts);
        $this->assertEquals('myOtherContent', $scripts['myKey3']);
    }

    public function testClear()
    {
        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertEmpty($scripts);

        $this->entity->add('myKey', 'myContent');
        $this->entity->add('myKey2', 'myContentBis');
        $this->entity->add('myKey3', 'myOtherContent');

        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertCount(3, $scripts);

        $result = $this->entity->clear();
        $this->assertEquals($this->entity, $result);

        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertEmpty($scripts);
    }

    public function testGetFormattedScript()
    {
        $scripts = $this->entity->_get_script();
        $this->assertInternalType('array', $scripts);
        $this->assertEmpty($scripts);

        $this->entity->add('alert', 'alert(1);');
        $this->entity->add('confirm', "var confirm('Test ?');");
        $this->entity->add('script', '<script type="text/javascript">$(".datepicker").datepicker();</script>');

        $result = $this->entity->getFormattedScript();
        $expected = 'alert(1);';
        $expected .= "\nvar confirm('Test ?');";
        $expected .= "\n" . '$(".datepicker").datepicker();';
        $this->assertEquals($expected, $result);
    }
}

?>