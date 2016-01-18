<?php

use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AccountControllerTest extends TestCase
{
    use WithoutMiddleware;

    protected $userRepositoryMock;

    public function setUp()
    {
        parent::setUp();

        $this->userRepositoryMock = $this->mock('App\Repositories\UserRepository');

        // To avoid problems with the auth() helper
        $this->be(new User);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testIndex()
    {
        $this->userRepositoryMock
            ->shouldReceive('get')
            ->once()
            ->andReturn(new User(['role'=>'USER']));

        $this->get('/app/account');

        $this->assertResponseOk();
        $this->assertViewHas('user');
        $this->assertViewHas('roleDescription');
    }

    public function testSaveProfile()
    {
        $this->userRepositoryMock
            ->shouldReceive('updateAccount')
            ->once();

        $this->post('/app/account');

        $this->assertRedirectedTo('/app/account');
    }

    public function mock($className)
    {
        // Creating a new mock
        $mock = Mockery::mock($className);

        // Ask Laravel IoC to return mocked object when asking for 'className'
        $this->app->instance($className, $mock);

        return $mock;
    }
}