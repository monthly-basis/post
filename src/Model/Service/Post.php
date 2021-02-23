<?php
namespace LeoGalleguillos\Post\Model\Service;

use ArrayObject;
use LeoGalleguillos\Post\Model\Entity as PostEntity;
use LeoGalleguillos\Post\Model\Table as PostTable;
use MonthlyBasis\User\Model\Entity as UserEntity;
use MonthlyBasis\User\Model\Factory as UserFactory;
use MonthlyBasis\User\Model\Service as UserService;

class Post
{
    public function __construct(
        PostTable\Post $postTable
    ) {
        $this->postTable   = $postTable;
    }

    /**
     * Submit post.
     *
     * @return ArrayObject
     */
    public function submitPost(
        UserEntity\User $fromUserEntity,
        UserEntity\User $toUserEntity,
        string $message
    ) {
        return (bool) $this->postTable->insert(
            $fromUserEntity->getUserId(),
            $toUserEntity->getUserId(),
            $message
        );
    }
}
