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
            '35°08\'05.3"N 36°45\'07.9"E', // دوار الشريعة
            '35°08\'17.2"N 36°45\'41.0"E', // حي الكازو
            '35°07\'46.2"N 36°45\'25.2"E', // جسر العاصي
            '35°07\'49.8"N 36°45\'10.8"E', // قلعة حماة
            '35°07\'52.3"N 36°45\'17.3"E', // ساحة العاصي
            '35°08\'12.1"N 36°45\'32.7"E', // شارع العلمين
            '35°07\'58.4"N 36°45\'28.1"E', // حي جنوب الثكنة
            '35°08\'01.5"N 36°45\'19.0"E'  // حي الأربعين
        ];

        // إدخال البيانات إلى الجدول
        foreach ($locations as $location) {
            TripTrack::create([
                'trip_id' => 6, // يمكنك تغيير الرقم لربطه برحلة محددة
                'location' => $location,
            ]);
        }
    }
}
