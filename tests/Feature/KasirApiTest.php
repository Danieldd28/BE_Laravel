<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Meja;
use App\Models\Menu;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

// Setup a kasir user and the required records for meja, menu, etc.
beforeEach(function () {
    $this->kasir = User::factory()->create(['role' => 'kasir']);
    $this->user = User::factory()->create(['id_user' => 1]);

    // Create required records for Meja and Menu
    Meja::factory()->create(['id_meja' => 1, 'nomor_meja' => 1, 'status' => 'available']);
    Menu::factory()->create(['id_menu' => 1]);
    Menu::factory()->create(['id_menu' => 2]);
});

it('can create a new transaksi', function () {
    actingAs($this->kasir, 'api');

    $transaksiData = [
        'nama_pelanggan' => 'John Doe',
        'id_meja' => 1,
        'id_user' => $this->kasir->id_user,
        'status' => 'belum_bayar',
        'items' => [
            ['id_menu' => 1, 'jumlah' => 2, 'harga' => 10000],
            ['id_menu' => 2, 'jumlah' => 1, 'harga' => 15000],
        ],
    ];

    $response = postJson('/api/kasir/transaksis', $transaksiData);
    $response->assertStatus(201)
        ->assertJsonFragment(['nama_pelanggan' => 'John Doe']);


    // Send POST request to create a new transaksi
    $response = postJson('/api/kasir/transaksis', $transaksiData);

    // Assert response status and structure
    $response->assertStatus(201)
        ->assertJsonFragment(['nama_pelanggan' => 'John Doe']);
});
