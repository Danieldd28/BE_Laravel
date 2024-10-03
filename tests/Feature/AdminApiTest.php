<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use function Pest\Laravel\{actingAs, getJson, postJson, putJson, deleteJson};

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->user = User::factory()->create(['id_user' => 2]);
});

it('can retrieve all users', function () {
    actingAs($this->admin, 'api');
    $response = getJson('/api/admin/users');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'users' => [
                '*' => ['id_user', 'nama_user', 'role', 'username']
            ]
        ]);
});


it('can create a new user', function () {
    actingAs($this->admin, 'api');
    $userData = [
        'nama_user' => 'John Doe',
        'role' => 'admin',
        'username' => 'johndoe',
        'password' => 'password123',
    ];
    $response = postJson('/api/admin/users', $userData);
    $response->assertStatus(201)
        ->assertJsonFragment(['nama_user' => 'John Doe']);
});

it('can update a user', function () {
    actingAs($this->admin, 'api');
    $updateData = ['nama_user' => 'Jane Doe'];
    $response = putJson('/api/admin/users/2', $updateData);
    $response->assertStatus(200)
        ->assertJsonFragment(['nama_user' => 'Jane Doe']);
});

it('can delete a user', function () {
    actingAs($this->admin, 'api');
    $response = deleteJson('/api/admin/users/2');
    $response->assertStatus(204);
});
