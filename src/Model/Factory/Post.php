<?php
namespace MonthlyBasis\Post\Model\Factory;

use ArrayObject;
use DateTime;
use MonthlyBasis\Post\Model\Entity as PostEntity;
use MonthlyBasis\User\Model\Entity as UserEntity;
use MonthlyBasis\User\Model\Factory as UserFactory;

class Post
{
    /**
     * Build from array object.
     *
     * @param ArrayObject $arrayObject
     * @return PostEntity\Post
     */
    public function buildFromArrayObject(
        ArrayObject $arrayObject
    ) : PostEntity\Post {
        $fromUserEntity = new UserEntity\User();
        $fromUserEntity->setUserId($arrayObject['from_user_user_id']);
        $fromUserEntity->username = $arrayObject['from_user_username'];

        $toUserEntity = new UserEntity\User();
        $toUserEntity->setUserId($arrayObject['to_user_user_id']);
        $toUserEntity->username = $arrayObject['to_user_username'];

        $created = new DateTime($arrayObject['created']);

        $postEntity = new PostEntity\Post();
        $postEntity->setCreated($created)
                   ->setFromUser($fromUserEntity)
                   ->setMessage($arrayObject['message'])
                   ->setPostId($arrayObject['post_id'])
                   ->setToUser($toUserEntity);

        return $postEntity;
    }
}
