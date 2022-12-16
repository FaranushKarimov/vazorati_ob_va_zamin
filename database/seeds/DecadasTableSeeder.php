<?php

use Illuminate\Database\Seeder;

class DecadasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Decada::class, 50)->create();
        /*->each(function ($decada) {
	        $decada->posts()->save(factory(App\Post::class)->make());
	    });*/
    }
}
