<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = Status::create([
            'name' => 'W trakcie moderacji'
        ]);

        $status = Status::create([
            'name' => 'Odrzucone'
        ]);

        $status = Status::create([
            'name' => 'Zaakceptowane'
        ]);
    }
}
