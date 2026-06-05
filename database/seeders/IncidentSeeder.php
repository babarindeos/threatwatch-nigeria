<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IncidentSeeder extends Seeder
{
    public function run(): void
    {
        $admin  = User::where('role', 'super_admin')->first();
        $states = State::pluck('id', 'name');

        $samples = [
            [
                'title'           => 'Gunmen attack convoy on Abuja-Kaduna Highway',
                'state'           => 'Kaduna',
                'town'            => 'Kafanchan',
                'attack_type'     => 'banditry',
                'severity'        => 'critical',
                'description'     => 'Armed bandits ambushed a civilian convoy along the Abuja-Kaduna highway near Kafanchan junction. At least 3 vehicles were attacked. Security forces were alerted and responded within 30 minutes. The assailants fled into the forest after engagement with troops.',
                'casualties'      => 4,
                'kidnapped_count' => 7,
                'lat'             => 10.2791, 'lng' => 7.4383,
                'date'            => '2024-11-15',
            ],
            [
                'title'           => 'Kidnap-for-ransom gang neutralized in Borno',
                'state'           => 'Borno',
                'town'            => 'Konduga',
                'attack_type'     => 'kidnapping',
                'severity'        => 'high',
                'description'     => 'Nigerian Army troops attached to Operation HADIN KAI neutralized a kidnap-for-ransom gang in Konduga area of Borno State. 12 victims were rescued and 5 insurgents eliminated during the operation.',
                'casualties'      => 5,
                'kidnapped_count' => 12,
                'lat'             => 11.60, 'lng' => 13.25,
                'date'            => '2024-11-10',
            ],
            [
                'title'           => 'Armed robbery at First Bank branch in Owerri',
                'state'           => 'Imo',
                'town'            => 'Owerri',
                'attack_type'     => 'armed_robbery',
                'severity'        => 'high',
                'description'     => 'A group of about 8 armed men stormed the First Bank branch along Douglas Road, Owerri. They overpowered security guards and made away with an undisclosed amount. Two bank staff sustained injuries from pistol whipping.',
                'casualties'      => 0,
                'kidnapped_count' => 0,
                'lat'             => 5.4920, 'lng' => 7.0340,
                'date'            => '2024-11-08',
            ],
            [
                'title'           => 'Fulani herdsmen attack farming community in Plateau',
                'state'           => 'Plateau',
                'town'            => 'Barkin Ladi',
                'attack_type'     => 'herdsmen_attack',
                'severity'        => 'critical',
                'description'     => 'Armed herdsmen invaded the Maiyanga farming community in Barkin Ladi LGA at dawn, setting fire to homes and shooting at fleeing residents. Over 200 residents have been displaced.',
                'casualties'      => 11,
                'kidnapped_count' => 0,
                'lat'             => 9.5179, 'lng' => 8.9987,
                'date'            => '2024-11-05',
            ],
            [
                'title'           => 'ISWAP terrorists bomb military base in Maiduguri outskirts',
                'state'           => 'Borno',
                'town'            => 'Maiduguri',
                'attack_type'     => 'terrorism',
                'severity'        => 'critical',
                'description'     => 'Islamic State West Africa Province (ISWAP) claimed responsibility for a suicide bomb attack on a military checkpoint 15km outside Maiduguri. Nigerian Army has sealed off the area and launched a counter-offensive.',
                'casualties'      => 8,
                'kidnapped_count' => 0,
                'lat'             => 11.8315, 'lng' => 13.1509,
                'date'            => '2024-11-01',
            ],
            [
                'title'           => 'Communal clash between Ife and Modakeke communities',
                'state'           => 'Osun',
                'town'            => 'Ile-Ife',
                'attack_type'     => 'communal_clash',
                'severity'        => 'high',
                'description'     => 'Renewed tensions between the Ife and Modakeke communities led to violent clashes involving machetes and firearms. Police and military have been deployed to restore order. A 24-hour curfew has been imposed in affected areas.',
                'casualties'      => 6,
                'kidnapped_count' => 0,
                'lat'             => 7.4875, 'lng' => 4.5624,
                'date'            => '2024-10-28',
            ],
            [
                'title'           => 'Cybercriminals scam hundreds via fake BVN update portal',
                'state'           => 'Lagos',
                'town'            => 'Lagos Island',
                'attack_type'     => 'cybercrime',
                'severity'        => 'medium',
                'description'     => 'The Economic and Financial Crimes Commission (EFCC) has raised the alarm over a sophisticated phishing scheme targeting bank customers through a fake CBN BVN update portal. Over 400 victims have been identified with combined losses exceeding ₦45 million.',
                'casualties'      => 0,
                'kidnapped_count' => 0,
                'lat'             => 6.4541, 'lng' => 3.3947,
                'date'            => '2024-10-25',
            ],
            [
                'title'           => 'Bandit attack on market in Zamfara leaves traders dead',
                'state'           => 'Zamfara',
                'town'            => 'Gusau',
                'attack_type'     => 'banditry',
                'severity'        => 'critical',
                'description'     => 'Dozens of armed bandits stormed the weekly market in Tsafe area of Zamfara State, shooting sporadically at market-goers. Several traders sustained gunshot wounds. The attackers also rustled hundreds of cattle from nearby communities.',
                'casualties'      => 14,
                'kidnapped_count' => 3,
                'lat'             => 12.1222, 'lng' => 6.6611,
                'date'            => '2024-10-22',
            ],
            [
                'title'           => 'Oil pipeline vandalism and explosion in Warri',
                'state'           => 'Delta',
                'town'            => 'Warri',
                'attack_type'     => 'other',
                'severity'        => 'high',
                'description'     => 'Unknown saboteurs blew up a NNPC oil pipeline near Warri causing a massive fire. Surrounding communities have been warned to stay away. Environmental damage is extensive with crude oil spillage affecting nearby waterways.',
                'casualties'      => 2,
                'kidnapped_count' => 0,
                'lat'             => 5.5167, 'lng' => 5.7500,
                'date'            => '2024-10-18',
            ],
            [
                'title'           => 'Cult clash leaves students injured in Port Harcourt',
                'state'           => 'Rivers',
                'town'            => 'Port Harcourt',
                'attack_type'     => 'cult_clash',
                'severity'        => 'high',
                'description'     => 'Rival cult groups clashed near the University of Port Harcourt main campus, leaving several students caught in the crossfire. The vice chancellor has suspended academic activities for 72 hours pending investigation.',
                'casualties'      => 3,
                'kidnapped_count' => 0,
                'lat'             => 4.8396, 'lng' => 6.9060,
                'date'            => '2024-10-12',
            ],
        ];

        foreach ($samples as $sample) {
            $stateId = $states[$sample['state']] ?? null;
            if (!$stateId) continue;

            Incident::firstOrCreate(
                ['title' => $sample['title']],
                [
                    'state_id'        => $stateId,
                    'town'            => $sample['town'],
                    'attack_type'     => $sample['attack_type'],
                    'severity'        => $sample['severity'],
                    'description'     => $sample['description'],
                    'casualties'      => $sample['casualties'],
                    'kidnapped_count' => $sample['kidnapped_count'],
                    'latitude'        => $sample['lat'],
                    'longitude'       => $sample['lng'],
                    'incident_date'   => $sample['date'],
                    'incident_time'   => '08:00',
                    'status'          => 'approved',
                    'created_by'      => $admin->id,
                    'approved_by'     => $admin->id,
                    'approved_at'     => now(),
                    'is_anonymous'    => false,
                ]
            );
        }

        $this->command->info('✅ Seeded ' . count($samples) . ' sample incidents.');
    }
}
