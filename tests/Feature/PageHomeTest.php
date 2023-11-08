<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows courses overview', function () {
    Course::factory()->create(['title' => 'Course A']);
    Course::factory()->create(['title' => 'Course B']);
    Course::factory()->create(['title' => 'Course C']);

    get(route('home'))
        ->assertSeeText([
            'Course A',
            'Course B',
            'Course C',
        ]);
});

it('shows only released courses', function () {
    //expect()->
});

it('shows courses by release date', function () {
    //expect()->
});