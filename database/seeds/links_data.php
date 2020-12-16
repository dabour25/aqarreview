<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Link;
use App\Models\Admin;

class links_data extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links=$this->links();
        foreach ($links as $item) {
            Link::firstOrCreate($item);
        }
        Admin::firstOrCreate($this->defaultAdmin());
    }

    /**
     * @return array
     */
    public function links(){
        return [
            ['name'=>'phone','value'=>'01121995450'],
            ['name'=>'email','value'=>''],
            ['name'=>'facebook','value'=>'https://www.facebook.com/aqarreview/'],
            ['name'=>'twitter','value'=>'https://twitter.com/AqarReview'],
            ['name'=>'inst','value'=>'https://www.instagram.com/aqarreview'],
            ['name'=>'default_img','value'=>'default.jpg'],
            ['name'=>'default_profile','value'=>'default.png'],
        ];
    }
    /**
     * @return array
     */
    public function defaultAdmin(){
        return ['email'=>'admin@admin.com','password'=>Hash::make('Admin2019'),'slug'=>Str::random(3).'admin'.Str::random(3)];
    }
}
