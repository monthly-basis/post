<?php
namespace LeoGalleguillos\PostTest\Model\Entity;

use LeoGalleguillos\Post\Model\Entity as PostEntity;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    protected function setUp(): void
    {
        $this->postEntity = new PostEntity\Post();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PostEntity\Post::class,
            $this->postEntity
        );
    }
}
