<div>
    <iframe src="https://player.vimeo.com/video/{{ $video->vimeo_id }}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <h3>{{ $video->title }}  {{ $video->durationInMins }}min</h3>
    <p>{{ $video->description }}</p>
</div>
<ul>
    @foreach ($courseVideos as $courseVideo)
        <li>{{ $courseVideo->title }}</li>
    @endforeach
</ul>