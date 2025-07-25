<?php
// src/Event/NewPostCreatedEvent.php
namespace App\Event;

use App\Entity\Post;
use Symfony\Contracts\EventDispatcher\Event;

class NewPostCreatedEvent extends Event
{
    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getPost(): Post
    {
        return $this->post;
    }
}
