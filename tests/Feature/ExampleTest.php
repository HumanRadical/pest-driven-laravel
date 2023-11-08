<?php

use function Pest\Laravel\get;

it('returns a successful response for home page', function () {
    // Act & Assert
    get(route('home'))
        ->assertOk();
});
