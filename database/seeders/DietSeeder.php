<?php

namespace Database\Seeders;

use App\Models\Diet;
use Illuminate\Database\Seeder;

class DietSeeder extends Seeder
{
    public function run(): void
    {
        $diets = [
            'Diabetikus 40 gr',
            'Diabetikus 50 gr',
            'Diabetikus 60 gr',
            'Diabetikus 70 gr',
            'Diabetikus 90 gr',
            'Diabetikus 45 gr',
            'Diabetikus, gluténmentes 55 gr',
            'Diabetikus, gluténmentes 60 gr',
            'Diabetikus 80 gr',
            'Diabetikus, tejmentes, tojásmentes, gluténmentes',
            'Fruktóz szegény',
            'Fruktóz szegény ovi',
            'Fruktóz szegény, tej, tojásmentes, gluténmentes',
            'Fruktóz szegény, tejmentes',
            'Galaktozémia (tej, hüvelyes, szója, belsőség mentes)',
            'Glutén, alma, narancs mentes',
            'Gluténmentes',
            'Gluténmentes- tejmentes',
            'Gluténmentes- tejmentes- hüvelyes mentes',
            'Gluténmentes- tejmentes- tojásmentes',
            'Hal, glutén, citrus mentes',
            'Hal, tej, paradicsom mentes',
            'Inzulin rezisztens 50 gr',
            'Inzulin rezisztens 60 gr',
            'Inzulin rezisztens, tejmentes 50 gr',
            'Olajos mag mentes',
            'Reflux',
            'Reflux, tejmentes',
            'Reflux, tejmentes, tojásmentes',
            'Tartósítószer mentes',
            'Tej, mustár mentes',
            'Tej, paradicsom mentes',
            'Tej, tojás, szárnyashús, marhahús mentes',
            'Tejmentes',
            'Tejmentes- tojásmentes',
            'Tojásmentes',
            'Diabetikus 35 gr',
            'Diabetikus 65 gr',
            'Diab.fruktóz45',
            'diab. 60 paradicsommentes, tejmentes',
            'tej, tartósító',
            'Diabetikus 50 gr, tejmentes',
            'Diabetikus 30 gr',
            'Diabetikus, gluténmentes 60 gr, tejmentes',
            'Laktózmentes',
            'Tejmentes- szójamentes',
            'Tejmentes- citrus-olajosmag mentes',
            'Tejmentes- tojásmentes, szójamentes',
            'Tejmentes- tojásmentes, szójamentes, fruktóz szegény',
            'Glutén-tej-szójamentes',
            'Olajos mag mentes-szójamentes',
            'Glutén-tojásmentes',
            'Glutén-tojás-hal-pulyka-szója-alma mentes',
            'Glutén-Tejmentes- tojásmentes, szójamentes',
            'Tej-olajos mag mentes',
            'Tej-citrus mentes',
            'Hal-tej-glutén-zellermentes',
            'Tej-tojás-olajos mag mentes',
            'Szója-len-teljeskiőrlésű gabona mentes',
            'Szamóca-Erdei gyümölcs mentes',
            'Tej-olajos mag mentes',
            'tej, tojás, búza, rozs, mustár, mogyorómentes',
            'Búzamentes',
            'Halmentes',
            'Sertéshúsmentes',
            'Tej-burgonya mentes',
        ];

        foreach ($diets as $diet) {
            Diet::create([
                             'name'        => $diet,
                             'description' => null,
                             'updated_by'  => null,
                         ]);
        }
    }
}
