<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProxyCountrySeederNew extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('proxy_countries')->truncate();

        $countries = [
            [
                'id' => 1, 
                'name' => 'Argentina', 
                'code' => 'AR', 
                'feature_image' => 'public/flags/ar.png',
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 2, 
                'name' => 'Austria', 
                'code' => 'AT', 
                'feature_image' => 'public/flags/at.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 3, 
                'name' => 'Czech Republic', 
                'code' => 'CZ', 
                'feature_image' => 'public/flags/cz.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 4, 
                'name' => 'Georgia', 
                'code' => 'GE', 
                'feature_image' => 'public/flags/ge.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 5, 
                'name' => 'Germany', 
                'code' => 'DE', 
                'feature_image' => 'public/flags/de.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 6, 
                'name' => 'Hungary', 
                'code' => 'HU', 
                'feature_image' => 'public/flags/hu.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 7, 
                'name' => 'Israel', 
                'code' => 'IL', 
                'feature_image' => 'public/flags/il.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 8, 
                'name' => 'Italy', 
                'code' => 'IT', 
                'feature_image' => 'public/flags/it.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 9, 
                'name' => 'Japan', 
                'code' => 'JP', 
                'feature_image' => 'public/flags/jp.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 10, 
                'name' => 'Malaysia', 
                'code' => 'MY', 
                'feature_image' => 'public/flags/my.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 11, 
                'name' => 'Moldova', 
                'code' => 'MD', 
                'feature_image' => 'public/flags/md.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 12, 
                'name' => 'Monaco', 
                'code' => 'MC', 
                'feature_image' => 'public/flags/mc.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 13, 
                'name' => 'Netherland', 
                'code' => 'NL', 
                'feature_image' => 'public/flags/nl.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 14, 
                'name' => 'Philippines', 
                'code' => 'PH', 
                'feature_image' => 'public/flags/ph.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 15, 
                'name' => 'Russia', 
                'code' => 'RU', 
                'feature_image' => 'public/flags/ru.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 16, 
                'name' => 'Slovakia', 
                'code' => 'SK', 
                'feature_image' => 'public/flags/sk.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 17, 
                'name' => 'Spain', 
                'code' => 'ES', 
                'feature_image' => 'public/flags/es.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 18, 
                'name' => 'Sweden', 
                'code' => 'SE', 
                'feature_image' => 'public/flags/se.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 19, 
                'name' => 'Switzerland', 
                'code' => 'CH', 
                'feature_image' => 'public/flags/ch.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 20, 
                'name' => 'Turkey', 
                'code' => 'TR', 
                'feature_image' => 'public/flags/tr.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 21, 
                'name' => 'USA', 
                'code' => 'US', 
                'feature_image' => 'public/flags/us.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 22, 
                'name' => 'Albania', 
                'code' => 'AL', 
                'feature_image' => 'public/flags/al.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 23, 
                'name' => 'Algeria', 
                'code' => 'DZ', 
                'feature_image' => 'public/flags/dz.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 24, 
                'name' => 'Armenia', 
                'code' => 'AM', 
                'feature_image' => 'public/flags/am.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 25, 
                'name' => 'Australia', 
                'code' => 'AU', 
                'feature_image' => 'public/flags/au.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 26, 
                'name' => 'Azerbaijan', 
                'code' => 'AZ', 
                'feature_image' => 'public/flags/az.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 27, 
                'name' => 'Bangladesh', 
                'code' => 'BD', 
                'feature_image' => 'public/flags/bd.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 28, 
                'name' => 'Belarus', 
                'code' => 'BY', 
                'feature_image' => 'public/flags/by.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 29, 
                'name' => 'Belgium', 
                'code' => 'BE', 
                'feature_image' => 'public/flags/be.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 30, 
                'name' => 'Bolivia', 
                'code' => 'BO', 
                'feature_image' => 'public/flags/bo.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 31, 
                'name' => 'Bosnia and Herzegovina', 
                'code' => 'BA', 
                'feature_image' => 'public/flags/ba.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 32, 
                'name' => 'Brazil', 
                'code' => 'BR', 
                'feature_image' => 'public/flags/br.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 33, 
                'name' => 'Bulgaria', 
                'code' => 'BG', 
                'feature_image' => 'public/flags/bg.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 34, 
                'name' => 'Cambodia', 
                'code' => 'KH', 
                'feature_image' => 'public/flags/kh.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 35, 
                'name' => 'Cameroon', 
                'code' => 'CM', 
                'feature_image' => 'public/flags/cm.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 36, 
                'name' => 'Canada', 
                'code' => 'CA', 
                'feature_image' => 'public/flags/ca.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 37, 
                'name' => 'Chile', 
                'code' => 'CL', 
                'feature_image' => 'public/flags/cl.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 38, 
                'name' => 'China', 
                'code' => 'CN', 
                'feature_image' => 'public/flags/cn.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 39, 
                'name' => 'Colombia', 
                'code' => 'CO', 
                'feature_image' => 'public/flags/co.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 40, 
                'name' => 'Costa Rica', 
                'code' => 'CR', 
                'feature_image' => 'public/flags/cr.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 41, 
                'name' => 'Croatia', 
                'code' => 'HR', 
                'feature_image' => 'public/flags/hr.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 42, 
                'name' => 'Cyprus', 
                'code' => 'CY', 
                'feature_image' => 'public/flags/cy.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 43, 
                'name' => 'Denmark', 
                'code' => 'DK', 
                'feature_image' => 'public/flags/dk.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 44, 
                'name' => 'Egypt', 
                'code' => 'EG', 
                'feature_image' => 'public/flags/eg.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 45, 
                'name' => 'Estonia', 
                'code' => 'EE', 
                'feature_image' => 'public/flags/ee.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 46, 
                'name' => 'Finland', 
                'code' => 'FI', 
                'feature_image' => 'public/flags/fi.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 47, 
                'name' => 'France', 
                'code' => 'FR', 
                'feature_image' => 'public/flags/fr.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 48, 
                'name' => 'Greece', 
                'code' => 'GR', 
                'feature_image' => 'public/flags/gr.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 49, 
                'name' => 'Hong Kong', 
                'code' => 'HK', 
                'feature_image' => 'public/flags/hk.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 50, 
                'name' => 'Iceland', 
                'code' => 'IS', 
                'feature_image' => 'public/flags/is.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 51, 
                'name' => 'India', 
                'code' => 'IN', 
                'feature_image' => 'public/flags/in.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 52, 
                'name' => 'Indonesia', 
                'code' => 'ID', 
                'feature_image' => 'public/flags/id.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 53, 
                'name' => 'Iran', 
                'code' => 'IR', 
                'feature_image' => 'public/flags/ir.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 54, 
                'name' => 'Iraq', 
                'code' => 'IQ', 
                'feature_image' => 'public/flags/iq.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 55, 
                'name' => 'Ireland', 
                'code' => 'IE', 
                'feature_image' => 'public/flags/ie.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 56, 
                'name' => 'Jamaica', 
                'code' => 'JM', 
                'feature_image' => 'public/flags/jm.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 57, 
                'name' => 'Jordan', 
                'code' => 'JO', 
                'feature_image' => 'public/flags/jo.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 58, 
                'name' => 'Kazakhstan', 
                'code' => 'KZ', 
                'feature_image' => 'public/flags/kz.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 59, 
                'name' => 'Kenya', 
                'code' => 'KE', 
                'feature_image' => 'public/flags/ke.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 60, 
                'name' => 'Korea', 
                'code' => 'KR', 
                'feature_image' => 'public/flags/kr.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 61, 
                'name' => 'Kyrgyzstan', 
                'code' => 'KG', 
                'feature_image' => 'public/flags/kg.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 62, 
                'name' => 'Latvia', 
                'code' => 'LV', 
                'feature_image' => 'public/flags/lv.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 63, 
                'name' => 'Lithuania', 
                'code' => 'LT', 
                'feature_image' => 'public/flags/lt.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 64, 
                'name' => 'Luxembourg', 
                'code' => 'LU', 
                'feature_image' => 'public/flags/lu.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 65, 
                'name' => 'Maldives', 
                'code' => 'MV', 
                'feature_image' => 'public/flags/mv.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 66, 
                'name' => 'Malta', 
                'code' => 'MT', 
                'feature_image' => 'public/flags/mt.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 67, 
                'name' => 'Mexico', 
                'code' => 'MX', 
                'feature_image' => 'public/flags/mx.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 68, 
                'name' => 'Mongolia', 
                'code' => 'MN', 
                'feature_image' => 'public/flags/mn.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 69, 
                'name' => 'Montenegro', 
                'code' => 'ME', 
                'feature_image' => 'public/flags/me.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 70, 
                'name' => 'Morocco', 
                'code' => 'MA', 
                'feature_image' => 'public/flags/ma.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 71, 
                'name' => 'Nepal', 
                'code' => 'NP', 
                'feature_image' => 'public/flags/np.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 72, 
                'name' => 'New Zealand', 
                'code' => 'NZ', 
                'feature_image' => 'public/flags/nz.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 73, 
                'name' => 'Nigeria', 
                'code' => 'NG', 
                'feature_image' => 'public/flags/ng.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 74, 
                'name' => 'Norway', 
                'code' => 'NO', 
                'feature_image' => 'public/flags/no.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 75, 
                'name' => 'Pakistan', 
                'code' => 'PK', 
                'feature_image' => 'public/flags/pk.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 76, 
                'name' => 'Peru', 
                'code' => 'PE', 
                'feature_image' => 'public/flags/pe.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 77, 
                'name' => 'Poland', 
                'code' => 'PL', 
                'feature_image' => 'public/flags/pl.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 78, 
                'name' => 'Portugal', 
                'code' => 'PT', 
                'feature_image' => 'public/flags/pt.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 79, 
                'name' => 'Qatar', 
                'code' => 'QA', 
                'feature_image' => 'public/flags/qa.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 80, 
                'name' => 'Romania', 
                'code' => 'RO', 
                'feature_image' => 'public/flags/ro.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 81, 
                'name' => 'Saudi Arabia', 
                'code' => 'SA', 
                'feature_image' => 'public/flags/sa.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 82, 
                'name' => 'Serbia', 
                'code' => 'RS', 
                'feature_image' => 'public/flags/rs.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 83, 
                'name' => 'Seychelles', 
                'code' => 'SC', 
                'feature_image' => 'public/flags/sc.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 84, 
                'name' => 'Singapore', 
                'code' => 'SG', 
                'feature_image' => 'public/flags/sg.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 85, 
                'name' => 'Slovenia', 
                'code' => 'SI', 
                'feature_image' => 'public/flags/si.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 86, 
                'name' => 'South Africa', 
                'code' => 'ZA', 
                'feature_image' => 'public/flags/za.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 87, 
                'name' => 'Sri Lanka', 
                'code' => 'LK', 
                'feature_image' => 'public/flags/lk.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 88, 
                'name' => 'Taiwan', 
                'code' => 'TW', 
                'feature_image' => 'public/flags/tw.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 89, 
                'name' => 'Tajikistan', 
                'code' => 'TJ', 
                'feature_image' => 'public/flags/tj.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 90, 
                'name' => 'Tanzania', 
                'code' => 'TZ', 
                'feature_image' => 'public/flags/tz.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 91, 
                'name' => 'Thailand', 
                'code' => 'TH', 
                'feature_image' => 'public/flags/th.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 92, 
                'name' => 'Tunisia', 
                'code' => 'TN', 
                'feature_image' => 'public/flags/tn.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 93, 
                'name' => 'Turkmenistan', 
                'code' => 'TM', 
                'feature_image' => 'public/flags/tm.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 94, 
                'name' => 'Ukraine', 
                'code' => 'UA', 
                'feature_image' => 'public/flags/ua.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 95, 
                'name' => 'United Arab Emirates', 
                'code' => 'AE', 
                'feature_image' => 'public/flags/ae.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 96, 
                'name' => 'United Kingdom', 
                'code' => 'GB', 
                'feature_image' => 'public/flags/gb.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 97, 
                'name' => 'Uruguay', 
                'code' => 'UY', 
                'feature_image' => 'public/flags/uy.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 98, 
                'name' => 'Uzbekistan', 
                'code' => 'UZ', 
                'feature_image' => 'public/flags/uz.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 99, 
                'name' => 'Venezuela', 
                'code' => 'VE', 
                'feature_image' => 'public/flags/ve.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
            [
                'id' => 100, 
                'name' => 'Vietnam', 
                'code' => 'VN', 
                'feature_image' => 'public/flags/vn.png', 
                'created_at' => '2025-07-14 04:21:33', 
                'updated_at' => '2025-07-14 04:21:33'
            ],
        ];

        DB::table('proxy_countries')->insert($countries);
    }
}
