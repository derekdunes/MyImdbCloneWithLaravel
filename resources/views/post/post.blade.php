<div class="blog-post">
		        <h2 class="blog-post-title">
		        	<a href="{{ url(route('posts.show', $post->id)) }}">
		        		{{ $post->title }}
		        	</a>
		    	</h2>
				
		        <p class="blog-post-meta">
		        	Created on {{ $post->created_at->toFormattedDateString() }} by
		        <a href="#" class="username">{{ $post->user->name }}</a></p>
		
		    
					<img src="{{ url( '/uploads/'. $post->image) }}" style="width:100%; height: 400px"/>

				{{ $post->body }}
<!-- 
		        <p>Cum sociis natoque penatibus et magnis <a href="#">dis parturient montes</a>, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>
		        <blockquote>
		          <p>Curabitur blandit tempus porttitor. <strong>Nullam quis risus eget urna mollis</strong> ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
		        </blockquote>
		        <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
		        <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p> -->
</div>