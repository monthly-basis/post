<?php
namespace LeoGalleguillos\Post\Model\Service\Posts;

use MonthlyBasis\User\Model\Entity as UserEntity;
use LeoGalleguillos\Post\Model\Table as PostTable;

class NumberOfPosts
{
    public function __construct(
        PostTable\Post $postTable
    ) {
        $this->postTable   = $postTable;
    }

    /**
     * Get number of posts.
     *
     * @param UserEntity\User $toUserEntity
     * @return int
     */
    public function getNumberOfPosts(UserEntity\User $toUserEntity) : int
    {
        return $this->postTable->selectCountWhereToUserId(
            $toUserEntity->getUserId()
        );
    }
}
