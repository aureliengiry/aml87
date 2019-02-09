<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace Tests\Post\Domain\Model;

use App\Post\Domain\Model\Post;
use App\Post\Domain\ValueObject\PostContent;
use App\Post\Domain\ValueObject\PostUuid;
use PHPUnit\Framework\TestCase;

/**
 * Class PostTest.
 */
class PostTest extends TestCase
{
    public function testCreateSimpleArticle()
    {
        $post = new Post(new PostUuid(), new PostContent('post title', 'post body'));

        $this->assertInstanceOf(Post::class, $post);

        $this->assertInstanceOf(PostUuid::class, $post->getUuid());
        $this->assertNotNull($post->getUuid());

        $this->assertInstanceOf(PostContent::class, $post->getContent());

        $this->assertInstanceOf(\DateTimeImmutable::class, $post->getCreatedAt());
        $this->assertNotNull($post->getCreatedAt());
    }

    /**
     * @expectedException \App\Post\Domain\Exception\PostContentEmptyException
     */
    public function testCreateEmptyPost()
    {
        new Post(new PostUuid(), new PostContent('', ''));
    }
}
