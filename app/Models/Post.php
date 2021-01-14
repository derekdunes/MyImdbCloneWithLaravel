<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use auth;

class Post extends Model
{
    public function comments(){
    	
    	return $this->hasMany(Comment::class);
    
    }

    public function addComment($body){
    	

    	Comment::create([
            'body' => $body,
            'post_id' => $this->id,
            'user_id' => auth()->id()
        ]);

        //$this->comments()->create(compact('body'));
    }

    public function user(){

    	return $this->belongsTo(User::class);
    	
    }

    public function category(){

    	return $this->belongsTo(Category::class);
    	
    }

    public static function archives(){

        return static::selectRaw('year(created_at) year, monthname(created_at) month, COUNT(*) published')
        ->groupBy('year','month')
        ->get();

    }

    public function scopeFilter($query, $filters){

        if(isset($filter['month']) && isset($filters['year'])){
            
            if ($month = $filters['month']){
                $query->whereMonth('created_at', Carbon::parse($month)->month);
            }

            if ($year = $filters['year']){
                $query->whereYear('created_at', $year);
            }
            
        }
    }

    public function bits(){
        return $this->hasMany(Bits::class, 'post_id');
    }

    public function tags(){

        return $this->belongsToMany(Tag::class);

    }
}
