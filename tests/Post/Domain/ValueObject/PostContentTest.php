<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Tests\Post\Domain\Model;

use App\Post\Domain\ValueObject\PostContent;
use PHPUnit\Framework\TestCase;

/**
 * Class PostContentTest.
 */
class PostContentTest extends TestCase
{
    public function testCreateArticleContent()
    {
        $articleContent = new PostContent('title', 'lorem ipsum');

        $this->assertInstanceOf(PostContent::class, $articleContent);

        $this->assertSame('title', $articleContent->getTitle());
        $this->assertSame('lorem ipsum', $articleContent->getBody());
    }

    /**
     * @expectedException \App\Post\Domain\Exception\PostContentEmptyException
     */
    public function testCreateEmptyArticleContent()
    {
        new PostContent('', '');
    }
}
