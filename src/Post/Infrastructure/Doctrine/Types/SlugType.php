<?php

namespace App\Post\Infrastructure\Doctrine\Types;

use App\Post\Domain\ValueObject\PostSlug;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class SlugType extends Type
{
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @param string $value
     * @return PostSlug
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new PostSlug($value);
    }

    /**
     * @param PostSlug $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->content();
    }

    public function getName()
    {
        return 'post_slug';
    }
}