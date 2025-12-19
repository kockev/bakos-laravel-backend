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
            'HELVÉCIA DIÉTA',
            'KECSKEMÉT VÁROS ÖNKORMÁNYZAT',
            'BALLÓSZÖG VÁROS ÖNKORMÁNYZAT',
            'KECSKEMÉTI REFORMÁTUS GIMNÁZIUM',
            'PRECÍZ KFT.',
            'HOMOKHÁTSÁG NONPROFIT KFT.',
            'RÉV SZENVEDÉLYBETEG-SEGÍTŐ SZOLGÁLAT',
        ];

        foreach ($companies as $company) {
            Company::create([
                                'name'        => $company,
                                'updated_by'  => null,
                            ]);
        }
    }
}
