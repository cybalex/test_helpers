<?php

namespace Cybalex\TestHelpers\Tests;

use Cybalex\TestHelpers\GettersAndSettersTestTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class StringNormalizer {
    public function normalize(string $string)
    {
        return strtoupper(trim($string));
    }
}

class User {
    private $username;
    private $password;
    private $score;
    private $enabled;
    private $stringNormalizer;

    public function __construct(StringNormalizer $stringNormalizer) {
        $this->stringNormalizer = $stringNormalizer;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getNormalizedUsername()
    {
        return $this->stringNormalizer->normalize($this->getUsername());
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setPassword($password): User
    {
        $this->password = 'Hashed' . $password;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setScore($score): User
    {
        $this->score = $score;

        return $this;
    }

    public function getScoreRounded(): int
    {
        return (int) round($this->score);
    }

    public function isEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }
}

class GettersAndSettersTestTraitUserTest extends TestCase
{
    use GettersAndSettersTestTrait;

    /** @var StringNormalizer|MockObject */
    private $stringNormalizer;

    public function gettersAndSettersDataProvider(): array
    {
        return [
            ['username', 'John', null, ['chainCall' => false]],
            ['password', 'Password', 'HashedPassword'],
            ['score', 101.67, 102, ['getterName' => 'getScoreRounded']],
            ['enabled', true, null, ['setterName' => 'isEnabled', 'chainCall' => false]],
        ];
    }

    public static function getEntityClass(): string
    {
        return User::class;
    }

    public function testGetNormalizedUsername()
    {
        $this->entity->setUserName(' John ');
        $this->stringNormalizer->expects(static::once())->method('normalize')->with(' John ')->willReturn('JOHN');
        $this->assertEquals('JOHN', $this->entity->getNormalizedUsername());
    }

    protected function getConstructorArguments(): array
    {
        $this->stringNormalizer = $this->createMock(StringNormalizer::class);

        return [$this->stringNormalizer];
    }
}
