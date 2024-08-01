<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Document;
use App\Models\Dropdown;
use App\Models\Map;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        User::create([
            'name' => 'admin',
            'password' => Hash::make('password'),
            'role' => '0',
        ]);

        User::create([
            'name' => 'user',
            'password' => Hash::make('password'),
            'role' => '1',
        ]);

        DB::table('dropdowns')->delete();
        DB::statement('ALTER TABLE dropdowns AUTO_INCREMENT = 1;');


        $dropdowns = [
            '0' => [
                'type' => ['sto'],
                'subtype' => ['ampel gading']
            ],
            '1' => [
                'type' => ['sto'],
                'subtype' => ['bantur']
            ],
            '2' => [
                'type' => ['sto'],
                'subtype' => ['batu']
            ],
            '3' => [
                'type' => ['sto'],
                'subtype' => ['blimbing']
            ],
            '4' => [
                'type' => ['sto'],
                'subtype' => ['buring']
            ],
            '5' => [
                'type' => ['sto'],
                'subtype' => ['dampit']
            ],
            '6' => [
                'type' => ['sto'],
                'subtype' => ['dono mulyo']
            ],
            '7' => [
                'type' => ['sto'],
                'subtype' => ['gadang']
            ],
            '8' => [
                'type' => ['sto'],
                'subtype' => ['gondanglegi']
            ],
            '9' => [
                'type' => ['sto'],
                'subtype' => ['gunung kawi']
            ],
            '10' => [
                'type' => ['sto'],
                'subtype' => ['karang ploso']
            ],
            '11' => [
                'type' => ['sto'],
                'subtype' => ['kepanjen']
            ],
            '12' => [
                'type' => ['sto'],
                'subtype' => ['klojen']
            ],
            '13' => [
                'type' => ['sto'],
                'subtype' => ['lawang']
            ],
            '14' => [
                'type' => ['sto'],
                'subtype' => ['malang']
            ],
            '15' => [
                'type' => ['sto'],
                'subtype' => ['malang kota']
            ],
            '16' => [
                'type' => ['sto'],
                'subtype' => ['ngantang']
            ],
            '17' => [
                'type' => ['sto'],
                'subtype' => ['pagak']
            ],
            '18' => [
                'type' => ['sto'],
                'subtype' => ['pakis']
            ],
            '19' => [
                'type' => ['sto'],
                'subtype' => ['sawojajar']
            ],
            '20' => [
                'type' => ['sto'],
                'subtype' => ['singosari']
            ],
            '21' => [
                'type' => ['sto'],
                'subtype' => ['sumber manjing']
            ],
            '22' => [
                'type' => ['sto'],
                'subtype' => ['sumber pucung']
            ],
            '23' => [
                'type' => ['sto'],
                'subtype' => ['tumpang']
            ],
            '24' => [
                'type' => ['sto'],
                'subtype' => ['turen']
            ],
            '25' => [
                'type' => ['room'],
                'subtype' => ['R. MITRA'],
            ],
            '26' => [
                'type' => ['room'],
                'subtype' => ['R. BATTERY NEW NGN'],
            ],
            '27' => [
                'type' => ['room'],
                'subtype' => ['R. DWDM'],
            ],
            '28' => [
                'type' => ['room'],
                'subtype' => ['R.DDF'],
            ],
            '29' => [
                'type' => ['room'],
                'subtype' => ['R. DIESEL'],
            ],
            '30' => [
                'type' => ['room'],
                'subtype' => ['R. RECTI BENING'],
            ],
            '31' => [
                'type' => ['room'],
                'subtype' => ['R. AULA BESAR'],
            ],
            '32' => [
                'type' => ['room'],
                'subtype' => ['R. NEW NGN'],
            ],
            '33' => [
                'type' => ['room'],
                'subtype' => ['R. NGN OLD'],
            ],
            '34' => [
                'type' => ['room'],
                'subtype' => ['R. BATTERY BAWAH'],
            ],
            '35' => [
                'type' => ['room'],
                'subtype' => ['R. MDP DIESEL'],
            ],
            '36' => [
                'type' => ['room'],
                'subtype' => ['TOWER'],
            ],
            '37' => [
                'type' => ['room'],
                'subtype' => ['R. PERSONIL SKSO'],
            ],
            '38' => [
                'type' => ['room'],
                'subtype' => ['R. DDF'],
            ],
            '39' => [
                'type' => ['room'],
                'subtype' => ['AREA PARKIR'],
            ],
            '40' => [
                'type' => ['room'],
                'subtype' => ['SAMPING GEDUNG'],
            ],
            '41' => [
                'type' => ['room'],
                'subtype' => ['R. MAC LT.2'],
            ],
            '42' => [
                'type' => ['room'],
                'subtype' => ['R. RECTI BAWAH'],
            ],
            '43' => [
                'type' => ['room'],
                'subtype' => ['R.TRANSMISI'],
            ],
            '44' => [
                'type' => ['room'],
                'subtype' => ['LORONG STO AMP'],
            ],
            '45' => [
                'type' => ['room'],
                'subtype' => ['R.BATERAY'],
            ],
            '46' => [
                'type' => ['room'],
                'subtype' => ['R.RECTIFIER'],
            ],
            '47' => [
                'type' => ['room'],
                'subtype' => ['R.EXSENTRAL'],
            ],
            '48' => [
                'type' => ['room'],
                'subtype' => ['R.GENSET'],
            ],
            '49' => [
                'type' => ['room'],
                'subtype' => ['R.BATTERY'],
            ],
            '50' => [
                'type' => ['room'],
                'subtype' => ['POS SECURITY'],
            ],
            '51' => [
                'type' => ['room'],
                'subtype' => ['TOWER AREA'],
            ],
            '52' => [
                'type' => ['room'],
                'subtype' => ['PINTU PAGAR'],
            ],
            '53' => [
                'type' => ['room'],
                'subtype' => ['R. SENTRAL'],
            ],
            '54' => [
                'type' => ['room'],
                'subtype' => ['R. TRANSMISI'],
            ],
            '55' => [
                'type' => ['room'],
                'subtype' => ['R. BATTERY'],
            ],
            '56' => [
                'type' => ['room'],
                'subtype' => ['R. JANM'],
            ],
            '57' => [
                'type' => ['room'],
                'subtype' => ['R. RECTIFIER'],
            ],
            '58' => [
                'type' => ['room'],
                'subtype' => ['R.LANTAI 2'],
            ],
            '59' => [
                'type' => ['room'],
                'subtype' => ['R.MDP'],
            ],
            '60' => [
                'type' => ['room'],
                'subtype' => ['GEDUNG STO BURING'],
            ],
            '61' => [
                'type' => ['room'],
                'subtype' => ['R.DIESEL'],
            ],
            '62' => [
                'type' => ['room'],
                'subtype' => ['R.SENTRAL'],
            ],
            '63' => [
                'type' => ['room'],
                'subtype' => ['R.EKS SENTRAL'],
            ],
            '64' => [
                'type' => ['room'],
                'subtype' => ['R. GENSET'],
            ],
            '65' => [
                'type' => ['room'],
                'subtype' => ['R. SAMPING TANDON BBM'],
            ],
            '66' => [
                'type' => ['room'],
                'subtype' => ['R.MDF'],
            ],
            '67' => [
                'type' => ['room'],
                'subtype' => ['R.SENTRAL/METRO'],
            ],
            '68' => [
                'type' => ['room'],
                'subtype' => ['R BATTERY'],
            ],
            '69' => [
                'type' => ['room'],
                'subtype' => ['BAWAH TOWER'],
            ],
            '70' => [
                'type' => ['room'],
                'subtype' => ['DEPAN GUDANG TA'],
            ],
            '71' => [
                'type' => ['room'],
                'subtype' => ['SAMPING RUANG SENTRAL'],
            ],
            '72' => [
                'type' => ['room'],
                'subtype' => ['R.GPON'],
            ],
            '73' => [
                'type' => ['room'],
                'subtype' => ['TAMAN'],
            ],
            '74' => [
                'type' => ['room'],
                'subtype' => ['LORONG LT.2'],
            ],
            '75' => [
                'type' => ['room'],
                'subtype' => ['AREA TOWER'],
            ],
            '76' => [
                'type' => ['room'],
                'subtype' => ['R.DISEL'],
            ],
            '77' => [
                'type' => ['room'],
                'subtype' => ['R. FTM'],
            ],

            '78' => [
                'type' => ['category'],
                'subtype' => ['AC SPLIT'],
            ],
            '79' => [
                'type' => ['category'],
                'subtype' => ['AC PRESISI'],
            ],
            '80' => [
                'type' => ['category'],
                'subtype' => ['BATTERE'],
            ],
            '81' => [
                'type' => ['category'],
                'subtype' => ['DIESEL ENGINE / AMF'],
            ],
            '82' => [
                'type' => ['category'],
                'subtype' => ['RECTIFIER'],
            ],
            '83' => [
                'type' => ['category'],
                'subtype' => ['INSTALASI DAYA'],
            ],
            '84' => [
                'type' => ['category'],
                'subtype' => ['OSASE'],
            ],
            '85' => [
                'type' => ['category'],
                'subtype' => ['GROUNDING'],
            ],
            '86' => [
                'type' => ['category'],
                'subtype' => ['INVERTER'],
            ],
            '87' => [
                'type' => ['category'],
                'subtype' => ['CAPASITOR BANK'],
            ],
            '88' => [
                'type' => ['category'],
                'subtype' => ['DIESEL MOBILE'],
            ],




        ];

        foreach ($dropdowns as $dropdown) {
            foreach ($dropdown['type'] as $type) {
                foreach ($dropdown['subtype'] as $subtype) {
                    Dropdown::create([
                        'type' => $type,
                        'subtype' => ucfirst(strtolower($subtype)),
                    ]);
                }
            }
        }
    }
}
