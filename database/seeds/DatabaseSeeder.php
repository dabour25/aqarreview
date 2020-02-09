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
		//Use Safe
        $this->call(links_data::class);
		//For Test Mode Only
		//factory('App\Models\Ad',10000)->create();
		//factory('App\Models\Adspro',10000)->create();
    }
}
