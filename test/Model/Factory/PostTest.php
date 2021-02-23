<?php
namespace MonthlyBasis\PostTest\Model\Factory;

use ArrayObject;
use DateTime;
use MonthlyBasis\Post\Model\Entity as PostEntity;
use MonthlyBasis\Post\Model\Factory as PostFactory;
use MonthlyBasis\User\Model\Entity as UserEntity;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    protected function setUp(): void
    {
        $this->postFactory = new PostFactory\Post();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PostFactory\Post::class,
            $this->postFactory
        );
    }

    public function testBuildFromArrayObject()
    {
        $arrayObject = new ArrayObject([
            'post_id'            => 123,
            'from_user_user_id'  => 456,
            'from_user_username' => 'username1',
            'to_user_user_id'    => 789,
            'to_user_username'   => 'username2',
            'message'            => 'this is the message',
            'created'            => '2018-01-29 19:46:03',
        ]);

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

        $this->assertEquals(
            $postEntity,
            $this->postFactory->buildFromArrayObject($arrayObject)
        );
    }
}
