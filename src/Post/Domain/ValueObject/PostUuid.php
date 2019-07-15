<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;

/**
 * Class PostUuid.
 */
class PostUuid
{
    private $value;

    public function __construct()
    {
        $uuid = RamseyUuid::uuid1();

        $this->guard($uuid);

        $this->value = $uuid;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function guard($id): void
    {
        if (!RamseyUuid::isValid($id)) {
            throw new \InvalidArgumentException(
                \sprintf('<%s> does not allow the value <%s>.', static::class, \is_scalar($id) ? $id : \gettype($id))
            );
        }
    }

    public function __toString()
    {
        return $this->value();
    }
}
