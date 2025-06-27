@extends('layouts.app')

@section('content')
    @while(have_posts())
        @php the_post() @endphp
        @includeFirst(['partials.content-page', 'partials.content'])
    @endwhile
@endsection
