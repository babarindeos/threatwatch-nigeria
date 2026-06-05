<?php

namespace Database\Seeders;

use App\Models\Lga;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LgaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Lagos' => [
                'Agege', 'Ajeromi-Ifelodun', 'Alimosho', 'Amuwo-Odofin', 'Apapa',
                'Badagry', 'Epe', 'Eti-Osa', 'Ibeju-Lekki', 'Ifako-Ijaiye',
                'Ikeja', 'Ikorodu', 'Kosofe', 'Lagos Island', 'Lagos Mainland',
                'Mushin', 'Ojo', 'Oshodi-Isolo', 'Shomolu', 'Surulere',
            ],
            'Kano' => [
                'Ajingi', 'Albasu', 'Bagwai', 'Bebeji', 'Bichi', 'Bunkure',
                'Dala', 'Dambatta', 'Dawakin Kudu', 'Dawakin Tofa', 'Doguwa',
                'Fagge', 'Gabasawa', 'Garko', 'Gwarzo', 'Kabo', 'Kano Municipal',
                'Karaye', 'Kibiya', 'Kiru', 'Kumbotso', 'Madobi', 'Makoda',
                'Minjibir', 'Nassarawa', 'Rano', 'Rimin Gado', 'Rogo', 'Shanono',
                'Sumaila', 'Takai', 'Tarauni', 'Tofa', 'Tsanyawa', 'Tudun Wada',
                'Ungogo', 'Warawa', 'Wudil',
            ],
            'FCT Abuja' => [
                'Abaji', 'Bwari', 'Gwagwalada', 'Kuje', 'Kwali', 'Municipal Area Council',
            ],
            'Rivers' => [
                'Abua-Odual', 'Ahoada East', 'Ahoada West', 'Akuku-Toru', 'Andoni',
                'Asari-Toru', 'Bonny', 'Degema', 'Eleme', 'Emuoha', 'Etche',
                'Gokana', 'Ikwerre', 'Khana', 'Obio-Akpor', 'Ogba-Egbema-Ndoni',
                'Ogba-Egbema', 'Ogu-Bolo', 'Okrika', 'Omuma', 'Opobo-Nkoro',
                'Oyigbo', 'Port Harcourt', 'Tai',
            ],
            'Borno' => [
                'Abadam', 'Askira-Uba', 'Bama', 'Bayo', 'Biu', 'Chibok',
                'Damboa', 'Dikwa', 'Gubio', 'Guzamala', 'Gwoza', 'Hawul',
                'Jere', 'Kaga', 'Kala-Balge', 'Konduga', 'Kukawa', 'Kwaya-Kusar',
                'Mafa', 'Magumeri', 'Maiduguri', 'Marte', 'Mobbar', 'Monguno',
                'Ngala', 'Nganzai', 'Shani',
            ],
            'Kaduna' => [
                'Birnin Gwari', 'Chikun', 'Giwa', 'Igabi', 'Ikara', 'Jaba',
                'Jema\'a', 'Kachia', 'Kaduna North', 'Kaduna South', 'Kagarko',
                'Kajuru', 'Kaura', 'Kauru', 'Kubau', 'Kudan', 'Lere',
                'Makarfi', 'Sabon Gari', 'Sanga', 'Soba', 'Zangon Kataf', 'Zaria',
            ],
            'Zamfara' => [
                'Anka', 'Bakura', 'Birnin Magaji', 'Bukkuyum', 'Bungudu',
                'Gummi', 'Gusau', 'Kaura Namoda', 'Maradun', 'Maru',
                'Shinkafi', 'Talata Mafara', 'Tsafe', 'Zurmi',
            ],
            'Katsina' => [
                'Bakori', 'Batagarawa', 'Batsari', 'Baure', 'Bindawa',
                'Charanchi', 'Dan Musa', 'Dandume', 'Danja', 'Daura',
                'Dutsi', 'Dutsin-Ma', 'Faskari', 'Funtua', 'Ingawa',
                'Jibia', 'Kafur', 'Kaita', 'Kankara', 'Kankia', 'Katsina',
                'Kurfi', 'Kusada', 'Mai\'Adua', 'Malumfashi', 'Mani',
                'Mashi', 'Matazu', 'Musawa', 'Rimi', 'Sabuwa', 'Safana',
                'Sandamu', 'Zango',
            ],
            'Sokoto' => [
                'Binji', 'Bodinga', 'Dange-Shuni', 'Gada', 'Goronyo',
                'Gudu', 'Gwadabawa', 'Illela', 'Isa', 'Kebbe', 'Kware',
                'Rabah', 'Sabon Birni', 'Shagari', 'Silame', 'Sokoto North',
                'Sokoto South', 'Tambuwal', 'Tangaza', 'Tureta', 'Wamako', 'Wurno', 'Yabo',
            ],
            'Plateau' => [
                'Barkin Ladi', 'Bassa', 'Bokkos', 'Jos East', 'Jos North',
                'Jos South', 'Kanam', 'Kanke', 'Langtang North', 'Langtang South',
                'Mangu', 'Mikang', 'Pankshin', 'Qua\'an Pan', 'Riyom', 'Shendam', 'Wase',
            ],
            'Anambra' => [
                'Aguata', 'Anambra East', 'Anambra West', 'Anaocha', 'Awka North',
                'Awka South', 'Ayamelum', 'Dunukofia', 'Ekwusigo', 'Idemili North',
                'Idemili South', 'Ihiala', 'Njikoka', 'Nnewi North', 'Nnewi South',
                'Ogbaru', 'Onitsha North', 'Onitsha South', 'Orumba North',
                'Orumba South', 'Oyi',
            ],
            'Oyo' => [
                'Afijio', 'Akinyele', 'Atiba', 'Atisbo', 'Egbeda', 'Ibadan North',
                'Ibadan North-East', 'Ibadan North-West', 'Ibadan South-East',
                'Ibadan South-West', 'Ibarapa Central', 'Ibarapa East', 'Ibarapa North',
                'Ido', 'Irepo', 'Iseyin', 'Itesiwaju', 'Iwajowa', 'Kajola',
                'Lagelu', 'Ogbomosho North', 'Ogbomosho South', 'Ogo Oluwa', 'Olorunsogo',
                'Oluyole', 'Ona Ara', 'Orelope', 'Ori Ire', 'Oyo East', 'Oyo West',
                'Saki East', 'Saki West', 'Surulere',
            ],
            'Delta' => [
                'Aniocha North', 'Aniocha South', 'Bomadi', 'Burutu', 'Ethiope East',
                'Ethiope West', 'Ika North East', 'Ika South', 'Isoko North',
                'Isoko South', 'Ndokwa East', 'Ndokwa West', 'Okpe', 'Oshimili North',
                'Oshimili South', 'Patani', 'Sapele', 'Udu', 'Ughelli North',
                'Ughelli South', 'Ukwuani', 'Uvwie', 'Warri North', 'Warri South',
                'Warri South West',
            ],
            'Imo' => [
                'Aboh Mbaise', 'Ahiazu Mbaise', 'Ehime Mbano', 'Ezinihitte Mbaise',
                'Ideato North', 'Ideato South', 'Ihitte-Uboma', 'Ikeduru',
                'Isiala Mbano', 'Isu', 'Mbaitoli', 'Ngor Okpala', 'Njaba',
                'Nkwerre', 'Nwangele', 'Obowo', 'Oguta', 'Ohaji-Egbema',
                'Okigwe', 'Orlu', 'Orsu', 'Oru East', 'Oru West',
                'Owerri Municipal', 'Owerri North', 'Owerri West', 'Unuimo',
            ],
        ];

        // Add remaining states with generic capital LGA
        $allStateNames = State::pluck('name')->toArray();
        foreach ($allStateNames as $stateName) {
            if (!isset($data[$stateName])) {
                $data[$stateName] = [$stateName . ' Capital', $stateName . ' East', $stateName . ' West', $stateName . ' North', $stateName . ' South'];
            }
        }

        $inserted = 0;
        foreach ($data as $stateName => $lgaNames) {
            $state = State::where('name', $stateName)->first();
            if (!$state) continue;

            foreach ($lgaNames as $lgaName) {
                Lga::firstOrCreate(
                    ['state_id' => $state->id, 'slug' => Str::slug($lgaName)],
                    [
                        'state_id' => $state->id,
                        'name'     => $lgaName,
                        'slug'     => Str::slug($lgaName),
                    ]
                );
                $inserted++;
            }
        }

        $this->command->info("✅ Seeded {$inserted} LGAs.");
    }
}
