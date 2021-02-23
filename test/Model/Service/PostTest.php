<?php
namespace LeoGalleguillos\PostTest\Model\Service;

use ArrayObject;
use MonthlyBasis\User\Model\Entity as UserEntity;
use MonthlyBasis\User\Model\Factory as UserFactory;
use LeoGalleguillos\Post\Model\Service as PostService;
use LeoGalleguillos\Post\Model\Table as PostTable;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    protected function setUp(): void
    {
        $this->postTableMock = $this->createMock(
            PostTable\Post::class
        );
        $this->postService = new PostService\Post(
            $this->postTableMock
        );
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PostService\Post::class,
            $this->postService
        );
    }

    public function testSubmitPost()
    {
        $this->postTableMock->method('insert')->willReturn(789);

        $this->assertTrue(
            $this->postService->submitPost(
                (new UserEntity\User())->setUserId(123),
                (new UserEntity\User())->setUserId(456),
                'this is the message'
            )
        );
    }
}
