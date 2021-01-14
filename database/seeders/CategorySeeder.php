<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                "title" => "World",
                "description" => "listen carefully to the key signs that all rich people have in common",
            ],
            [
                "title" => "Technology",
                "description" => "listen carefully to the key signs that all rich people have in common",
            ],
            [
                "title" => "Culture",
                "description" => "listen carefully to the key signs that all rich people have in common",
            ],
            [
                "title" => "Fashion",
                "description" => "listen carefully to the key signs that all rich people have in common",
            ],
            [
                "title" => "Business",
                "description" => "listen carefully to the key signs that all rich people have in common",
            ],
            [
                "title" => "Politics",
                "description" => "listen carefully to the key signs that all rich people have in common",
            ],
            [
                "title" => "Health",
                "description" => "listen carefully to the key signs that all rich people have in common",
            ],
            [
                "title" => "Travel",
                "description" => "listen carefully to the key signs that all rich people have in common",
            ],
        ]);
    }
}
