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
                'key' => 'site-title', 
                'value' => 'IdeaSpace'
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
