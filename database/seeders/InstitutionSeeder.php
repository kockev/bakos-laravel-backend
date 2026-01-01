<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Institution;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::pluck('id', 'name');

        $data = [
            'FRESHQO KFT. SZABADSZÁLLÁS' => [
                ['name' => 'TÓTH ERZSÉBET ÓVODA ÉS BÖLCSŐDE', 'address' => '6080 SZABADSZÁLLÁS, HONVÉD U. 28.'],
                ['name' => 'PETŐFI SÁNDOR ÁLTALÁNOS ISKOLA', 'address' => '6080 SZABADSZÁLLÁS, KÁLVIN TÉR 8.'],
                ['name' => 'STRÁZSA TANYA SZOCIÁLIS SZÖVETKEZET', 'address' => '6080 SZABADSZÁLLÁS, ALSÓSZŐLŐK TANYA 2702/2'],
                ['name' => 'STRÁZSA KÉGLI NKFT', 'address' => '6080 SZABADSZÁLLÁS, HONVÉD U. 10/A'],
                ['name' => 'TÁNCSICS MIHÁLY ÁLTALÁNOS ISKOLA', 'address' => '6070 IZSÁK, KOSSUTH L. U. 39.'],
                ['name' => 'ÁMK ÓVODA ÉS BÖLCSŐDE', 'address' => '6070 IZSÁK, KODÁLY Z. U. 2.'],
                ['name' => 'PETŐFI SÁNDOR ÁLTALÁNOS ISKOLA', 'address' => '6086 SZALKSZENTMÁRTON, PETŐFI TÉR 12.'],
                ['name' => 'MESEVÁR ÓVODA ÉS BÖLCSŐDE', 'address' => '6085 FÜLÖPSZÁLLÁS, JÓZSEF A. U. 3.'],
                ['name' => 'HERPAI VILMOS ÁLTALÁNOS ISKOLA', 'address' => '6085 FÜLÖPSZÁLLÁS, PETŐFI S. U. 4.'],
                ['name' => 'KADAFALVI ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, BORÓKA UTCA 4.'],
                ['name' => 'MATHIAS JÁNOS ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, KATONA ZSIGMOND UTCA 1.'],
            ],

            'HIRÖS KFT.' => [
                ['name' => '(HIRÖS) VÍZMŰ KFT.', 'address' => '6000 KECSKEMÉT, IZSÁKI ÚT 15.'],
                ['name' => 'VÁSÁRHELYI PÁL ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, ALKONY U. 11.'],
                ['name' => 'BÉKE TÉRI ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, BOLDOGASSZONY TÉR 7.'],
                ['name' => 'MAGYAR ILONA ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, HOFFMANN JÁNOS U. 8.'],
                ['name' => 'LÁNCHÍD UTCAI ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, LÁNCHÍD U. 18.'],
                ['name' => 'ARANY JÁNOS ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, LUNKÁNYI JÁNOS U. 10.'],
                ['name' => 'BARACKVIRÁG EVANGÉLIKUS ÓVODA', 'address' => '6000 KECSKEMÉT, KVARC U. 2.'],
                ['name' => 'KINDER OVI NÉMET–MAGYAR NYELVŰ MAGÁNÓVODA', 'address' => '6000 KECSKEMÉT, DUNA UTCA 21.'],
                ['name' => 'BAMBINO-HÁZ CSALÁDI BÖLCSŐDE', 'address' => '6000 KECSKEMÉT, JÓKAI U. 12.'],
                ['name' => 'KINCSKERESŐ ÓVODA ÉS BÖLCSŐDE', 'address' => '6032 NYÁRLŐRINC, DÓZSA GYÖRGY U. 11.'],
            ],

            'RÁKÓCZI KONYHA' => [
                ['name' => 'HELVÉCIAI KEREKERDŐ ÓVODA', 'address' => '6034 HELVÉCIA, ÓVODA U. 1.'],
                ['name' => 'FEKETEERDŐI ÁLTALÁNOS ISKOLA', 'address' => '6034 HELVÉCIA, KORHÁNKÖZI ÚT 1.'],
                ['name' => 'HELVÉCIAI NAPVIRÁG ÓVODA ÉS BÖLCSŐDE', 'address' => '6034 HELVÉCIA, SPORT U. 29.'],
                ['name' => 'HELVÉCIAI PITYPANG BÖLCSŐDE', 'address' => '6034 HELVÉCIA, ÓVODA U. 1.'],
                ['name' => 'WÉBER EDE ÁLTALÁNOS ISKOLA', 'address' => '6034 HELVÉCIA, KISKŐRÖSI ÚT 71.'],
                ['name' => 'HUNYADI JÁNOS ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, KANDÓ KÁLMÁN UTCA 14.'],
                ['name' => 'ZRÍNYI ILONA ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, KATONA JÓZSEF TÉR 14.'],
                ['name' => 'MÉNTELEKI KOLPING KATOLIKUS ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, KECSKEMÉTI ÚT 41.'],
                ['name' => 'MÓRICZ ZSIGMOND ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, MÓRICZ UTCA'],
            ],

            'KECSKEMÉT VÁROS ÖNKORMÁNYZAT' => [
                ['name' => 'MÁTYÁS KIRÁLY ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, MÁTYÁS KIRÁLY KÖRÚT 46.'],
                ['name' => 'PIÁR FIÚKOLLÉGIUM', 'address' => '6000 KECSKEMÉT, PIARISTÁK TERE'],
                ['name' => 'PIÁR ÓVODA', 'address' => '6000 KECSKEMÉT, CZOLLNER TÉR 3-5.'],
                ['name' => 'SZENT IMRE ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, SZENT IMRE UTCA 9.'],
                ['name' => 'PETŐFI SÁNDOR ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, MÉSZÖLY GYULA TÉR 1-3.'],
                ['name' => 'MÓRA FERENC ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, FORRADALOM UTCA 1.'],
                ['name' => 'NYÍRI ÚTI - EGYMI (AUTISTA ÓVODA)', 'address' => '6000 KECSKEMÉT, NYÍRI ÚT 30.'],
                ['name' => 'NYÍRI ÚTI EGYMI - SZALAG UTCA', 'address' => '6000 KECSKEMÉT, SZALAG UTCA 4.'],
                ['name' => 'MÓRA+LOGI', 'address' => '6000 KECSKEMÉT, FORRADALOM UTCA 1.'],
                ['name' => 'SZENT IMRE ÓVODA', 'address' => '6000 KECSKEMÉT, SZENT IMRE UTCA 9.'],
                ['name' => 'TELEKI ÓVODA', 'address' => '6000 KECSKEMÉT, TELEKI LÁSZLÓ UTCA 1.'],
                ['name' => 'BOCSKAI UTCAI ÓVODA', 'address' => '6000 KECSKEMÉT, BOCSKAI UTCA 19.'],
                ['name' => 'ARANYKAPU MAGÁNÓVODA', 'address' => '6000 KECSKEMÉT, MIKSZÁTH KÁLMÁN KRT. 86.'],
                ['name' => 'KASZAP UTCAI ÓVODA', 'address' => '6000 KECSKEMÉT, KASZAP UTCA 6-14.'],
                ['name' => 'CSILLAGBÖLCSŐ WALDORF ÓVODA', 'address' => '6000 KECSKEMÉT, NAPSUGÁR UTCA 2.'],
                ['name' => 'CSILLAGBÖLCSŐ WALDORF ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, SZOLNOKI ÚT 20.'],
                ['name' => 'NOÉ BÁRKÁJA ÓVODA', 'address' => '6000 KECSKEMÉT, KISKŐRÖSI ÚT 8.'],
                ['name' => 'GÁSPÁR ANDRÁS SZAKKÖZÉPISKOLA', 'address' => '6000 KECSKEMÉT, HUNYADI JÁNOS TÉR 2.'],
                ['name' => 'KANDÓ KÁLMÁN SZAKISKOLA', 'address' => '6000 KECSKEMÉT, BETHLEN KÖRÚT 63.'],
                ['name' => 'GRÓF KÁROLYI SÁNDOR SZAKKÖZÉPISKOLA', 'address' => '6000 KECSKEMÉT, BIBÓ ISTVÁN UTCA 1.'],
                ['name' => 'KATONA JÓZSEF GIMNÁZIUM', 'address' => '6000 KECSKEMÉT, DÓZSA GYÖRGY ÚT 3.'],
                ['name' => 'SZENT GYÖRGYI ALBERT EGÉSZSÉGÜGYI KOLLÉGIUM', 'address' => '6000 KECSKEMÉT, NYÍRI ÚT 73.'],
                ['name' => 'SZÉCHÉNYI ISTVÁN VENDÉGLÁTÓ SZAKKÖZÉPISKOLA', 'address' => '6000 KECSKEMÉT, NYÍRI ÚT 32.'],
                ['name' => 'GYERMEKLIGET OVI', 'address' => '6000 KECSKEMÉT, SZARKÁS 74.'],
                ['name' => 'AUTISTA CENTRUM', 'address' => '6000 KECSKEMÉT, NYÍRI ÚT 30.'],
                ['name' => 'TÓTH LÁSZLÓ ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, CZOLNER TÉR 1.'],
            ],

            'BALLÓSZÖG VÁROS ÖNKORMÁNYZAT' => [
                ['name' => 'BALLÓSZÖGI CSILLAGSZEM ÓVODA', 'address' => '6035 BALLÓSZÖG, ZRÍNYI UTCA 2.'],
                ['name' => 'BALLÓSZÖGI KOSSUTH LAJOS ÁLTALÁNOS ISKOLA', 'address' => '6035 BALLÓSZÖG, KOSSUTH UTCA 4.'],
            ],

            'KECSKEMÉTI REFORMÁTUS GIMNÁZIUM' => [
                ['name' => 'KECSKEMÉTI REFORMÁTUS EGYHÁZKÖZSÉG', 'address' => 'KECSKEMÉT, PIARISTÁK TERE 3.'],
            ],

            'PRECÍZ KFT.' => [
                ['name' => 'KERTVÁROSI ÁLTALÁNOS ISKOLA', 'address' => '6000 KECSKEMÉT, MIKSZÁTH KÖRÚT 29.'],
                ['name' => 'KODÁLY ZOLTÁN ÉNEK-ZENEI ISKOLA', 'address' => '6000 KECSKEMÉT, DÓZSA GYÖRGY ÚT 22.'],
                ['name' => 'PRECÍZ KFT. KÖZPONTI KONYHA (KADA ELEK SZAKKÖZÉPISKOLA)', 'address' => '6000 KECSKEMÉT, KATONA JÓZSEF TÉR 8.'],
                ['name' => 'BÁNYAI JÚLIA GIMNÁZIUM', 'address' => '6000 KECSKEMÉT, NYÍRI ÚT 11.'],
                ['name' => 'KÁLMÁN LAJOS GYÓGYPEDAGÓGIAI INTÉZET', 'address' => '6000 KECSKEMÉT, JUHAR UTCA 23.'],
                ['name' => 'HETÉNYI ISKOLA PRECÍZ', 'address' => '6044 HETÉNYEGYHÁZA, ISKOLA UTCA 4.'],
                ['name' => 'TÁNCSICS KOLLÉGIUM', 'address' => '6000 KECSKEMÉT, NYÍRI ÚT 28.'],
            ],

            'HOMOKHÁTSÁG NONPROFIT KFT.' => [
                ['name' => 'HOMOKHÁTSÁG NONPROFIT KFT.', 'address' => '6031 SZENTKIRÁLY, KOSSUTH L. U. 13.'],
            ],

            'RÉV SZENVEDÉLYBETEG-SEGÍTŐ SZOLGÁLAT' => [
                ['name' => 'RÉV', 'address' => '6000 KECSKEMÉT, FECSKE UTCA 20.'],
            ],

            'BAKOS BT.' => [
                ['name' => 'BAKOS ÉS TÁRSAI', 'address' => '6000 KECSKEMÉT, ARADI VÉRTANÚK TERE 9/B.'],
            ],
        ];

        foreach ($data as $companyName => $institutions) {
            $companyId = $companies[$companyName] ?? null;

            foreach ($institutions as $institution) {
                Institution::create([
                                        'company_id' => $companyId,
                                        'name'       => $institution['name'],
                                        'address'    => $institution['address'] ?? null,
                                        'updated_by' => null,
                                    ]);
            }
        }
    }
}
