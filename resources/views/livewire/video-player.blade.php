
<div>
    <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <h3>{{ $video->title }}  {{ $video->durationInMins }}min</h3>
    <p>{{ $video->description }}</p>
    
    <ul>
        @foreach ($courseVideos as $courseVideo)
            @if ($this->video->id === $courseVideo->id)
                {{ $courseVideo->title }}
            @else 
                <a href="{{ route('pages.course-videos', $courseVideo) }}"></a>
                <li>{{ $courseVideo->title }}</li>
            @endif
        @endforeach
    </ul>
</div>