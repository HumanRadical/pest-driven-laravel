<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getReadableDuration(): string
    {
        return Str::of($this->durationInMins)->append('min');
    }
    
    public function alreadyWatchedByCurrentUser(): bool
    {
        return (bool) auth()->user()->watchedVideos()->where('video_id', $this->id)->count();
    }
}
