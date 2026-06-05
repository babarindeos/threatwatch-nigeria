<?php

namespace Database\Seeders;

use App\Models\Helpline;
use App\Models\Incident;
use App\Models\Lga;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            StateSeeder::class,
            LgaSeeder::class,
            HelplineSeeder::class,
            IncidentSeeder::class,
        ]);
    }
}
