<?php

namespace Cybalex\TestHelpers;

/**
 * @author Zymovets Oleksii <cybalex87@gmail.com>
 */
trait DtoTestHelperTrait
{
    /**
     * @var object
     */
    protected $entity;

    public function DTOSetUp(): void
    {
        $className = $this->getEntityClass();
        $arguments = array_map(
            function ($argumentConfig) {
                return $argumentConfig[1];
            },
            $this->getConstructorConfig()
        );

        $this->entity = new $className(...$arguments);
    }

    /**
     * @dataProvider getConstructorConfig
     * @param string $propertyName
     * @param mixed $value
     * @param array $options
     */
    public function testDtoGetters(string $propertyName, $value, array $options = []): void
    {
        if (!$this->entity) {
            $this->fail(
                sprintf(
                    '\'DTOSetUp\' method of \'DtoTestHelperTrait\' was not called in \'setUp()\' method of \'%s\'',
                    __CLASS__
                )
            );
        }

        foreach ($this->getConstructorConfig() as $argumentConfig) {
            $getter = isset($options['getterName']) ? $options['getterName'] : 'get' . ucfirst($propertyName);

            $this->assertSame($value, $this->entity->$getter());
        }
    }

    /**
     * @return array
     *
     * Usage example:
     *
     * $userManager = $this->createMock(... ;
     * $eventSubscriber = $this->createMock(... ;
     *
     *   return [
     *     ['userManager', $userManager, ['getterName' => 'getManager']],
     *     ['eventSubscriber', $eventSubscriber],
     * ];
     *
     * Attention! The order of the constructor args is important!
     */
    abstract public function getConstructorConfig(): array;

    /**
     * @return string
     */
    abstract protected function getEntityClass(): string;
}
