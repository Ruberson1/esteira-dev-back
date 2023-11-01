<?php

namespace Database\Seeders;

use App\Models\Status\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            ['name' => 'HOMOLOGANDO'],
            ['name' => 'LIB. DEV'],
            ['name' => 'LIB. HOMOLOG'],
            ['name' => 'DEV'],
            ['name' => 'PROD'],
            ['name' => 'LIB. CORREÇÃO'],
            ['name' => 'CORRIGINDO'],
            ['name' => 'STAND BY'],
            ['name' => 'LIB. PROD'],
            ['name' => 'AG. MERGE'],
            ['name' => 'LIB. DEV HOMOLOG']
        ];

        Status::insert($status);
    }
}