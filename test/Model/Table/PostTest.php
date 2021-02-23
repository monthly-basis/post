<?php
namespace MonthlyBasis\PostTest\Model\Table;

use ArrayObject;
use MonthlyBasis\Post\Model\Table as PostTable;
use MonthlyBasis\User\Model\Table as UserTable;
use MonthlyBasis\UserTest\TableTestCase;
use Laminas\Db\Adapter\Adapter;
use PHPUnit\Framework\TestCase;
use Laminas\Db\Adapter\Exception\InvalidQueryException;

class PostTest extends TableTestCase
{
    /**
     * @var string
     */
    protected $sqlPath = __DIR__ . '/../../..' . '/sql/leogalle_test/post/';

    protected function setUp(): void
    {
        $configArray     = require(__DIR__ . '/../../../config/autoload/local.php');
        $configArray     = $configArray['db']['adapters']['leogalle_test'];
        $this->adapter   = new Adapter($configArray);

        $this->setForeignKeyChecks0();
        $this->dropTables();
        $this->createTables();
        $this->setForeignKeyChecks1();

        $this->postTable = new PostTable\Post($this->adapter);
        $this->userTable = new UserTable\User($this->adapter);
    }

    protected function dropTables()
    {
        $sql = file_get_contents($this->sqlDirectory . '/leogalle_test/user/drop.sql');
        $result = $this->adapter->query($sql)->execute();

        $sql = file_get_contents($this->sqlDirectory . '/leogalle_test/post/drop.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    protected function createTables()
    {
        $sql = file_get_contents($this->sqlDirectory . '/leogalle_test/user/create.sql');
        $result = $this->adapter->query($sql)->execute();

        $sql = file_get_contents($this->sqlDirectory . '/leogalle_test/post/create.sql');
        $result = $this->adapter->query($sql)->execute();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            PostTable\Post::class,
            $this->postTable
        );
    }

    public function testInsert()
    {
        try {
            $this->postTable->insert(1, 2, 'message');
            $this->fail();
        } catch (InvalidQueryException $exception) {
            $this->assertInstanceOf(InvalidQueryException::class, $exception);
        }

        $this->userTable->insert(
            'username',
            'password hash',
            '1000-01-01 00:00:00'
        );

        try {
            $this->postTable->insert(1, 2, 'message');
            $this->fail();
        } catch (InvalidQueryException $exception) {
            $this->assertInstanceOf(InvalidQueryException::class, $exception);
        }

        $this->userTable->insert(
            'another_username',
            'password hash',
            '1000-01-01 00:00:00'
        );

        $this->assertSame(
            3,
            $this->postTable->insert(1, 2, 'message')
        );
    }

    public function testSelectCount()
    {
        $this->assertSame(
            0,
            $this->postTable->selectCount()
        );
    }

    public function testSelectCountWhereToUserId()
    {
        $this->assertSame(
            0,
            $this->postTable->selectCountWhereToUserId(123)
        );
        $this->userTable->insert(
            'username',
            'password hash',
            '1980-01-12 12:34:56'
        );
        $this->userTable->insert(
            'username2',
            'password hash',
            '1980-01-12 12:34:56'
        );
        $this->userTable->insert(
            'username3',
            'password hash',
            '1000-01-01 00:00:00'
        );
        $this->postTable->insert(1, 2, 'message');
        $this->postTable->insert(2, 1, 'another message');
        $this->postTable->insert(1, 2, 'another message');
        $this->postTable->insert(3, 1, 'another message');
        $this->assertSame(
            2,
            $this->postTable->selectCountWhereToUserId(1)
        );
    }

    public function testSelectWhereToUserId()
    {
        $this->assertEmpty(
            $this->postTable->selectWhereToUserId(2)
        );

        $this->userTable->insert(
            'username',
            'password hash',
            '1980-01-01 01:23:45'
        );
        $this->userTable->insert(
            'username2',
            'password hash',
            '1980-01-01 01:23:45'
        );
        $this->userTable->insert(
            'username3',
            'password hash',
            '1980-01-01 01:23:45'
        );
        $this->postTable->insert(1, 2, 'message');
        $this->postTable->insert(3, 2, 'another message');

        $arrayObjects = new ArrayObject([
            new ArrayObject([
                'post_id' => '2',
                'from_user_user_id' => '3',
                'from_user_username' => 'username3',
                'to_user_user_id' => '2',
                'to_user_username' => 'username2',
                'message' => 'another message',
            ]),
            new ArrayObject([
                'post_id' => '1',
                'from_user_user_id' => '1',
                'from_user_username' => 'username',
                'to_user_user_id' => '2',
                'to_user_username' => 'username2',
                'message' => 'message',
            ]),
        ]);

        $this->assertEquals(
            $arrayObjects[0]['to_user_user_id'],
            $this->postTable->selectWhereToUserId(2)[0]['to_user_user_id']
        );

        $this->assertEquals(
            $arrayObjects[1]['message'],
            $this->postTable->selectWhereToUserId(2)[1]['message']
        );

        $this->assertEmpty(
            $this->postTable->selectWhereToUserId(1)
        );
        $this->assertEmpty(
            $this->postTable->selectWhereToUserId(3)
        );
    }
}
