<?php
namespace MonthlyBasis\Post\Model\Entity;

use DateTime;
use MonthlyBasis\Post\Model\Entity as PostEntity;
use MonthlyBasis\User\Model\Entity as UserEntity;

class Post
{
    protected $postId;
    protected $fromUser;
    protected $message;
    protected $toUser;
    protected $dateTime;

    public function getCreated() : DateTime
    {
        return $this->created;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getFromUser()
    {
        return $this->fromUser;
    }

    public function setCreated(DateTime $created) : PostEntity\Post
    {
        $this->created = $created;
        return $this;
    }

    public function setMessage(string $message) : PostEntity\Post
    {
        $this->message = $message;
        return $this;
    }

    public function setPostId(int $postId) : PostEntity\Post
    {
        $this->postId = $postId;
        return $this;
    }

    public function setFromUser(UserEntity\User $fromUser) : PostEntity\Post
    {
        $this->fromUser = $fromUser;
        return $this;
    }

    public function setToUser(UserEntity\User $toUser) : PostEntity\Post
    {
        $this->toUser = $toUser;
        return $this;
    }
}
