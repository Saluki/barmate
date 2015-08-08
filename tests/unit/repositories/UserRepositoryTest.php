<?php

use App\Repositories\UserRepository;

class UserRepositoryTest extends TestCase
{
    protected $userRepository;

    public function setUp()
    {
        parent::setUp();

        $this->prepareForTests();
        $this->userRepository = new UserRepository($this->app);
    }
}