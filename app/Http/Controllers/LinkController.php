<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Str;

use App\Models\Link;

class LinkController extends Controller
{
    //
	public function index(){
	   	$link = '';

        return view('create', compact('link'));
    
    }

    public function store(){

        $this->validate(request(), [
            'link' => 'required'
        ]);

        if ($link = Link::where('url','=',request('link'))->first()){
            # code...
            $link = $link->hash;
            return view('create', compact('link'));

        }else {

            //Create a unique hash
            do {

                $link = Str::random(6);

            } while(Link::where('hash','=',$link)->count() > 0);

            //Save data to the database

            Link::create([
                'url' => request('link'),
                'hash' => $link
            ]);

            return view('create',compact('link'));
        }

    }


}
