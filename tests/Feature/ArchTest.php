<?php

use Illuminate\Support\Facades\Validator;

it('finds missing debug statements', function () {
    // Act & Assert
    expect(['dd', 'dump', 'ray'])
        ->not->toBeUsed();
});

it('does not use validator facade', function () {
    // Assert
    expect(Validator::class)
        ->not->toBeUsed()
        ->ignoring('App\Actions\Fortify');
});
