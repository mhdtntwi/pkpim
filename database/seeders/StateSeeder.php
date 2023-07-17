<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    public function run()
    {
        $states = [
            ['name' => 'Johor', 'abbreviation' => 'JHR'],
            ['name' => 'Kedah', 'abbreviation' => 'KDH'],
            ['name' => 'Kelantan', 'abbreviation' => 'KTN'],
            ['name' => 'Melaka', 'abbreviation' => 'MLK'],
            ['name' => 'Negeri Sembilan', 'abbreviation' => 'NSN'],
            ['name' => 'Pahang', 'abbreviation' => 'PHG'],
            ['name' => 'Perak', 'abbreviation' => 'PRK'],
            ['name' => 'Perlis', 'abbreviation' => 'PLS'],
            ['name' => 'Pulau Pinang', 'abbreviation' => 'PNG'],
            ['name' => 'Sabah', 'abbreviation' => 'SBH'],
            ['name' => 'Sarawak', 'abbreviation' => 'SRW'],
            ['name' => 'Selangor', 'abbreviation' => 'SGR'],
            ['name' => 'Terengganu', 'abbreviation' => 'TRG'],
            ['name' => 'Kuala Lumpur', 'abbreviation' => 'KUL'],
            ['name' => 'Labuan', 'abbreviation' => 'LBN'],
            ['name' => 'Putrajaya', 'abbreviation' => 'PJY'],
        ];

        foreach ($states as $state) {
            State::create($state);
        }
    }
}
