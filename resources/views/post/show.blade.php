@extends('layouts.master')

@section('contents')
	
	<div class="col-md-10 blog-main">
		      <!-- <h3 class="pb-3 mb-4 font-italic border-bottom">
		        From the Firehose
		      </h3> -->

		<!-- if this is true then its a normal post with bits -->
		@if(isset($post))
			
			<div class="blog-post">
				
				<h2 class="blog-post-title border-bottom">
		        		{{ $post->title }}
		    	</h2>

		        <p class="blog-post-meta">
					{{ $post->updated_at->format('F d, Y') }} by
					<a href="#">{{ $post->user->name }}</a></p>

				<p>
					<img src="{{ url(Config::get('image.upload_folder') .
					 '/' . $post->image) }}" alt="{{ $post->descrption }}" style="width:100%; height: 400px">
				</p>

				@foreach($post->bits as $bit)

					@if($bit->body_type == 0)
						<h3 class="pb-3 mb-4 font-italic border-bottom">
		        			{{ $bit->body }}
		      			</h3>
					@endif

					@if($bit->body_type == 1)
						<p>
							{{ $bit->body }}
						</p>
					@endif

					@if($bit->body_type == 2)
						<p>
							<img src="{{ url(Config::get('image.upload_folder') .
					 '/' . $bit->body) }}" alt="" style="width:100%; height: 400px">
						</p>
					@endif

					@if($bit->body_type == 3)
						<blockquote>
				          	<p>
				          		<iframe width="100%" height="420px" src="{{ $bit->body }}"></iframe>
							</p>
				        </blockquote>
					@endif
					
					<!-- NB: i nested the php and endphp to show the comments
					if the nestings is removed, errors will occurs due to the comment tag -->

					<!-- //check the body type if its 5 or 6 and check the next and the previous values in the array if its 5 or 6 too
					//if the prev is 5 or 6 then break caused it has been created already
					//if it hasnt been created and the next 1 is 5 or 6
					//then create the div row and assign them to variables

					//before checking the next item in the array make sure to check if you have reached the end of the loop -->
					@if($bit->body_type == 5 ||  $bit->body_type == 6)
					
						@php
							$bitArray = $post->bits;
						@endphp
							<!-- //check if the previous item on the array
							//if the prev type is 5 or 6
							//break to the next item in loop cause we ve already used it -->
						@php
							$prev =  $bitArray[($loop->index - 1)];

							if($prev->body_type == 5 || $prev->body_type == 6){
								break;
							}
						@endphp
							<!-- check to make sure the next item is out of bounds of the the array length -->
						@php
							if($loop->remaining > 0){
								$next =  $bitArray[($loop->index + 1)];

						@endphp

								<div class="row">
									
									@if($bit->body_type == 5)
										<div class="col-md-6">
											<p>
												{{ $bit->body }}
											</p>
										</div>
									@else
										<div class="col-md-6">
											<p>
												<img src="{{ url(Config::get('image.upload_folder') .
										'/' . $bit->body) }}" alt="" style="width:100%; height: 400px">
											</p>
										</div>
									@endif

									@if($next->body_type == 5)
										<div class="col-md-6">
											<p>
												{{ $next->body }}
											</p>
										</div>
									@else
										<div class="col-md-6">
											<p>
												<img src="{{ url(Config::get('image.upload_folder') .
										'/' . $next->body) }}" alt="" style="width:100%; height: 400px">
											</p>
										</div>
									@endif

								</div>

						@php
							}
						@endphp

					@endif

				@endforeach
			</div>

		@endif
		
		<!-- if this is true, it means its a query list or countdown post  -->
		@if(isset($posts))
			
			<div class="blog-post">
				
				@foreach($posts as $pst)
					<a href="{{ url(route('posts.show', $pst->id )) }}">
						<h2 class="blog-post-title border-bottom">
								{{ $pst->title }}
						</h2>

						<p class="blog-post-meta">
							{{ $pst->updated_at->format('F d, Y') }} by
							<a href="#">{{ $pst->user->name }}</a></p>

						<p>
							<img src="{{ url(Config::get('image.upload_folder') .
							'/' . $pst->image) }}" alt="{{ $pst->descrption }}" style="width:100%; height: 400px">
						</p>
					</a>
				@endforeach

			</div>

		@endif
		<nav class="blog-pagination">
			@guest
				<a class="btn btn-outline-primary" href="{{ url(route('posts.index')) }}">back</a>
				<a class="btn btn-outline-primary" href="#">Older</a>
				<a class="btn btn-outline-secondary disabled" href="#">Newer</a>
			@else
				<a class="btn btn-outline-primary" href="{{ url(route('posts.index')) }}">back</a>
				<a class="btn btn-outline-primary" href="{{ url(route('posts.edit', $post->id )) }}">Edit</a>
				<a class="btn btn-outline-primary" href="#">Older</a>
				<a class="btn btn-outline-secondary disabled" href="#">Newer</a>
			@endguest
      </nav>

      <hr>
    	
    	<div class="comments">
		    <ul class="list-group">
		        		
		        	
		        	@foreach($post->comments as $comment)

		        		<li class="list-group-item">
		        			<strong>
		        				{{ $comment->created_at->diffForHumans() }}
		        			</strong>
		        			{{ $comment->body }}: &nbsp;
		        		</li>

		        	@endforeach

		    </ul>
		</div>

		<hr>

		<div class="card">
			<div class="card-block">
				<form method="POST" action="/posts/{{  $post->id }}/comments">
					{{ csrf_field() }}

					<div class="form-group">
						<textarea name="body" placeholder="Your comment here." class="form-control" required>
							
						</textarea>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Add Comment</button>
					</div>
				</form>

				@include('layouts.errors')

			</div>
			
		</div>


	
    </div><!-- /.blog-main -->

</div>

@endsection
