<?php

namespace Database\Seeders;

use App\Models\TripTrack;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TripTrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['latitude' => 35.1372, 'longitude' => 36.7596],
            ['latitude' => 35.1325, 'longitude' => 36.7511],
            ['latitude' => 35.1329, 'longitude' => 36.7523],
            ['latitude' => 35.1339, 'longitude' => 36.7485],
            ['latitude' => 35.1358, 'longitude' => 36.7557],
        ];

        // إدخال البيانات إلى الجدول
        foreach ($locations as $location) {
            TripTrack::create([
                'trip_id' => 6, // يمكنك تغيير الرقم لربطه برحلة محددة
                'latitude' => $location['latitude'],
                'longitude' => $location['longitude'],
            ]);
        }
    }
}
