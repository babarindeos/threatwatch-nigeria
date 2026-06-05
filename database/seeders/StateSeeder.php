<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StateSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            ['name' => 'Abia',           'lat' => 5.4527,   'lng' => 7.5248],
            ['name' => 'Adamawa',        'lat' => 9.3265,   'lng' => 12.3984],
            ['name' => 'Akwa Ibom',      'lat' => 4.9057,   'lng' => 7.8537],
            ['name' => 'Anambra',        'lat' => 6.2100,   'lng' => 7.0682],
            ['name' => 'Bauchi',         'lat' => 10.3158,  'lng' => 9.8442],
            ['name' => 'Bayelsa',        'lat' => 4.7719,   'lng' => 6.0699],
            ['name' => 'Benue',          'lat' => 7.3369,   'lng' => 8.7404],
            ['name' => 'Borno',          'lat' => 11.8846,  'lng' => 13.1520],
            ['name' => 'Cross River',    'lat' => 5.8702,   'lng' => 8.5988],
            ['name' => 'Delta',          'lat' => 5.5320,   'lng' => 5.8987],
            ['name' => 'Ebonyi',         'lat' => 6.2649,   'lng' => 8.0137],
            ['name' => 'Edo',            'lat' => 6.3350,   'lng' => 5.6037],
            ['name' => 'Ekiti',          'lat' => 7.7190,   'lng' => 5.3110],
            ['name' => 'Enugu',          'lat' => 6.4584,   'lng' => 7.5464],
            ['name' => 'FCT Abuja',      'lat' => 9.0575,   'lng' => 7.4898],
            ['name' => 'Gombe',          'lat' => 10.2791,  'lng' => 11.1670],
            ['name' => 'Imo',            'lat' => 5.5720,   'lng' => 7.0588],
            ['name' => 'Jigawa',         'lat' => 12.2280,  'lng' => 9.5616],
            ['name' => 'Kaduna',         'lat' => 10.5222,  'lng' => 7.4383],
            ['name' => 'Kano',           'lat' => 12.0022,  'lng' => 8.5920],
            ['name' => 'Katsina',        'lat' => 12.9816,  'lng' => 7.6166],
            ['name' => 'Kebbi',          'lat' => 11.4942,  'lng' => 4.2333],
            ['name' => 'Kogi',           'lat' => 7.7338,   'lng' => 6.6906],
            ['name' => 'Kwara',          'lat' => 8.9669,   'lng' => 4.5874],
            ['name' => 'Lagos',          'lat' => 6.5244,   'lng' => 3.3792],
            ['name' => 'Nasarawa',       'lat' => 8.5378,   'lng' => 8.3299],
            ['name' => 'Niger',          'lat' => 9.9309,   'lng' => 5.5983],
            ['name' => 'Ogun',           'lat' => 7.1600,   'lng' => 3.3500],
            ['name' => 'Ondo',           'lat' => 7.2500,   'lng' => 5.1950],
            ['name' => 'Osun',           'lat' => 7.5629,   'lng' => 4.5200],
            ['name' => 'Oyo',            'lat' => 8.1574,   'lng' => 3.6148],
            ['name' => 'Plateau',        'lat' => 9.2182,   'lng' => 9.5179],
            ['name' => 'Rivers',         'lat' => 5.0250,   'lng' => 6.5000],
            ['name' => 'Sokoto',         'lat' => 13.0059,  'lng' => 5.2476],
            ['name' => 'Taraba',         'lat' => 7.9994,   'lng' => 10.7739],
            ['name' => 'Yobe',           'lat' => 12.2939,  'lng' => 11.4390],
            ['name' => 'Zamfara',        'lat' => 12.1222,  'lng' => 6.2236],
        ];

        foreach ($states as $state) {
            State::firstOrCreate(
                ['name' => $state['name']],
                [
                    'name'      => $state['name'],
                    'slug'      => Str::slug($state['name']),
                    'latitude'  => $state['lat'],
                    'longitude' => $state['lng'],
                ]
            );
        }

        $this->command->info('✅ Seeded ' . count($states) . ' Nigerian states.');
    }
}
