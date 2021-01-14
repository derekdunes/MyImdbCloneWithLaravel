
@extends('layouts.master')

@section('carousel')
	
	@include("layouts.carousel")

@endsection

@section('contents')
	
	<div class="col-md-10 blog-main">
		      <h3 class="pb-3 mb-4 font-italic border-bottom">
		        From the Firehose
		      </h3>

	@foreach ($posts as $post)
		@if(!$loop->first)
			@include('post.post')<!-- /.blog-post -->
		@endif
	@endforeach

	<nav class="blog-pagination">
				@guest
					<a class="btn btn-outline-primary" href="#">Older</a>
					<a class="btn btn-outline-secondary disabled" href="#">Newer</a>
				@else
					<a class="btn btn-outline-primary" href="#">Older</a>
					<a class="btn btn-outline-secondary disabled" href="#">Newer</a>
					<a class="btn btn-outline-primary" href="{{ route('posts.create') }}">Create Post</a>
				@endguest
      </nav>
    </div><!-- /.blog-main -->

@endsection
