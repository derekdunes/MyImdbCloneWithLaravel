<?php

use Illuminate\Database\Seeder;

class MultiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
        [
        	"title"=>"15 SIGNS THAT YOU ARE GOING TO BE SUCCESSFUL",
        	"body"=>"listen carefully to the key signs that all rich people have in common",
        	"utube"=>"https:\/\/www.youtube.com\/embed\/AV1iAQ6XG6Q",
        	"created_at"=>"2019-02-11 08:27:42",
        	"updated_at"=>"2019-02-11 08:27:42"
        ],
		[ 
			"title"=>"15 THINGS TO KNOW BEFORE STARTING A BUSINESS",
			"body"=>"There are key things to know before creating a startup or a business",
			"utube"=>"https:\/\/www.youtube.com\/embed\/nt7jKOc-Ya8",
			"created_at"=>"2019-02-11 08:34:00",
			"updated_at"=>"2019-02-11 08:34:00"
		],
		[
			"title"=>"15 SKILLS THAT WILL PAY YOU OFF FOREVER",
			"body"=>"There are key skills to know before creating a startup or a business",
			"utube"=>"https:\/\/www.youtube.com\/embed\/r_gBTgeymgs",
			"created_at"=>"2019-02-11 08:37:34",
			"updated_at"=>"2019-02-11 08:37:34"
		],
		[
			"title"=>"Naira marley caught by EFCC",
			"body"=>"Naira marley caught by EFCC",
			"utube"=>"https:\/\/www.youtube.com\/embed\/r_gBTgeymgs",
			"created_at"=>"2019-05-23 06:02:04",
			"updated_at"=>"2019-05-23 06:02:04"
		],
		[
			"title"=>"why you cant buy mtn stocks",
			"body"=>"why you cant buy mtn stocks",
			"utube"=>"https:\/\/www.youtube.com\/embed\/r_gBTgeymgs",
			"created_at"=>"2019-05-23 06:15:55",
			"updated_at"=>"2019-05-23 06:15:55"
		],
		[
			"title"=>"Naruto manga will be a banga",
			"body"=>"Naruto manga will be a banga",
			"utube"=>"https:\/\/www.youtube.com\/embed\/r_gBTgeymgs",
			"created_at"=>"2019-05-23 06:18:05",
			"updated_at"=>"2019-05-23 06:18:05"
		],
		[
			"title"=>"Andela opening application for new fellowship",
			"body"=>"Andela opening application for new fellowship",
			"utube"=>"https:\/\/www.youtube.com\/embed\/r_gBTgeymgs",
			"created_at"=>"2019-05-23 06:28:03",
			"updated_at"=>"2019-05-23 06:28:03"
        ]
    ]);

    DB::table('comments')->insert([
        [
        	"post_id"=>"1",
        	"body"=>"Great post",
        	"created_at"=>"2019-05-24 13:52:21",
        	"updated_at"=>"2019-05-24 13:52:21"
        ],
		[
			"post_id"=>"1",
			"body"=>"couldnt have agreed more",
			"created_at"=>"2019-05-24 13:52:21",
			"updated_at"=>"2019-05-24 13:52:21"
        ]
    ]);
    
    }
}
