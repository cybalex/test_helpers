<?php

namespace Cybalex\TestHelpers;

use PHPUnit\Framework\MockObject\MockBuilder;

Trait GettersAndSettersTestTrait
{
    use TestHelperConstraintTrait;

    /**
     * @var object
     */
    protected $entity;

    /**
     * GettersAndSettersTestTrait constructor.
     *
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->checkContext();
    }

    public function setUp(): void
    {
        /** @var MockBuilder $mockBuilder */
        $mockBuilder = $this->getMockBuilder($this->getEntityClass());
        $this->entity = $mockBuilder
            ->addMethods($this->getMockedMethods())
            ->setConstructorArgs($this->getConstructorArguments())
            ->getMock()
        ;
    }

    /**
     * Data provider for testing getter and setter methods of an entity
     *
     * Usage example:
     * return [
     *   ['name', 'John'],
     * ];
     * Result: this will test the following:
     *   1/ $entity->setName('John')  will return the instance of $entity (chain call test)
     *   2/ $entity->getName() will return 'John'
     *
     * @return array
     */
    abstract function gettersAndSettersDataProvider(): array;

    abstract function getEntityClass();

    /**
     * @dataProvider gettersAndSettersDataProvider
     * @param string $propertyName
     * @param mixed $value
     */
    public function testGettersAndSetters(string $propertyName, $value)
    {
        $setter = 'set'.ucfirst($propertyName);
        $getter = 'get'.ucfirst($propertyName);

        $this->assertSame($this->entity, $this->entity->$setter($value));
        $this->assertEquals($value, $this->entity->$getter());
    }

    /**
     * Override this method to pass constructor arguments to entity
     *
     * @return array
     */
    protected function getConstructorArguments(): array
    {
        return [];
    }

    /**
     * Example:
     * Override this method to mock methods of entity
     * return ['getName']
     * getName method of entity will be mocked
     *
     * @return array
     */
    protected function getMockedMethods(): array
    {
        return [];
    }
}
