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
            ['latitude' => 24.7136, 'longitude' => 46.6753],
            ['latitude' => 24.7195, 'longitude' => 46.6864],
            ['latitude' => 24.7265, 'longitude' => 46.6982],
            ['latitude' => 24.7332, 'longitude' => 46.7091],
            ['latitude' => 24.7407, 'longitude' => 46.7203],
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
