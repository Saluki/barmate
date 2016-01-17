<?php

use App\User;

class AccountControllerTest extends TestCase
{
    /**
     * @dataProvider roleProvider
     */
    public function testIndex($role, $roleDescription)
    {
        $user = $this->getUser($role);
        $pageVisit = $this->visitPageAs($user, 'app/account');

        $pageVisit->assertResponseOk();
        $pageVisit->assertViewHas('user', $user);
        $pageVisit->assertViewHas('roleDescription', $roleDescription);
    }

    public function roleProvider()
    {
        return [
            ['USER', 'User'],
            ['MNGR', 'Manager'],
            ['ADMN', 'Administrator']
        ];
    }

    public function testIndexAsVisitor()
    {
        $this->visit('app/account')
            ->see('Sign In');
    }

    private function getUser($role = 'USER')
    {
        $email = 'user@barmate.com';

        if( $role=='MNGR' ) {
            $email = 'manager@barmate.com';
        }
        elseif( $role=='ADMN' ) {
            $email = 'administrator@barmate.com';
        }

        return User::where('email', '=', $email)->firstOrFail();
    }

    private function visitPageAs($user, $pageUrl)
    {
        return $this->actingAs($user)
            ->withSession(['groupID' => $user->group_id, 'role' => $user->role])
            ->visit($pageUrl);
    }
}