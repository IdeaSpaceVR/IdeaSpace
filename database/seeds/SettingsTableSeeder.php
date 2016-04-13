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
                'namespace' => 'system', 
                'key' => 'MAX_IMAGE_WIDTH', 
                'value' => 4096
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
