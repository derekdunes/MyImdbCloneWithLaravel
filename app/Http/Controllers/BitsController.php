<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Bits;
use App\Models\Post;
use Config;
use File;
use auth;
use DB;

class BitsController extends Controller
{
    public function __construct(){

    	$this->middleware('auth')->except(['index', 'show']);
    
    }

    public function index()
    {
    
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $bit = Bits::with('post')->findOrFail($id);
        $categories = Category::all();


                if($bit->body_type == 4){
                    //extract data and perform query
                    $queryString = $bit->body;
                    list($startDate, $stopDate, $count, $categ) = explode("/", $queryString); //separate the string and assign to the variables simultaneously

                    //sample query
                    //whereDate('release_date', '<=', Carbon::today()->toDateTimeString())->orderBy('release_date','desc')->orderBy('pop_rating','desc')->orderBy('movie_views','desc')->take(10)->get();
                    $posts = Post::whereBetween('created_at', [$startDate, $stopDate])->where('category_id', $categ)->orderBy('post_views', 'DESC')->take($count)->get();
                    return view('bit.edit', compact('bit', 'categories', 'posts'));
                }
        

        return view('bit.edit', compact('bit','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {

        $bit = Bits::find($id);

        if ($bit->body_type == 0) {
        	# code...
        	$head = $req->head;

        	if ($text)
		    	$bit->body = $head;
		    
		    $bit->save();
        }

        if ($bit->body_type == 1 || $bit->body_type == 5) {
        	# code...
        	$text = $req->text;

        	if ($text)
		    	$bit->body = $text;
		    
		    $bit->save();
        }

        if ($bit->body_type == 3) {
        	# code...
        	$embed = $req->embed;

        	if ($embed)
		    	$bit->body = $embed;
		    
		    $bit->save();
        }

        if ($bit->body_type == 4) {
        	# code...
            $start = $req->fromDate;
            $stop = $req->toDate;
            $count = $req->count;
            $categ = $req->categ;

        	if (isset($start) && isset($stop) && isset($count) && isset($categ)){
                $queryString = $start . '/' . $stop . '/' . $count . '/' . $categ;

                $bit->body = $queryString;
            }
		    	
		    $bit->save();
        }

        if ($bit->body_type == 2 || $bit->body_type == 6 && $req->hasFile('image')) {
        	
	        	//if validation passes
	        $image = $req->image;

	        $filename = $image->getClientOriginalName();

	        $filename = pathinfo($filename, PATHINFO_FILENAME);

	        //in production check if url/image file name already exist
	        //make url friendly
	        $fullname = Str::slug(Str::random(8).$filename) . '.' . $image->getClientOriginalExtension();

	        //upload image to upload folder then make a thumbnail from the upload image
	        $upload = $image->move(Config::get('image.upload_folder'), $fullname);

            if ($upload) {
 				
 				$oldImage = $bit->body;

                $path = Config::get('image.upload_folder') . '/' . $oldImage;
              
                if(File::exists($path) ){
                    File::delete($path);
                }

                $bit->body = $fullname;
                $bit->save();
     	   }
    	}

        // And then redirect to the home page
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $bit = Bits::find($id);
        $bit->delete();

        session()->flash('message', 'Your post has been deleted');

        // And then redirect to the home page
        return redirect('/');
    }
}
