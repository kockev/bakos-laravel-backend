<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            'FRESHQO KFT. SZABADSZÁLLÁS',
            'HIRÖS KFT.',
            'RÁKÓCZI KONYHA',
            'KECSKEMÉT VÁROS ÖNKORMÁNYZAT',
            'BALLÓSZÖG VÁROS ÖNKORMÁNYZAT',
            'KECSKEMÉTI REFORMÁTUS GIMNÁZIUM',
            'PRECÍZ KFT.',
            'HOMOKHÁTSÁG NONPROFIT KFT.',
            'RÉV SZENVEDÉLYBETEG-SEGÍTŐ SZOLGÁLAT',
            'BAKOS BT.',
        ];

        foreach ($companies as $company) {
            Company::create([
                                'name'        => $company,
                                'updated_by'  => null,
                            ]);
        }
    }
}
