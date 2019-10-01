<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
		//Use This at First Time Only
		App\Links::insert(['name'=>'phone','value'=>'01121995450']);
		App\Links::insert(['name'=>'email','value'=>'']);
		App\Links::insert(['name'=>'face','value'=>'https://www.facebook.com/aqarreview/']);
		App\Links::insert(['name'=>'twit','value'=>'https://twitter.com/AqarReview']);
		App\Links::insert(['name'=>'inst','value'=>'https://www.instagram.com/aqarreview']);
		App\Links::insert(['name'=>'default_img','value'=>'default.jpg']);
		
		
		//For Test Mode Only
		//factory('App\Ads',500)->create();
		//factory('App\Adspro',500)->create();
    }
}
