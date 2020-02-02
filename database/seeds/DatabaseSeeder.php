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
		App\Models\Links::insert(['name'=>'phone','value'=>'01121995450']);
		App\Models\Links::insert(['name'=>'email','value'=>'']);
		App\Models\Links::insert(['name'=>'face','value'=>'https://www.facebook.com/aqarreview/']);
		App\Models\Links::insert(['name'=>'twit','value'=>'https://twitter.com/AqarReview']);
		App\Models\Links::insert(['name'=>'inst','value'=>'https://www.instagram.com/aqarreview']);
		App\Models\Links::insert(['name'=>'default_img','value'=>'default.jpg']);
		
		
		//For Test Mode Only
		//factory('App\Models\Ads',10000)->create();
		//factory('App\Models\Adspro',10000)->create();
    }
}
