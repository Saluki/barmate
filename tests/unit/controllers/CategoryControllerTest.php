<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Exceptions\RepositoryException;

class CategoryControllerTest extends TestCase
{
    // Disable all middleware for the test class
    use WithoutMiddleware;

    // The mocked repository
    protected $categoryRepositoryMock;

    public function setUp()
    {
        parent::setUp();

        // Mock the category repository
        $this->categoryRepositoryMock = $this->mock('App\Repositories\CategoryRepository');
    }

    public function tearDown()
    {
        // Clean Mockery after each test
        // to not interfere with the others
        Mockery::close();
    }

    public function testIndex()
    {
        $this->categoryRepositoryMock
            ->shouldReceive('allAPI')
            ->once()
            ->andReturn([]);

        $this->get('/app/stock/category');

        $this->assertResponseOk();
    }

    public function testStore()
    {
        $this->categoryRepositoryMock
            ->shouldReceive('store')
            ->once()
            ->andReturn(42);

        $this->post('/app/stock/category', ['title' => 'Category A', 'description' => 'Description']);

        $this->assertResponseOk();
        $this->seeJson([
           'id' => 42
        ]);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testStoreValidation($title, $description)
    {
        $this->categoryRepositoryMock
            ->shouldNotReceive('store');

        $this->post('/app/stock/category', ['title' => $title, 'description' => $description]);

        $this->assertResponseStatus(400);
        $this->seeJson([
            'code' => 1,
        ]);
    }

    public function testStoreRepositoryError()
    {
        $this->categoryRepositoryMock
            ->shouldReceive('store')
            ->once()
            ->andThrow(new RepositoryException());

        $this->post('/app/stock/category', ['title' => 'Product A']);

        $this->assertResponseStatus(400);
        $this->seeJson([
            'code' => 2
        ]);
    }

    public function mock($className)
    {
        // Creating a new mock
        $mock = Mockery::mock($className);

        // Ask Laravel IoC to return mocked object when asking for 'className'
        $this->app->instance($className, $mock);

        return $mock;
    }

    public function invalidDataProvider()
    {
        return [
            // Too long title
            ['AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA', ''],
            // Title containing invalid characters
            ['&é§è§', ''],
            // Empty title
            ['', '']
        ];
    }
}