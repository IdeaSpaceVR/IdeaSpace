<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'user_id' => 1, 
                'namespace' => 'images', 
                'key' => 'IMAGE_QUALITY', 
                'value' => 90 /* same default value as Intervention Image default value */
            ]
        ]);

        DB::table('settings')->insert([
            [
                'user_id' => 1, 
                'namespace' => 'images', 
                'key' => 'PREVIEW_IMAGE_WIDTH', 
                'value' => 400
            ]
        ]);

        DB::table('settings')->insert([
            [
                'user_id' => 1, 
                'namespace' => 'system', 
                'key' => 'front-page-display', 
                'value' => 'latest-spaces'
            ]
        ]);
    }
}
