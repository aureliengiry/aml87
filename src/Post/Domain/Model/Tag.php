<?php

/*
 * This file is part of the AML87 application.
 * (c) Aurélien GIRY <aurelien.giry@gmail.com>
 */

namespace App\Post\Domain\Model;

class Tag
{
    private $id;
    private $post;
    private $label;
    private $key;

    /**
     * Tag constructor.
     * @param Post $post
     * @param string $label
     * @param string $key
     */
    public function __construct(Post $post, string $label, string $key)
    {
        $this->post = $post;
        $this->label = $label;
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return null|int
     */
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }


}
