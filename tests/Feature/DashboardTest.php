<?php

use App\Models\User;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    
    // プロフィールを作成して完了状態にする
    $user->profile()->create([
        'name' => 'Test User',
        'birth_date' => '1990-01-01',
        'birth_time' => '12:00',
        'birth_place_pref' => 'Tokyo',
        'longitude_adjust' => 0,
        'is_completed' => true,
        'completed_at' => now(),
    ]);

    $this->actingAs($user);

    $this->get('/dashboard')->assertStatus(200);
});