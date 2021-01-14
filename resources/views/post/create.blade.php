@extends('layouts.master')


@section('contents')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

<div class="col-md-10 blog-main">

	<h1> Publish a Post </h1>

	<hr>

	<form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
		
		{{ csrf_field() }}

        <div class="form-group">
			
			<label for="title">Category:</label>
            
            <select class="form-control" name="category" id="category">
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>

		</div>

		<div class="form-group">
			
			<label for="title">Title:</label>
			
			<input type="text" class="form-control" id="title" name="title">

		</div>

		<div class="form-group">
			
			<label for="image">Heading Image</label>
			
			<input type="file" class="form-control" id="image" name="photo" accept="image/*">

		</div>

		<div class="more">                    
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-3">
                <button type="button" class="btn btn-primary" onclick="createHeaderArea()">
                    Add Body Header
                </button>
            </div>

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
			<button type="submit" class="btn btn-primary">Publish</button>	
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

	function createHeaderArea(){

		var $more_forms = $("div[class='more']");

        var $parent_div = $("<div>", {id:"clones"});


            //create Embed Type

            var $form_group_div = $("<div>", {class: "form-group"});

            var $label = $("<label>", {for: "type"});

            $label.append("Body Type");

            var $selectInput = $("<select>", {id: "type", class:"form-control", name:"type[]", required: true});

            var $optionInput = $("<option>", {value: "0" , selected: true});

            $optionInput.append("Header Content");

            $selectInput.append($optionInput);

            $form_group_div.append($label);
            $form_group_div.append($selectInput);

            $parent_div.append($form_group_div);

            $more_forms.append($parent_div);

        //create Text

            var $form_group_div = $("<div>", {class: "form-group"});

            var $label = $("<label>", {for: "description"});

            $label.append("mini Header");

            var $headInput = $("<input>", {id: "header", type: "text", class: "form-control", name:"head[]", required: true});

            $form_group_div.append($label);
            $form_group_div.append($headInput);

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

