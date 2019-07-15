<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Tests\Core\Utils;

use App\Core\Domain\Utils\Slugger;
use PHPUnit\Framework\TestCase;

/**
 * Class SluggerTest.
 */
class SluggerTest extends TestCase
{
    public function testSluggify()
    {
        $inputString = 'aAa & à Ù on utilise php7 pour la mongo v2 ou ~ pas ?';
        $expectedString = 'aaa-a-u-on-utilise-php7-pour-la-mongo-v2-ou-pas';

        $slugger = new Slugger();
        $result = $slugger->slugify($inputString);

        $this->assertSame($expectedString, $result);
    }
}
