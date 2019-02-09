<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Tests\Post\Domain\Model;

use App\Post\Domain\ValueObject\PostContent;
use App\Post\Domain\ValueObject\PostSlug;
use PHPUnit\Framework\TestCase;

/**
 * Class PostSlugTest.
 */
class PostSlugTest extends TestCase
{
    public function testCreateArticleContent()
    {
        $articleSlug = new PostSlug(new PostContent('title of my article !!!', 'lorem ipsum'));

        $this->assertInstanceOf(PostSlug::class, $articleSlug);

        $this->assertSame('title-of-my-article', $articleSlug->getValue());
    }

    /**
     * @expectedException \App\Post\Domain\Exception\PostContentEmptyException
     */
    public function testArticleSlugWithEmptyArticleContent()
    {
        new PostSlug(new PostContent('', ''));
    }
}
