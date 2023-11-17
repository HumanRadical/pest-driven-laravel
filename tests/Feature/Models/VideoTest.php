<?php

use App\Models\Video;

it('gives back readable video duration', function () {
    // Arrange
    $video = Video::factory()->create(['durationInMins' => 10]);

    // Act & Arrange
    expect($video->getReadableDuration())->toEqual('10min');
});

