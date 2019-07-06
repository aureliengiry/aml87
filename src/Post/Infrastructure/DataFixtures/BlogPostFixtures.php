<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Infrastructure\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Post\Domain\ValueObject\PostUuid;
use App\Post\Domain\ValueObject\PostContent;
use App\Post\Domain\Model\Post;


/**
 * Class BlogPostFixtures.
 */
class BlogPostFixtures extends Fixture
{
    public function load(ObjectManager $manager) : void
    {

        for ($i = 1; $i <= 50; $i++) {
            $post = new Post(
                new PostUuid(),
                new PostContent('title ' . $i, 'main content of post ' . $i),
                null,
                null,
                (bool)random_int(0, 1)
            );

            $manager->persist($post);
        }
        
        $manager->flush();
    }
}
