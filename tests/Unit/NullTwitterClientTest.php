<?php

use App\Services\Twitter\NullTwitterClient;

it('returns empty array for a tweet call', function () {
    expect(new NullTwitterClient())
        ->tweet('New tweet')
        ->toBeArray()
        ->toBeEmpty();
});
