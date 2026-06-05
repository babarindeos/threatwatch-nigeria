<?php

namespace Database\Seeders;

use App\Models\Helpline;
use Illuminate\Database\Seeder;

class HelplineSeeder extends Seeder
{
    public function run(): void
    {
        $national = [
            [
                'agency_name' => 'Nigeria Police Force — Emergency',
                'phone'       => '199',
                'phone_alt'   => '112',
                'category'    => 'police',
                'description' => 'National emergency police line. Available 24/7 across Nigeria.',
                'is_national' => true,
                'sort_order'  => 1,
            ],
            [
                'agency_name' => 'NEMA — National Emergency Management Agency',
                'phone'       => '0800 033 6362',
                'phone_alt'   => null,
                'category'    => 'nema',
                'description' => 'Disaster and emergency management agency.',
                'is_national' => true,
                'sort_order'  => 2,
            ],
            [
                'agency_name' => 'DSS — Department of State Services',
                'phone'       => '08057000001',
                'phone_alt'   => null,
                'category'    => 'dss',
                'description' => 'Intelligence and counter-terrorism tip line.',
                'is_national' => true,
                'sort_order'  => 3,
            ],
            [
                'agency_name' => 'EFCC — Economic and Financial Crimes Commission',
                'phone'       => '0800 100 8000',
                'phone_alt'   => null,
                'category'    => 'other',
                'description' => 'Report financial crimes and fraud.',
                'is_national' => true,
                'sort_order'  => 4,
            ],
            [
                'agency_name' => 'FRSC — Federal Road Safety Corps',
                'phone'       => '122',
                'phone_alt'   => '07002255372',
                'category'    => 'frsc',
                'description' => 'Road traffic emergencies and accidents.',
                'is_national' => true,
                'sort_order'  => 5,
            ],
            [
                'agency_name' => 'National Ambulance Service',
                'phone'       => '0700-AMBULANCE',
                'phone_alt'   => '0700-262-5226',
                'category'    => 'ambulance',
                'description' => 'Emergency medical services.',
                'is_national' => true,
                'sort_order'  => 6,
            ],
            [
                'agency_name' => 'Nigeria Civil Defence Corps',
                'phone'       => '0800-NSCDC-NG',
                'phone_alt'   => null,
                'category'    => 'civil_defence',
                'description' => 'Civil security and infrastructure protection.',
                'is_national' => true,
                'sort_order'  => 7,
            ],
            [
                'agency_name' => 'NAFDAC Consumer Protection',
                'phone'       => '0800-NAFDAC-1',
                'phone_alt'   => null,
                'category'    => 'other',
                'description' => 'Report counterfeit and unsafe products.',
                'is_national' => true,
                'sort_order'  => 8,
            ],
            [
                'agency_name' => 'Child Protection Helpline',
                'phone'       => '116',
                'phone_alt'   => null,
                'category'    => 'ngo',
                'description' => 'Report child abuse and trafficking.',
                'is_national' => true,
                'sort_order'  => 9,
            ],
            [
                'agency_name' => 'NDLEA — Drug Enforcement',
                'phone'       => '0800-NDLEA-00',
                'phone_alt'   => null,
                'category'    => 'other',
                'description' => 'Report drug trafficking and substance abuse.',
                'is_national' => true,
                'sort_order'  => 10,
            ],
            [
                'agency_name' => 'Nigerian Army Operations',
                'phone'       => '193',
                'phone_alt'   => null,
                'category'    => 'military',
                'description' => 'Military emergency line for terrorist threats.',
                'is_national' => true,
                'sort_order'  => 11,
            ],
            [
                'agency_name' => 'Federal Fire Service',
                'phone'       => '01-2720892',
                'phone_alt'   => '0700-FIRE-000',
                'category'    => 'fire',
                'description' => 'Federal capital fire emergency.',
                'is_national' => true,
                'sort_order'  => 12,
            ],
        ];

        foreach ($national as $item) {
            Helpline::firstOrCreate(
                ['agency_name' => $item['agency_name'], 'is_national' => true],
                array_merge($item, ['is_active' => true, 'state_id' => null, 'lga_id' => null])
            );
        }

        $this->command->info('✅ Seeded ' . count($national) . ' national helplines.');
    }
}
