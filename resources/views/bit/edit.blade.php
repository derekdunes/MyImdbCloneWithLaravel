@extends('layouts.master')


@section('contents')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

<div class="col-md-10 blog-main">

		<div class="blog-post">	

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

					@if($bit->body_type == 5)
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

					@if($bit->body_type == 6)
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
			
		</div><!-- /.blog-main -->

		@if($bit->body_type == 4 && isset($posts))
			<div class="blog-post">
				
				@foreach($posts as $post)

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

				@endforeach

			</div>

		@endif

	<h1> Edit This Post </h1>

	<hr>

	<form method="POST" action="{{ route('bits.update', $bit->id) }}" enctype="multipart/form-data">
		<input type="hidden" name="_method" value="PUT">
		
		{{ csrf_field() }}

		@if($bit->body_type == 0)
			<div class="form-group">
				
				<label for="title">Header Text:</label>

				<input type="text" class="form-control" id="title" name="head" value="{{ $bit->body }}">

			</div>
		@endif

		@if($bit->body_type == 1 || $bit->body_type == 5)
			<div class="form-group">
				
				<label for="title">Text:</label>

				<textarea rows="10" cols="10" class="form-control" name="text">{{ $bit->body }}</textarea>

			</div>
		@endif

		@if($bit->body_type == 3)

			<div class="form-group">
				
				<label for="title">Embed:</label>
				
				<input type="url" class="form-control" id="title" name="embed" value="{{ $bit->body }}">

			</div>

		@endif

		<!-- normal image and sideImage -->
		@if($bit->body_type == 2 || $bit->body_type == 6)

			<div class="form-group">
				
				<label for="image">Image</label>

				<input type="file" class="form-control" id="image" name="image" accept="image/*">

			</div>

		@endif

		@if($bit->body_type == 4)

			@php
				list($startDate, $stopDate, $count, $categId) = explode('/', $bit->body);
			@endphp
								
			<div id="clones">
				<div class="form-group">
					<label for="description">List Start Date</label>
					<input id="from" type="date" class="form-control" value="{{ $startDate }}" name="fromDate" required="required">
				</div>
				<div class="form-group">
					<label for="description">List End Date</label>
					<input id="to" type="date" class="form-control" value="{{ $stopDate }}" name="toDate" required="required">
				</div>
				<div class="form-group">
					<label for="description">No of items in List query</label>
					<input id="count" type="number" class="form-control" value="{{ $count }}" name="count" min="0" required="required">
				</div>
				<div class="form-group">
					<label for="description">Select Post List Genres/Category</label>
					<select class="form-control" name="categ" id="categ" required="required">
						@foreach($categories as $category)
							@if($category->id == $categId)
								<option value="{{ $category->id }}" selected>{{ $category->title }}</option>
							@else
								<option value="{{ $category->id }}">{{ $category->title }}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>

		@endif
		
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Update</button>	
		</div>
		
		@include('layouts.errors')

	</form>

		<nav class="blog-pagination">
		@guest
			<a class="btn btn-outline-primary" href="{{ url(route('posts.index')) }}">back</a>
        	<a class="btn btn-outline-primary" href="#">Older</a>
        	<a class="btn btn-outline-secondary disabled" href="#">Newer</a>
		@else
			<a class="btn btn-outline-primary" href="{{ url(route('bits.destroy',$bit->id)) }}">Delete Widget</a>
        	<a class="btn btn-outline-primary" href="#">Older</a>
        	<a class="btn btn-outline-secondary disabled" href="#">Newer</a>
		@endguest

      </nav>

</div>

<script type="text/javascript">

	//will consider changing widgets later
	function createEmbed(){

			var $more_forms = $("div[class='more']");

        	var $parent_div = $("<div>", {id:"clones"});

        //create Embed Type

            var $form_group_div = $("<div>", {class: "form-group"});

            var $label = $("<label>", {for: "type"});

            $label.append("Body Type");

            var $selectInput = $("<select>", {id: "type", class: "form-control", name:"type[]", required: true});

            var $optionInput = $("<option>", {value: "3" , selected: true});

            $optionInput.append("Embed");

            $selectInput.append($optionInput);

            $form_group_div.append($label);
            $form_group_div.append($selectInput);

            $parent_div.append($form_group_div);

            $more_forms.append($parent_div);


        //create Embed

            var $form_group_div = $("<div>", {class: "form-group"});

            var $label = $("<label>", {for: "description"});

            $label.append("Embed(youtube, video, etc)");

            var $embedInput = $("<input>", {id: "embed", type: "url", class: "form-control", name:"embed[]", required: true});
            
            $form_group_div.append($label);
            $form_group_div.append($embedInput);

            $parent_div.append($form_group_div);

            $more_forms.append($parent_div);

	}

	function createTextArea(){

		var $more_forms = $("div[class='more']");

        var $parent_div = $("<div>", {id:"clones"});


            //create Embed Type

            var $form_group_div = $("<div>", {class: "form-group"});

            var $label = $("<label>", {for: "type"});

            $label.append("Body Type");

            var $selectInput = $("<select>", {id: "type", class:"form-control", name:"type[]", required: true});

            var $optionInput = $("<option>", {value: "1" , selected: true});

            $optionInput.append("Text Content");

            $selectInput.append($optionInput);

            $form_group_div.append($label);
            $form_group_div.append($selectInput);

            $parent_div.append($form_group_div);

            $more_forms.append($parent_div);

        //create Text

            var $form_group_div = $("<div>", {class: "form-group"});

            var $label = $("<label>", {for: "description"});

            $label.append("Text Body");

            var $bodyText = $("<textarea>", {id: "description", rows: "10", cols: "10", class: "form-control", name:"text[]"});

            $form_group_div.append($label);
            $form_group_div.append($bodyText);

            $parent_div.append($form_group_div);

            $more_forms.append($parent_div);

	}

	function createImage(){

		var $more_forms = $("div[class='more']");

        var $parent_div = $("<div>", {id:"clones"});

        //create Embed Type
            var $form_group_div = $("<div>", {class: "form-group"});

            var $label = $("<label>", {for: "type"});

            $label.append("Body Type");

            var $selectInput = $("<select>", {id: "type", class: "form-control", name:"type[]", required: true});

            var $optionInput = $("<option>", {value: "2" , selected: true});

            $optionInput.append("Image");

            $selectInput.append($optionInput);

            $form_group_div.append($label);
            $form_group_div.append($selectInput);

            $parent_div.append($form_group_div);

            $more_forms.append($parent_div);

        //create image input    

            var $form_group_div = $("<div>", {class: "form-group"});

            var $label = $("<label>", {for: "image"});

            $label.append("Section Image");

            var $imgInput = $("<input>", {id: "image", type: "file", class: "form-control", name:"image[]", accept:"image/*", required: true});
            
            $form_group_div.append($label);
            $form_group_div.append($imgInput);

            $parent_div.append($form_group_div);

            $more_forms.append($parent_div);

	}

    
    function removeForm(){
    	$("#clones").last().remove();
    }

</script>

@endsection 