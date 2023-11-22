<?php

namespace App\Services\Twitter;

class TwitterClient implements TwitterClientInterface
{
    public function __construct(protected TwitterOAuth $twitter)
    {

    }

    public function tweet(string $status): array
    {
        return (array) $this->twitter->post('statuses/update', compact('status'));
    }
}
