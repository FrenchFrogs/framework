<?php

use FrenchFrogs\Core\Configurator as Configurator;

class ConfiguratorEntity extends FrenchFrogs\Core\Configurator
{

    public static function getInstances()
    {
        return self::$instances;
    }

    public static function resetInstances()
    {
        self::$instances = array();
    }
}

class FrenchFrogsCoreConfiguratorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var ConfiguratorEntity
     */
    public $Configurator;

    public function tearDown()
    {
        ConfiguratorEntity::resetInstances();
        parent::tearDown();
    }

    public function testDefaultConst()
    {
        $this->assertEquals('default', ConfiguratorEntity::NAMESPACE_DEFAULT);
    }

    public function testDefaultInstances()
    {
        $instances = ConfiguratorEntity::getInstances();
        $this->assertInternalType('array', $instances);
        $this->assertCount(0, $instances);

        ConfiguratorEntity::getInstance();
        $instances = ConfiguratorEntity::getInstances();
        $this->assertInternalType('array', $instances);
        $this->assertCount(1, $instances);
        $this->assertArrayHasKey(ConfiguratorEntity::NAMESPACE_DEFAULT, $instances);
    }

    public function testDefaultConfig()
    {
        $Configurator = ConfiguratorEntity::getInstance();
        $config = $Configurator->getAll();
        $this->assertInternalType('array', $config);
        $this->assertArrayHasKey('panel.class', $config);
        $this->assertArrayHasKey('panel.renderer.class', $config);
        $this->assertArrayHasKey('table.class', $config);
        $this->assertArrayHasKey('table.renderer.class', $config);
        $this->assertArrayHasKey('modal.class', $config);
        $this->assertArrayHasKey('modal.renderer.class', $config);
        $this->assertArrayHasKey('modal.closeButtonLabel', $config);
        $this->assertArrayHasKey('modal.backdrop', $config);
        $this->assertArrayHasKey('modal.escToclose', $config);
        $this->assertArrayHasKey('modal.is_remote', $config);
        $this->assertArrayHasKey('modal.remote.id', $config);
    }

    public function testGetInstanceNull()
    {
        $instance = ConfiguratorEntity::getInstance();
        $this->assertInstanceOf('ConfiguratorEntity', $instance);
        $instances = ConfiguratorEntity::getInstances();
        $this->assertInternalType('array', $instances);
        $this->assertCount(1, $instances);
        $this->assertArrayHasKey(ConfiguratorEntity::NAMESPACE_DEFAULT, $instances);
        $this->assertEquals($instance, $instances[ConfiguratorEntity::NAMESPACE_DEFAULT]);
    }

    public function testGetInstanceNotNull()
    {
        $instance = ConfiguratorEntity::getInstance('myNameInstance');
        $this->assertInstanceOf('ConfiguratorEntity', $instance);
        $instances = ConfiguratorEntity::getInstances();
        $this->assertInternalType('array', $instances);
        $this->assertCount(1, $instances);
        $this->assertArrayHasKey('myNameInstance', $instances);
        $this->assertEquals($instance, $instances['myNameInstance']);
    }

    public function testGetNotExistNotDefault()
    {
        $Configurator = ConfiguratorEntity::getInstance();
        $result = $Configurator->get('invalidIndex');
        $this->assertNull($result);
    }

    public function testGetNotExistWithDefault()
    {
        $Configurator = ConfiguratorEntity::getInstance();
        $result = $Configurator->get('invalidIndex', 'defaultValue');
        $this->assertEquals('defaultValue', $result);
    }

    public function testGetExistedValueWithoutDefault()
    {
        $Configurator = ConfiguratorEntity::getInstance();
        $result = $Configurator->get('modal.remote.id');
        $this->assertEquals('modal-remote', $result);
    }

    public function testGetExistedValueWithDefault()
    {
        $Configurator = ConfiguratorEntity::getInstance();
        $result = $Configurator->get('modal.remote.id', 'otherDefaultValue');
        $this->assertEquals('modal-remote', $result);
    }

    public function testHasExist()
    {
        $Configurator = ConfiguratorEntity::getInstance();
        $configs = $Configurator->getAll();
        foreach ($configs  as $key => $value) {
            $result = $Configurator->has($key);
            $this->assertTrue($result);
        }
    }

    public function testHasNotExist()
    {
        $Configurator = ConfiguratorEntity::getInstance();
        $result = $Configurator->has('not.exist.key');
        $this->assertFalse($result);
    }

    public function testMerge()
    {
        $DefaultConfigurator = ConfiguratorEntity::getInstance();
        $Configurator = ConfiguratorEntity::getInstance('other');
        $addedConfig = array(
            'Value' => 1,
            'Value2' => array(
                'Test',
            ),
            'Value3' => true,
            'modal.closeButtonLabel' => 'Autre',
        );
        $result = $Configurator->merge($addedConfig);
        $this->assertEquals($Configurator, $result);
        $config = $Configurator->getAll();
        foreach ($addedConfig as $key => $value) {
            $this->assertArrayHasKey($key, $config);
            $this->assertEquals($value, $config[$key]);
        }
        $defaultConfig = $DefaultConfigurator->getAll();
        unset($defaultConfig['modal.closeButtonLabel']);
        foreach ($defaultConfig as $key => $value) {
            $this->assertArrayHasKey($key, $config);
            $this->assertEquals($value, $config[$key]);
        }
    }

    public function testAddUnexisted()
    {
        $DefaultConfigurator = ConfiguratorEntity::getInstance();
        $Configurator = ConfiguratorEntity::getInstance('other');
        $Configurator->add('MyKey', 'MyValue');
        $result = $Configurator->has('MyKey');
        $this->assertTrue($result);

        $result = $Configurator->get('MyKey');
        $this->assertEquals('MyValue', $result);

        $config = $Configurator->getAll();
        $defaultConfig = $DefaultConfigurator->getAll();
        $this->assertCount(count($defaultConfig) + 1, $config);
        foreach ($defaultConfig as $key => $value) {
            $this->assertArrayHasKey($key, $config);
            $this->assertEquals($value, $config[$key]);
        }
        $this->assertArrayHasKey('MyKey', $config);
        $this->assertEquals('MyValue', $config['MyKey']);
    }

    public function testAddExisted()
    {
        $DefaultConfigurator = ConfiguratorEntity::getInstance();
        $Configurator = ConfiguratorEntity::getInstance('other');
        $Configurator->add('modal.closeButtonLabel', 'MyValue');
        $result = $Configurator->has('modal.closeButtonLabel');
        $this->assertTrue($result);

        $result = $Configurator->get('modal.closeButtonLabel');
        $this->assertEquals('MyValue', $result);

        $config = $Configurator->getAll();
        $defaultConfig = $DefaultConfigurator->getAll();
        $this->assertCount(count($defaultConfig), $config);
        unset($defaultConfig['modal.closeButtonLabel']);
        foreach ($defaultConfig as $key => $value) {
            $this->assertArrayHasKey($key, $config);
            $this->assertEquals($value, $config[$key]);
        }
        $this->assertArrayHasKey('modal.closeButtonLabel', $config);
        $this->assertEquals('MyValue', $config['modal.closeButtonLabel']);
    }

    public function testRemoveUnexisted()
    {
        $DefaultConfigurator = ConfiguratorEntity::getInstance();
        $Configurator = ConfiguratorEntity::getInstance('other');
        $Configurator->remove('MyKey');
        $result = $Configurator->has('MyKey');
        $this->assertFalse($result);

        $result = $Configurator->get('MyKey');
        $this->assertNull($result);

        $config = $Configurator->getAll();
        $defaultConfig = $DefaultConfigurator->getAll();
        $this->assertEquals($defaultConfig, $config);
    }

    public function testRemoveExisted()
    {
        $DefaultConfigurator = ConfiguratorEntity::getInstance();
        $Configurator = ConfiguratorEntity::getInstance('other');
        $Configurator->remove('panel.class');
        $result = $Configurator->has('panel.class');
        $this->assertFalse($result);

        $result = $Configurator->get('panel.class');
        $this->assertNull($result);

        $config = $Configurator->getAll();
        $defaultConfig = $DefaultConfigurator->getAll();
        $this->assertCount(count($defaultConfig) - 1, $config);
        unset($defaultConfig['panel.class']);
        foreach ($defaultConfig as $key => $value) {
            $this->assertArrayHasKey($key, $config);
            $this->assertEquals($value, $config[$key]);
        }
    }

    public function testSetAll()
    {
        $data = array(
            'Value1' => array(),
            'Value2' => true,
            'Value3' => 'Test',
        );
        $Configurator = ConfiguratorEntity::getInstance();
        $Configurator->setAll($data);
        $result = $Configurator->getAll();
        $this->assertEquals($data, $result);
        foreach ($data as $key => $value) {
            $result = $Configurator->has($key);
            $this->assertTrue($result);
            $result = $Configurator->get($key);
            $this->assertEquals($value, $result);
        }
    }

    public function testClearAll()
    {
        $Configurator = ConfiguratorEntity::getInstance();
        $Configurator->clearAll();
        $result = $Configurator->getAll();
        $this->assertEquals(array(), $result);
    }
}