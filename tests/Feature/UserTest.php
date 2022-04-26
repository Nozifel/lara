<?php

namespace Tests\Feature;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use phpDocumentor\Reflection\Types\Resource_;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetUsers()
    {
        $user = User::factory()->make();
        
        $this->actingAs($user)
            ->get('/api/users')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'email'
                    ]
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next'
                ],
                'meta' => [
                    'current_page',
                    'from',
                    'last_page',
                    'links' => [
                        '*' => [
                            'url',
                            'label',
                            'active'
                        ]
                    ],
                    'path',
                    'per_page',
                    'to',
                    'total'
                ]
            ])
            ->assertStatus(200);
    }

    public function testGetUser()
    {
        $user = User::first();
        $resource = new UserResource($user);

        $this->actingAs($user)
            ->get('/api/users/'.$user->id)
            ->assertJson(
                json_decode( $resource->response()->getContent(), true)
            )
            ->assertStatus(200);
    }

    public function testPostUser()
    {
        $user = User::factory()->make();

        $userCreate = User::factory()->make();

        $datas = [
            'name' => $userCreate->name,
            'email' => $userCreate->email,
            'password' => 'password'
        ];

        $resource = new UserResource($userCreate);

        $response = $this->actingAs($user)
            ->postJson('/api/users', $datas)
            ->assertJson([
                'data' => [
                    'name' => $datas['name'],
                    'email' => $datas['email']
                ]
            ])
            ->assertJson(
                json_decode( $resource->response()->getContent(), true )
            )
            ->assertStatus(201);
    }

    public function testInvalidAccessUser()
    {
        $userA = User::first();

        $userB = User::where('id', '!=', $userA->id)->first();

        $this->actingAs($userA)
            ->get('/api/users/'.$userB->id)
            ->assertStatus(403);
    }
}
