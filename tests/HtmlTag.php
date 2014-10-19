<?php

class HtmlTagEntity {
    use FrenchFrogs\Core\HtmlTag;

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

class HtmlTagTest extends PHPUnit_Framework_TestCase
{

    protected $entity;

    public function setUp()
    {
        parent::setUp();
        $this->entity = new HtmlTagEntity();
    }

    public function testSetClass()
    {
        $assets = array(
            array(
                'params' => 'class1 class2',
                'expected' => 'class1 class2',
            ),
            array(
                'params' => array('class1', 'class2'),
                'expected' => 'class1 class2',
            ),
            array(
                'params' => array('class1', 'class1'),
                'expected' => 'class1',
            ),
            array(
                'params' => array(),
                'expected' => '',
            ),
        );
        foreach ($assets as $i => $asset) {
            $entity = $this->entity->setClass($asset['params']);
            $this->assertEquals($this->entity, $entity);

            $class = $this->entity->getClass();
            $this->assertEquals($asset['expected'], $class, $i);
        }
    }

    public function testAddClass()
    {
        $assets = array(
            array(
                'params' => 'class1',
                'expected' => 'class1',
            ),
            array(
                'params' => 'class1 class1',
                'expected' => 'class1',
            ),
            array(
                'params' => 'class2',
                'expected' => 'class1 class2',
            ),
            array(
                'params' => array('class1', 'class3'),
                'expected' => 'class1 class2 class3',
            ),
            array(
                'params' => array('class4', 'class4'),
                'expected' => 'class1 class2 class3 class4',
            ),
        );
        foreach ($assets as $i => $asset) {
            $entity = $this->entity->addClass($asset['params']);
            $this->assertEquals($this->entity, $entity);

            $class = $this->entity->getClass();
            $this->assertEquals($asset['expected'], $class, $i);
        }
    }

    public function testRemoveClass()
    {
        $assets = array(
            array(
                'params' => 'class1',
                'expected' => 'class2 class3 class4',
            ),
            array(
                'params' => 'class1 class2',
                'expected' => 'class3 class4',
            ),
            array(
                'params' => array('class1', 'class3'),
                'expected' => 'class2 class4',
            ),
            array(
                'params' => array('class4', 'class4'),
                'expected' => 'class1 class2 class3',
            ),
            array(
                'params' => 'class1 class2 class3 class4',
                'expected' => '',
            ),
        );
        foreach ($assets as $i => $asset) {
            $entity = $this->entity->setClass('class1 class2 class3 class4');
            $this->assertEquals($this->entity, $entity);

            $entity = $this->entity->removeClass($asset['params']);
            $this->assertEquals($this->entity, $entity);

            $class = $this->entity->getClass();
            $this->assertEquals($asset['expected'], $class, $i);
        }
    }

    public function testClearClass()
    {
        $entity = $this->entity->setClass('class1 class2');
        $this->assertEquals($this->entity, $entity);

        $class = $this->entity->getClass();
        $this->assertEquals('class1 class2', $class);

        $entity = $this->entity->clearClass();
        $this->assertEquals($this->entity, $entity);

        $class = $this->entity->getClass();
        $this->assertEquals('', $class);
    }

    public function testHasClass()
    {
        $assets = array(
            'class1' => true,
            'invalid_class' => false,
            '' => false,
        );
        $entity = $this->entity->setClass('class1 class2 class3 class4');
        $this->assertEquals($this->entity, $entity);

        foreach ($assets as $params => $expected) {
            $result = $this->entity->hasClass($params);
            $this->assertEquals($expected, $result, $params);
        }
    }

    public function testGetClass()
    {
        $entity = $this->entity->setClass('class1 class2');
        $this->assertEquals($this->entity, $entity);

        $class = $this->entity->getClass();
        $this->assertEquals('class1 class2', $class);
    }

    public function testSetStyle()
    {
        $assets = array(
            array(
                'params' => 'color: red; background: url(\'http://www.fake.com\') top center no-repeat;',
                'expected' => 'color: red; background: url(\'http://www.fake.com\') top center no-repeat',
            ),
            array(
                'params' => array('color' => 'red', 'background' => 'url(\'http://www.fake.com\') top center no-repeat'),
                'expected' => 'color: red; background: url(\'http://www.fake.com\') top center no-repeat',
            ),
            array(
                'params' => array(),
                'expected' => '',
            ),
            array(
                'params' => '',
                'expected' => '',
            ),
        );
        foreach ($assets as $i => $asset) {
            $entity = $this->entity->setStyle($asset['params']);
            $this->assertEquals($this->entity, $entity);

            $style = $this->entity->getStyle();
            $this->assertEquals($asset['expected'], $style, $i);
        }
    }

    public function testAddStyle()
    {
        $assets = array(
            array(
                'params' => array('color: red'),
                'expected' => 'color: red',
            ),
            array(
                'params' => array('Background', 'url(\'http://www.fake.com\') top center no-repeat'),
                'expected' => 'color: red; background: url(\'http://www.fake.com\') top center no-repeat',
            ),
            array(
                'params' => array(' coLor ', 'blue'),
                'expected' => 'color: blue; background: url(\'http://www.fake.com\') top center no-repeat',
            ),
            array(
                'params' => array(' color :  green'),
                'expected' => 'color: green; background: url(\'http://www.fake.com\') top center no-repeat',
            ),
        );
        $this->entity->setStyle('');
        foreach ($assets as $i => $asset) {
            $entity = call_user_func_array(array($this->entity, 'addStyle'), $asset['params']);
            $this->assertEquals($this->entity, $entity);

            $style = $this->entity->getStyle();
            $this->assertEquals($asset['expected'], $style, $i);
        }
    }

    public function testRemoveStyle()
    {
        $assets = array(
            array(
                'params' => 'color',
                'expected' => 'background: url(\'http://www.fake.com\') top center no-repeat',
            ),
            array(
                'params' => 'BackGround',
                'expected' => 'color: red',
            ),
            array(
                'params' => '',
                'expected' => 'color: red; background: url(\'http://www.fake.com\') top center no-repeat',
            ),
        );
        foreach ($assets as $i => $asset) {
            $entity = $this->entity->setStyle('color: red; background: url(\'http://www.fake.com\') top center no-repeat;');
            $this->assertEquals($this->entity, $entity);

            $entity = $this->entity->removeStyle($asset['params']);
            $this->assertEquals($this->entity, $entity);

            $style = $this->entity->getStyle();
            $this->assertEquals($asset['expected'], $style, $i);
        }
    }

    public function testClearStyle()
    {
        $entity = $this->entity->setStyle('color: red; opacity: 0.4');
        $this->assertEquals($this->entity, $entity);

        $style = $this->entity->getStyle();
        $this->assertEquals('color: red; opacity: 0.4', $style);

        $entity = $this->entity->clearStyle();
        $this->assertEquals($this->entity, $entity);

        $style = $this->entity->getStyle();
        $this->assertEquals('', $style);
    }

    public function testGetStyle()
    {
        $entity = $this->entity->setStyle('color: red; opacity: 0.4');
        $this->assertEquals($this->entity, $entity);

        $style = $this->entity->getStyle();
        $this->assertEquals('color: red; opacity: 0.4', $style);
    }

    public function testSetAttribute()
    {
        $attribute = array(
            'style' => 'color: red',
            'class' => 'class1',
            'required' => 'required',
        );
        $entity = $this->entity->setAttribute($attribute);
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->_get_attribute();
        $this->assertEquals($attribute, $result);
    }

    public function testGetAttribute()
    {
        $attribute = array(
            'style' => 'color: red',
            'class' => 'class1',
            'required' => 'required',
            'value' => '',
            'size' => 0,
        );
        $entity =$this->entity->setAttribute($attribute);
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getAttribute('unexist key');
        $this->assertNull($result);

        $result = $this->entity->getAttribute('style');
        $this->assertEquals($attribute['style'], $result);

        $result = $this->entity->getAttribute('value');
        $this->assertEquals($attribute['value'], $result);

        $result = $this->entity->getAttribute('size');
        $this->assertEquals($attribute['size'], $result);
    }

    public function testRemoveAttribute()
    {
        $attribute = array(
            'style' => 'color: red',
            'class' => 'class1',
            'required' => 'required',
            'value' => '',
            'size' => 0,
        );
        $entity = $this->entity->setAttribute($attribute);
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getAttribute('style');
        $this->assertEquals($attribute['style'], $result);

        $entity = $this->entity->removeAttribute('style');
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getAttribute('style');
        $this->assertNull($result);

        unset($attribute['style']);
        $result = $this->entity->_get_attribute();
        $this->assertEquals($attribute, $result);

        foreach ($attribute as $key => $value) {
            $result = $this->entity->getAttribute($key);
            $this->assertEquals($value, $result, $key);
        }
    }

    public function testClearAttribute()
    {
        $attribute = array(
            'style' => 'color: red',
            'class' => 'class1',
            'required' => 'required',
        );
        $entity = $this->entity->setAttribute($attribute);
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->_get_attribute();
        $this->assertEquals($attribute, $result);

        $entity = $this->entity->clearAttribute();
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->_get_attribute();
        $this->assertEquals(array(), $result);

        foreach ($attribute as $key => $value) {
            $result = $this->entity->getAttribute($key);
            $this->assertNull($result);
        }
    }

    public function testGetContent()
    {
        $result = $this->entity->getContent();
        $this->assertEquals('', $result);

        $entity = $this->entity->setContent('Contenu');
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getContent();
        $this->assertEquals('Contenu', $result);
    }

    public function testSetContent()
    {
        $entity = $this->entity->setContent('Contenu');
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getContent();
        $this->assertEquals('Contenu', $result);

        $result = $this->entity->_get_content();
        $this->assertEquals('Contenu', $result);
    }

    public function testAppendContent()
    {
        $entity = $this->entity->setContent('Contenu');
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getContent();
        $this->assertEquals('Contenu', $result);

        $entity = $this->entity->appendContent('Contenu2');
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getContent();
        $this->assertEquals('ContenuContenu2', $result);
    }

    public function testPreprendContent()
    {
        $entity = $this->entity->setContent('Contenu');
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getContent();
        $this->assertEquals('Contenu', $result);

        $entity = $this->entity->prependContent('Contenu0');
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getContent();
        $this->assertEquals('Contenu0Contenu', $result);
    }

    public function testClearContent()
    {
        $entity = $this->entity->setContent('Contenu');
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getContent();
        $this->assertEquals('Contenu', $result);

        $entity = $this->entity->clearContent();
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getContent();
        $this->assertEquals('', $result);

        $result = $this->entity->_get_content();
        $this->assertEquals('', $result);
    }

    public function testGetTag()
    {
        $result = $this->entity->getTag();
        $this->assertNull($result);

        $entity = $this->entity->setTag('input');
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getTag();
        $this->assertEquals('input', $result);
    }

    public function testSetTag()
    {
        $entity = $this->entity->setTag('select');
        $this->assertEquals($this->entity, $entity);

        $result = $this->entity->getTag();
        $this->assertEquals('select', $result);

        $result = $this->entity->_get_tag();
        $this->assertEquals('select', $result);
    }

    public function testToString()
    {
        $attribute = array(
            'required' => 'required',
            'class' => 'class1',
            'name' => 'comment',
        );

        $this->entity->setTag('textarea');
        $this->entity->setAttribute($attribute);
        $this->entity->setContent('Contenu');
        $string = (string)$this->entity;
        $this->assertEquals('<textarea required="required" class="class1" name="comment">Contenu</textarea>', $string);
    }

    public function testRender()
    {
        $attribute = array(
            'required' => 'required',
            'class' => 'class1',
            'name' => 'comment',
        );

        $this->entity->setTag('textarea');
        $this->entity->setAttribute($attribute);
        $this->entity->setContent('Contenu');
        $string = $this->entity->render();
        $this->assertEquals('<textarea required="required" class="class1" name="comment">Contenu</textarea>', $string);
    }

}

?>