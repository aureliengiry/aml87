<?php

namespace Tests\UrlRewriteBundle\Utils;

use PHPUnit\Framework\TestCase;

use Aml\Bundle\UrlRewriteBundle\Utils\Slugger;

class SluggerTest extends TestCase
{
    public function testSluggify()
    {
        $inputString = "aAa & à Ù on utilise php7 pour la mongo v2 ou ~ pas ?";
        $expectedString = "aaa-a-u-on-utilise-php7-pour-la-mongo-v2-ou-pas";

        $slugger = new Slugger();
        $result = $slugger->slugify($inputString);

        $this->assertEquals($expectedString, $result);
    }
}
