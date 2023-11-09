<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('cannot be accessed by a guest', function () {
    // Act & Assert
    get(route('dashboard'))
        ->assertRedirect(route('login'));
});

it('lists purchased courses', function () {
    //expect()->
});

it('does not list unpurchased courses', function () {
    //expect()->
});

it('shows latest purchased course first', function () {
    //expect()->
});

it('includes link to product videos', function () {
    //expect()->
});
