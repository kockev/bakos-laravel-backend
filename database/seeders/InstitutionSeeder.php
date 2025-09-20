<?php

namespace Database\Seeders;

use App\Models\Institution;
use Illuminate\Database\Seeder;

class InstitutionSeeder extends Seeder
{
    public function run(): void
    {
        $institutions = [
            ['name' => 'MÁTYÁS KIRÁLY ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Mátyás király körút 46.'],
            ['name' => 'PIÁR ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Czollner tér 3-5.'],
            ['name' => 'PIÁR FIÚKOLLÉGIUM', 'address' => '6000 Kecskemét, Piaristák tere'],
            ['name' => 'WALDORF ISKOLA', 'address' => '6000 Kecskemét, Mészöly Gyula tér 1-3.'],
            ['name' => 'SZENT IMRE ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Szent Imre utca 9.'],
            ['name' => 'PETŐFI SÁNDOR ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Mészöly Gyula tér 1-3.'],
            ['name' => 'MÓRA FERENC ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Forradalom utca 1.'],
            ['name' => 'NYÍRI ÚTI EGYMI (Autista Óvoda)', 'address' => '6000 Kecskemét, Nyíri út 30.'],
            ['name' => 'PIÁR ÓVODA', 'address' => '6000 Kecskemét, Czollner tér 3-5.'],
            ['name' => 'SZENT IMRE ÓVODA', 'address' => '6000 Kecskemét, Szent Imre utca 9.'],
            ['name' => 'TELEKI ÓVODA', 'address' => '6000 Kecskemét, Teleki László utca 1.'],
            ['name' => 'SZIVÁRVÁNY ÓVODA', 'address' => '6000 Kecskemét, Mátis Kálmán utca 8.'],
            ['name' => 'BOCSKAI UTCAI ÓVODA', 'address' => '6000 Kecskemét, Bocskai utca 19.'],
            ['name' => 'KASZAP UTCAI ÓVODA', 'address' => '6000 Kecskemét, Kaszap utca 6-14.'],
            ['name' => 'Noé Bárkája Óvoda', 'address' => '6000 Kecskemét, Kiskőrösi út 8.'],
            ['name' => 'GRÓF KÁROLYI SÁNDOR SZAKKÖZÉPISKOLA', 'address' => '6000 Kecskemét, Bibó Istávn utca 1.'],
            ['name' => 'KATONA JÓZSEF GIMNÁZIUM', 'address' => '6000 Kecskemét, Dózsa György út 3.'],
            ['name' => 'KANDÓ KÁLMÁN SZAKISKOLA', 'address' => '6000 Kecskemét, Bethlen körút 63.'],
            ['name' => 'SZÉCHÉNYI ISTVÁN VENDÉGLÁTÓ SZAKKÖZÉPISKOLA', 'address' => '6000 Kecskemét, Nyíri út 32.'],
            ['name' => 'SZENT GYÖRGYI ALBERT EGÉSZSÉGÜGYI KOLLÉGIUM', 'address' => '6000 Kecskemét, Nyíri út 73.'],
            ['name' => 'SPECIÁLIS SZAKISKOLA', 'address' => '6000 Kecskemét, Erzsébet körút 73.'],
            ['name' => 'MAGYAR ILONA ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Hoffman János utca 8.'],
            ['name' => 'BÉKE ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Boldogasszony tér 7.'],
            ['name' => 'KINDER ÓVODA', 'address' => '6000 Kecskemét, Duna utca 21.'],
            ['name' => 'ZRÍNYI ILONA ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Katona József tér 14.'],
            ['name' => 'VÁSÁRHELYI PÁL ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Alkony utca 12.'],
            ['name' => 'LÁNCHÍD UTCAI ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Lánchíd utca 18.'],
            ['name' => 'ARANY JÁNOS ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Lunkányi János utca 10.'],
            ['name' => 'Kincskereső Óvoda és Bölcsöde Nyárlőrinc', 'address' => '6032 Nyárlőrinc, Dózsa Gy. u. 11.'],
            ['name' => 'KERTVÁROSI ÁLTALÁNOS ISKOLA', 'address' => '6000 Kecskemét, Mikszáth körút 29.'],
            ['name' => 'NYÍRI ÚTI EGYMI - Szalag utca', 'address' => null],
            ['name' => 'KODÁLY ZOLTÁN ÉNEK ZENEI ISKOLA', 'address' => '6000 Kecskemét, Dózsa György út 22.'],
            ['name' => 'PRECÍZ KFT. KÖZPONTI KONYHA (KADA ELEK SZAKKÖZÉPISKOLA)', 'address' => '6000 Kecskemét, Katona József tér 8.'],
            ['name' => 'BÁNYAI JÚLIA GIMNÁZIUM', 'address' => '6000 Kecskemét, Nyíri út 11.'],
            ['name' => 'KÁLMÁN LAJOS GYÓGYPEDAGÓGIAI INTÉZET', 'address' => '6000 Kecskemét, Juhar utca 23.'],
            ['name' => 'WÉBER EDE KÖZPONTI ÁLTALÁNOS ISKOLA', 'address' => '6034, Helvécia, Kiskőrösi út 71.'],
            ['name' => 'NAPVIRÁG ÓVODA', 'address' => '6034, Helvécia, Sport utca 29.'],
            ['name' => 'KEREKERDŐ TAGÓVODA', 'address' => '6034, Helvécia, Óvoda utca 1.'],
            ['name' => 'Hetényi iskola', 'address' => null],
            ['name' => 'Katonatelepi iskola', 'address' => null],
            ['name' => 'Hunyadi J. ált. isk', 'address' => null],
            ['name' => 'Kadafalvi általános iskola', 'address' => null],
            ['name' => 'Hetényi iskola Precíz', 'address' => null],
            ['name' => 'NYÍRI ÚTI EGYMI - Nyíri út', 'address' => '6000 Kecskemét, Nyíri út 30.'],
            ['name' => 'Táncsics kollégium', 'address' => null],
            ['name' => 'Feketeerdő Ált. Iskola', 'address' => 'Ballószög'],
            ['name' => 'Gáspár A. Szakközépiskola', 'address' => 'Kecskemét'],
            ['name' => 'Pitypang Bölcsöde', 'address' => null],
            ['name' => 'Kecskeméti Református Egyházközség', 'address' => 'Kecskemét Piaristák tere 3.'],
            ['name' => 'Ménteleki iskola', 'address' => null],
            ['name' => 'Homokhátság Nonprofit Kft.', 'address' => '6031 Szentkirály Kossuth L. u. 13.'],
            ['name' => 'Evangélikus óvoda', 'address' => null],
            ['name' => 'Móra+Logi', 'address' => '6000 Kecskemét, Forradalom utca 1.'],
            ['name' => 'Gyermekliget Ovi', 'address' => null],
            ['name' => 'Kunpeszér ovi', 'address' => 'Kunszentmiklós'],
            ['name' => 'Kunpeszéri Iskola', 'address' => null],
            ['name' => 'Tóth László Ált. isk', 'address' => null],
            ['name' => 'Gyermekliget Iskola', 'address' => null],
            ['name' => 'Tóth Erzsébet Óvoda', 'address' => 'Szabadszállás'],
            ['name' => 'Bárányka Keresztény Óvoda', 'address' => 'Kecskemét,Szentgyörgyi Albert utca 24.'],
            ['name' => 'Szabadszállási általános iskola', 'address' => null],
            ['name' => 'Fazekas I.Szki/ Speciális', 'address' => null],
            ['name' => 'Csillagbölcső Waldorf Óvoda', 'address' => null],
            ['name' => 'Fülöpszállás Iskola', 'address' => null],
            ['name' => 'Fülöpszállás Óvoda', 'address' => null],
            ['name' => 'Szabadszállás iskola', 'address' => null],
            ['name' => 'Strázsa tanya', 'address' => null],
            ['name' => 'Ballószögi Csillagszem Óvoda', 'address' => null],
            ['name' => 'Helvécia-Ballószög Általános Iskola', 'address' => null],
            ['name' => 'Szalkszentmártoni Óvoda', 'address' => null],
            ['name' => 'RÉV', 'address' => null],
            ['name' => 'Bambínó-Ház Óvoda', 'address' => null],
            ['name' => 'Izsáki Óvoda', 'address' => null],
            ['name' => 'Izsáki Iskola', 'address' => null],
            ['name' => 'Szalkszentmártoni iskola', 'address' => null],
        ];

        foreach ($institutions as $institution) {
            Institution::create([
                                    'company_id' => null,
                                    'name'       => $institution['name'],
                                    'address'    => $institution['address'],
                                    'updated_by' => null,
                                ]);
        }
    }
}
