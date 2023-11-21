
<div>
    <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <h3>{{ $video->title }}  {{ $video->durationInMins }}min</h3>
    <p>{{ $video->description }}</p>

    @if ($video->alreadyWatchedByCurrentUser())
        <button wire:click="markVideoAsNotCompleted">Mark as not completed</button>
    @else
        <button wire:click="markVideoAsCompleted">Mark as completed</button>
    @endif
    
    <ul>
        @foreach ($courseVideos as $courseVideo)
            @if ($this->isCurrentVideo($courseVideo))
                {{ $courseVideo->title }}
            @else 
                <a href="{{ route('pages.course-videos', $courseVideo) }}"></a>
                <li>{{ $courseVideo->title }}</li>
            @endif
        @endforeach
    </ul>
</div>