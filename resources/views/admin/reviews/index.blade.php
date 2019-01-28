@extends('layouts.app')

@section('content')
<h1>Admin reviews</h1>
        @if(count($reviews) > 0)
            @foreach ($reviews as $review)
                <div class="card my-4">
                    <div class="card-header">
                        Note : {{$review->note}}/5
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                        <p>{{$review->comment}}</p>
                        <footer class="blockquote-footer">{{$review->username}}</footer>
                        </blockquote>
                    </div>
                    <a href="reviews/{{$review->review_id}}/delete" class="btn btn-danger">DELETE</a>
                </div>
            @endforeach
        @else
            No review found.
        @endif
@endsection

