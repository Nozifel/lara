<?php

namespace Tests\Feature;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*public function testGetToken()
    {
        $response = $this->get('/sanctum/csrf-cookie');

        $response->assertStatus(204)
            ->assertCookie('XSRF-TOKEN');

        $cookie = $response->getCookie('XSRF-TOKEN')->getValue();
        
        return $cookie;
    }*/

    public function testLogin()
    {
        //$cookie = $this->testGetToken();

        $password = 'password';

        $user = User::factory()->create([
            'password' => Hash::make($password)
        ]);

        $auth = [
            'email' => $user->email,
            'password' => $password
        ];
        $resource = new UserResource($user);

        $response = $this/*->withHeaders([
                'X-XSRF-TOKEN', $cookie
            ])*/
            ->postJson('/auth/login', $auth)
            ->assertJsonStructure(
                [
                    'token',
                    'user'
                ]
            )
            ->assertJsonPath(
                'user',
                json_decode( $resource->response()->getContent(), true )['data']
            )
            ->assertStatus(200);

            return json_decode($response->getContent())->token;
    }

    public function testLogout()
    {
        $token = $this->testLogin();
        
        $this->withHeaders([
                'Bearer ', $token
            ])
            ->post('/auth/logout')
            ->assertstatus(200);
    }

    public function testInvalidCredentials()
    {
        $token = $this->testLogin();

        $auth = [
            'email' => 'test@cicd.biz',
            'password' => 'aze'
        ];

        $this->withoutExceptionHandling()
            ->expectException(InvalidCredentialsException::class);

        $this->withHeaders([
                'Bearer ', $token
            ])
            ->postJson('/auth/login', $auth);
    }
}
