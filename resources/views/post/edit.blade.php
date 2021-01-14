@extends('layouts.master')


@section('contents')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

<div class="col-md-10 blog-main">

			<div class="blog-post">

		        <h2 class="blog-post-title border-bottom">
		        		{{ $post->title }}
		    	</h2>

		        <p class="blog-post-meta">
					{{ $post->updated_at->format('F d, Y') }} by
                    <a href="#">{{ $post->user->name }}</a>
                </p>

                <p class="blog-post-meta">
                    <a href="#">{{ $post->category->title }}</a>
                </p>
                    
				<p>
					<img src="{{ url(Config::get('image.upload_folder') .
					 '/' . $post->image) }}" style="width:100%; height: 400px">
				</p>

				@foreach($post->bits as $bit)

					@if($bit->body_type == 1)
						<p>
							{{ $bit->body }}
							@if($post->user_id = Auth::user()->id)
								<a href="{{route('bits.edit', $bit->id)}}">Edit text</a>
							@endif
						</p>
					@endif

					@if($bit->body_type == 2)
						<p>

							<img src="{{ url(Config::get('image.upload_folder') .
					 '/' . $bit->body) }}" alt="" style="width:100%; height: 400px">
					 		@if($post->user_id = Auth::user()->id)
						 		<a href="{{route('bits.edit', $bit->id)}}">Edit Image</a>
							@endif
						</p>
					@endif

					@if($bit->body_type == 3)
						<blockquote>
				          	<p>
				          		<iframe width="100%" height="420px" src="{{ $bit->body }}"></iframe>
							</p>
				        </blockquote>
				        @if($post->user_id = Auth::user()->id)
					        <a href="{{route('bits.edit', $bit->id)}}">Edit Embed</a>
						@endif
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
                                            @if($post->user_id = Auth::user()->id)
								                <a href="{{route('bits.edit', $bit->id)}}">Edit Side text</a>
                                            @endif
                                        </p>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <p>
                                            <img src="{{ url(Config::get('image.upload_folder') .
                                    '/' . $bit->body) }}" alt="" style="width:100%; height: 400px">
                                             @if($post->user_id = Auth::user()->id)
								                <a href="{{route('bits.edit', $bit->id)}}">Edit Side Image</a>
                                            @endif
                                        </p>
                                    </div>
                                @endif

                                @if($next->body_type == 5)
                                    <div class="col-md-6">
                                        <p>
                                            {{ $next->body }}
                                            @if($post->user_id = Auth::user()->id)
								                <a href="{{route('bits.edit', $next->id)}}">Edit Side Text</a>
                                            @endif
                                        </p>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <p>
                                            <img src="{{ url(Config::get('image.upload_folder') .
                                    '/' . $next->body) }}" alt="" style="width:100%; height: 400px">
                                        </p>
                                        @if($post->user_id = Auth::user()->id)
								            <a href="{{route('bits.edit', $next->id)}}">Edit Side Image</a>
                                        @endif
                                    </div>
                                @endif

                            </div>

                    @php
                        }
                        
                    @endphp

                @endif
                    
                    @if($bit->body_type == 4)
						<p>
                            Query String
                            @php
                                list($startDate, $stopDate, $count, $categId) = explode('/', $bit->body);

                                switch($categId){
                                    case 1: 
                                        $categTitle = 'World';
                                        break;
                                    case 2: 
                                        $categTitle = 'Technology';
                                        break;
                                    case 3:
                                        $categTitle = 'Culture';
                                        break;
                                    case 4:
                                        $categTitle = 'Fashion';                                        
                                        break;
                                    case 5:
                                        $categTitle = 'Business';
                                        break;
                                    case 6:
                                        $categTitle = 'Politics';
                                        break;
                                    case 7:
                                        $categTitle = 'Health';
                                        break;
                                    case 8:
                                        $categTitle = 'Travel';
                                        break;
                                }

                            @endphp

							<b>List of {{ $count }} posts created between {{ $startDate }} to {{ $stopDate }} that of {{ $categTitle }} Category</b>
							@if($post->user_id = Auth::user()->id)
								<a href="{{route('bits.edit', $bit->id)}}">Edit Query String</a>
							@endif
						</p>
					@endif

				@endforeach


    </div><!-- /.blog-main -->

	<h1> Edit This Post </h1>

	<hr>

	<form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
		<input type="hidden" name="_method" value="PUT">
		
        {{ csrf_field() }}
        
        <div class="form-group">
			
			<label for="title">Category:</label>
            
            <select class="form-control" name="category" id="category">
                @foreach($categories as $category)
                    @if($post->category_id == $category->id)            
                        <option value="{{ $category->id }}" selected>{{ $category->title }}</option>
                    @else
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endif
                @endforeach
            </select>

		</div>

		<div class="form-group">
			
			<label for="title">Title:</label>
			
			<input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}">

		</div>

		<div class="form-group">
			
			<label for="image">Image</label>

			<input type="file" class="form-control" id="image" name="photo" accept="image/*">

		</div>

		<div class="more">                    
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-3">
                <button type="button" class="btn btn-primary" onclick="createTextArea()">
                    Add Body Text
                </button>
            </div>                     

            <div class="col-md-3">
                <button type="button" class="btn btn-primary" onclick="createImage()">
                    Add Body Image
                </button>
            </div>

            <div class="col-md-3">
                <button type="button" class="btn btn-primary" onclick="createSideTextArea()">
                    Add Side Text
                </button>
            </div>

            <div class="col-md-3">
                <button type="button" class="btn btn-primary" onclick="createSideImage()">
                    Add Side Image
                </button>
            </div>
                            
            <div class="col-md-3">
                <button type="button" class="btn btn-primary" onclick="createEmbed()">
                    Add Embed (Video, Code, etc)
                </button>
            </div>

            <div class="col-md-3">
                <button type="button" class="btn btn-primary" onclick="getCategories()">
                    Add Movie Blog Query
                </button>
            </div>
                            
            <div class="col-md-3">
                <button type="button" class="btn btn-primary" onclick="removeForm()">
                    Remove Last Widget
                </button>
            </div>
        </div>

        <br/>
		
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Update</button>	
		</div>
		
		@include('layouts.errors')

	</form>


</div>

<script type="text/javascript">

function getCategories(){
        
        //setup ajax token for fetching data 
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //fetch the data from the database
        $.ajax({
            url: '/get/categories',//route to fetch the data
            type: 'GET',
            datatype: 'json',
            success: function(result){
                var categories = JSON.parse(result);

                //create the new specialist select options
                // console.log("in here");
                // console.log(categories);

                createMovieQuery(categories);
                
            }
        });

    }

    function createMovieQuery(categories)
    {

        var $more_forms = $("div[class='more']");

        var $parent_div = $("<div>", {id:"clones"});


        //create Movie or Blog countdown list Type of post

        var $form_group_div = $("<div>", {class: "form-group"});

        var $label = $("<label>", {for: "type"});

        $label.append("Query List Type");

        var $selectInput = $("<select>", {id: "type", class:"form-control", name:"type[]", required: true});

        var $optionInput = $("<option>", {value: "4" , selected: true});

        $optionInput.append("Auto List Creater (Used to create countdown posts)");

        $selectInput.append($optionInput);

        $form_group_div.append($label);
        $form_group_div.append($selectInput);

        $parent_div.append($form_group_div);

        $more_forms.append($parent_div);

        //create 2 date selectors, number type( for count), Genre types dropdown

        //begin of start date input
        var $form_group_div = $("<div>", {class: "form-group"});

        var $label = $("<label>", {for: "description"});

        $label.append("List Start Date");

        //creaete date selector

        //date to start query
        var $fromDate = $("<input>", {id: "from", type: "date", class: "form-control", name:"fromDate[]", required: true});
        
        $form_group_div.append($label);
        $form_group_div.append($fromDate);

        $parent_div.append($form_group_div);

        $more_forms.append($parent_div);
        //end of start date input

        //begin of end date input 
        var $form_group_div = $("<div>", {class: "form-group"});

        var $label = $("<label>", {for: "description"});

        $label.append("List End Date");

        //date to stop query
        var $toDate = $("<input>", {id: "to", type: "date", class: "form-control", name:"toDate[]", required: true});
        
        $form_group_div.append($label);
        $form_group_div.append($toDate);

        $parent_div.append($form_group_div);

        $more_forms.append($parent_div);
        //end of start date input


        //start of end count input ; for no of list items for blog post
        var $form_group_div = $("<div>", {class: "form-group"});

        var $label = $("<label>", {for: "description"});

        $label.append("No of items in List query");

        //number of contents to get
        var $count = $("<input>", {id: "count", type: "number", class: "form-control", name:"count[]", min:0, required: true});

        $form_group_div.append($label);
        $form_group_div.append($count);

        $parent_div.append($form_group_div);

        $more_forms.append($parent_div);
        //end of count input

        //category type or Genre type
        //get the genres or categories from the api
        // <select class="form-control" name="category" id="category">
        //         foreach($catgories as $category)
        //         <option value="{{ $category->id }}">{{ $category->title }}</option>
        //         endforeach
        // </select>

        //start of end count input ; for no of list items for blog post
        var $form_group_div = $("<div>", {class: "form-group"});

        var $label = $("<label>", {for: "description"});

        $label.append("Select Post List Genres/Category");

        var $select = $("<select>", {class: "form-control", name: "categ[]", id: "categ", required: true});

        categories.forEach( element => {
            //create options here

            var $option =  $("<option>", {value: element.id});
            
            $option.append(element.title);

            //append to select var
            $select.append($option);
        });

        $form_group_div.append($label);
        $form_group_div.append($select);

        //appended select and options tags

        $parent_div.append($form_group_div);

        $more_forms.append($parent_div);


    }

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
    
    function createSideTextArea(){

        var $more_forms = $("div[class='more']");

        var $parent_div = $("<div>", {id:"clones"});


        //create Embed Type

        var $form_group_div = $("<div>", {class: "form-group"});

        var $label = $("<label>", {for: "type"});

        $label.append("Body Type");

        var $selectInput = $("<select>", {id: "type", class:"form-control", name:"type[]", required: true});

        var $optionInput = $("<option>", {value: "5" , selected: true});

        $optionInput.append("Side Text Content");

        $selectInput.append($optionInput);

        $form_group_div.append($label);
        $form_group_div.append($selectInput);

        $parent_div.append($form_group_div);

        $more_forms.append($parent_div);

    //create Text

        var $form_group_div = $("<div>", {class: "form-group"});

        var $label = $("<label>", {for: "description"});

        $label.append("Side Text Body");

        var $bodyText = $("<textarea>", {id: "description", rows: "10", cols: "10", class: "form-control", name:"sText[]"});

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
    
    function createSideImage(){

        var $more_forms = $("div[class='more']");

        var $parent_div = $("<div>", {id:"clones"});

        //create Embed Type
            var $form_group_div = $("<div>", {class: "form-group"});

            var $label = $("<label>", {for: "type"});

            $label.append("Body Type");

            var $selectInput = $("<select>", {id: "type", class: "form-control", name:"type[]", required: true});

            var $optionInput = $("<option>", {value: "6" , selected: true});

            $optionInput.append("Side Image");

            $selectInput.append($optionInput);

            $form_group_div.append($label);
            $form_group_div.append($selectInput);

            $parent_div.append($form_group_div);

            $more_forms.append($parent_div);

        //create image input    

            var $form_group_div = $("<div>", {class: "form-group"});

            var $label = $("<label>", {for: "image"});

            $label.append("Section Side Image");

            var $imgInput = $("<input>", {id: "image", type: "file", class: "form-control", name:"sImage[]", accept:"image/*", required: true});
            
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