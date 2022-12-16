<?php

use Illuminate\Database\Seeder;

class CanalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Canal::class, 50)->create();
        /*->each(function ($canal) {
	        $canal->posts()->save(factory(App\Post::class)->make());
	    });*/
    }
}
