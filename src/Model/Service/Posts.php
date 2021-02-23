<?php
namespace LeoGalleguillos\Post\Model\Service;

use ArrayObject;
use MonthlyBasis\User\Model\Entity as UserEntity;
use LeoGalleguillos\Post\Model\Factory as PostFactory;
use MonthlyBasis\User\Model\Service as UserService;
use LeoGalleguillos\Post\Model\Table as PostTable;

class Posts
{
    public function __construct(
        PostFactory\Post $postFactory,
        PostTable\Post $postTable
    ) {
        $this->postFactory = $postFactory;
        $this->postTable   = $postTable;
    }

    /**
     * Get posts.
     *
     * @return ArrayObject
     */
    public function getPosts(UserEntity\User $toUserEntity) : ArrayObject
    {
        $posts = new ArrayObject();

        $arrayObjects = $this->postTable->selectWhereToUserId(
            $toUserEntity->getUserId()
        );
        foreach ($arrayObjects as $arrayObject) {
            $posts[] = $this->postFactory->buildFromArrayObject($arrayObject);
        }

        return $posts;
    }
}
