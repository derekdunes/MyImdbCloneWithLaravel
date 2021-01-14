<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class AjaxController extends Controller
{
    // function getGenres(){

	// 	$genres = Genre::all();

	// 	echo json_encode($genres);

	// 	exit;
    // }
    
    function getCategories(){

		$categories = Category::all();

		echo json_encode($categories);

		exit;
	}
}
