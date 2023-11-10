@guest
    <a href="{{ route('login') }}">Login</a>
@else
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button>Logout</button>
    </form>
@endguest


@foreach($courses as $course)
    <h2>{{ $course->title }}</h2>
    <p>{{ $course->description }}</p>
@endforeach