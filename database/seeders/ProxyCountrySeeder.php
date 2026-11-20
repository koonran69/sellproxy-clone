<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProxyCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $html = file_get_contents('https://proxyline.net/en/ceny/');

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        libxml_clear_errors();

        $xpath = new \DOMXPath($doc);
        $nodes = $xpath->query('//div[contains(@class, "countries-popup-list")]/div[contains(@class, "item")]');

        $countries = [];

        foreach ($nodes as $node) {
            $spans = $node->getElementsByTagName('span');

            // Lấy image URL từ style
            $style = $spans[0]->getAttribute('style');
            preg_match('/url\((.*?)\)/', $style, $match);
            $imageUrl = $match[1] ?? '';

            preg_match('#flags/([a-z]{2})/#i', $imageUrl, $match);
            $code = strtoupper($match[1] ?? '');

            // Lấy tên quốc gia từ span thứ 2
            $name = $spans[1]->nodeValue;

            $countries[] = [
                'name' => trim($name),
                'code' => $code,
                'image' => trim($imageUrl),
            ];
        }

        $now = Carbon::now();
        $saveTo = public_path('flags');

        if (!file_exists($saveTo)) {
            mkdir($saveTo, 0755, true);
        }

        // foreach ($countries as $item) {
        //     $code = strtolower($item['code']);
        //     $filename = $code . '.png';
        //     $flagPath = 'flags/' . $filename;

        //     // Tải ảnh
        //     try {
        //         $image = Http::timeout(10)->get($item['image']);
        //         if ($image->successful()) {
        //             file_put_contents($saveTo . '/' . $filename, $image->body());

        //             DB::table('proxy_countries')->updateOrInsert(
        //                 ['code' => $item['code']],
        //                 [
        //                     'name' => $item['name'],
        //                     'feature_image' => $flagPath,
        //                     'updated_at' => $now,
        //                     'created_at' => $now
        //                 ]);
        //         } else {
        //             echo "❌ Failed to download: {$item['image']}\n";
        //             DB::table('proxy_countries')->updateOrInsert(
        //                 ['code' => $item['code']],
        //                 [
        //                     'name' => $item['name'],
        //                     'feature_image' => '',
        //                     'updated_at' => $now,
        //                     'created_at' => $now
        //                 ]);
        //         }
        //     } catch (\Exception $e) {
        //         echo "❌ Exception for {$item['code']}: {$e->getMessage()}\n";
        //     }
        // }
    }
}
