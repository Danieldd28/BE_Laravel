<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Transaksi;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create a manajer user
    $this->manajer = User::factory()->create(['role' => 'manajer']);
});

it('can retrieve all transaksis as manajer', function () {
    actingAs($this->manajer, 'api');

    // Create 3 transactions
    Transaksi::factory()->create(['tgl_transaksi' => now()->subDays(5)]);
    Transaksi::factory()->create(['tgl_transaksi' => now()->subDays(3)]);
    Transaksi::factory()->create(['tgl_transaksi' => now()->subDays(1)]);

    // Call the API to retrieve all transactions
    $response = getJson('/api/manajer/transaksis');

    // Assert that the response has 200 status and contains 3 records in the "transaksis" key
    $response->assertStatus(200)
        ->assertJsonCount(3, 'transaksis');
});

it('can filter transaksis by date', function () {
    actingAs($this->manajer, 'api');

    // Set the date range for the filter
    $startDate = now()->subDays(7)->format('Y-m-d');
    $endDate = now()->format('Y-m-d');

    // Create 3 transactions within the date range
    Transaksi::factory()->create(['tgl_transaksi' => now()->subDays(5)]);
    Transaksi::factory()->create(['tgl_transaksi' => now()->subDays(3)]);
    Transaksi::factory()->create(['tgl_transaksi' => now()->subDays(1)]);

    // Call the API to filter transactions by the date range
    $response = getJson("/api/manajer/transaksis/filter?start_date={$startDate}&end_date={$endDate}");

    // Assert that the response has 200 status and contains 3 records in the "transaksis" key
    $response->assertStatus(200)
        ->assertJsonCount(3, 'transaksis');
});

