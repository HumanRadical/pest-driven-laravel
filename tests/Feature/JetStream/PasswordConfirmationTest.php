<?php

use App\Models\User;
use Laravel\Jetstream\Features;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('confirm password screen can be rendered', function () {
    loginAsUser(
        Features::hasTeamFeatures()
            ? User::factory()->withPersonalTeam()->create()
            : User::factory()->create()
    );

    $response = get('/user/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    loginAsUser();

    $response = post('/user/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    loginAsUser();

    $response = post('/user/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});
