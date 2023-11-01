<?php

use Database\Seeders\CategorySeeder;
use Database\Seeders\StatusSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            StatusSeeder::class,
        ]);
    }
}
