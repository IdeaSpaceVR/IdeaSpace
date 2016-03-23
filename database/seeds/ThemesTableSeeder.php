<?php

use Illuminate\Database\Seeder;
use App\Theme;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contents = (require 'themes/hello-world/config.php');

        DB::table('themes')->insert([
          ['root_dir' => 'themes/hello-world', 'user_id' => 1, 'config' => json_encode($contents), 'status' => Theme::STATUS_ACTIVE]
        ]); 
    }
}
