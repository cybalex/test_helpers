<?php

namespace Cybalex\TestHelpers;

use PHPUnit\Framework\MockObject\MockBuilder;

/**
 * @author Zymovets Oleksii <cybalex87@gmail.com>
 */
trait GettersAndSettersTestTrait
{
    /**
     * The tested entity object.
     *
     * @var object
     */
    protected $entity;

    /**
     * This method is called before each test.
     */
    public function setUp(): void
    {
        $this->gettersAndSetterSetUp();
    }

    /**
     * Data provider for testing getter and setter methods of an entity.
     *
     * Usage example:
     * return [
     *   ['name', 'John'],
     *   ['iq', 90.75, 91, ['setterName' => 'setIqRounded', 'getterName' => 'getIqRounded', 'chainCall' => false]]
     * ];
     * Result: this will test the following:
     *   1/ $entity->setName('John')  will return the instance of $entity (chain call test)
     *   2/ $entity->getName() will return 'John'
     */
    abstract public function gettersAndSettersDataProvider(): array;

    /**
     * Return the name of the tested class.
     * Usage example:
     *   return User::class;.
     */
    abstract public function getEntityClass(): string;

    /**
     * @dataProvider gettersAndSettersDataProvider
     *
     * @param mixed $setValue
     * @param mixed $getValue
     */
    public function testGettersAndSetters(string $propertyName, $setValue, $getValue = null, array $options = [])
    {
        $setter = \array_key_exists('setterName', $options) ? $options['setterName'] : 'set'.ucfirst($propertyName);
        $getter = \array_key_exists('getterName', $options) ? $options['getterName'] : 'get'.ucfirst($propertyName);

        if (\array_key_exists('chainCall', $options) && false === $options['chainCall']) {
            $this->entity->$setter($setValue);
        } else {
            $this->assertSame($this->entity, $this->entity->$setter($setValue));
        }

        $this->assertSame($getValue ?? $setValue, $this->entity->$getter());
    }

    protected function gettersAndSetterSetUp(): void
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
     * Override this method to pass constructor arguments to entity.
     */
    protected function getConstructorArguments(): array
    {
        return [];
    }

    /**
     * Override this method to mock methods of entity.
     *
     * Example:
     *   return ['getName']
     *
     * getName method of entity will be mocked
     */
    protected function getMockedMethods(): array
    {
        return [];
    }
}
