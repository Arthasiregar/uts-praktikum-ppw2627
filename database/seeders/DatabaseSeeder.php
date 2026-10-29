<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $srv = Category::create(['name' => 'Server & Cloud', 'code' => 'SRV']);
        $iot = Category::create(['name' => 'Internet of Things', 'code' => 'IOT']);
        $drn = Category::create(['name' => 'Multimedia & Drone', 'code' => 'DRN']);

        $items = [
            [$srv, 'EQ-SRV-001', 'Server Mini Intel NUC', 'Intel Core i7, RAM 32GB, SSD 1TB', 'baik', 'tersedia', 75000],
            [$srv, 'EQ-SRV-002', 'Laptop Pengujian Performa', 'Ryzen 9, RAM 64GB, RTX 4070, SSD 2TB', 'baik', 'dipinjam', 100000],
            [$iot, 'EQ-IOT-001', 'Kit Sensor IoT ESP32', 'ESP32, sensor suhu, kelembapan, gerak, relay', 'baik', 'tersedia', 25000],
            [$iot, 'EQ-IOT-002', 'Kit Raspberry Pi 5', 'Raspberry Pi 5 8GB, casing, adaptor, microSD', 'rusak_ringan', 'tersedia', 40000],
            [$drn, 'EQ-DRN-001', 'Drone Observasi DJI Mavic', 'Kamera 4K, flight time 30 menit, 2 baterai', 'baik', 'dalam_perbaikan', 150000],
            [$drn, 'EQ-DRN-002', 'Tablet Digital Wacom', 'Layar 13 inci, stylus, kabel USB-C', 'rusak_berat', 'dalam_perbaikan', 30000],
            [$iot, 'EQ-IOT-003', 'Kit Robotika Arduino', 'Arduino Mega, motor servo, sensor ultrasonik', 'baik', 'tersedia', 35000],
        ];

        foreach ($items as [$cat, $code, $name, $spec, $cond, $status, $fee]) {
            Equipment::create([
                'category_id' => $cat->id,
                'asset_code' => $code,
                'name' => $name,
                'specification' => $spec,
                'condition' => $cond,
                'status' => $status,
                'daily_rental_fee' => $fee,
                'image_path' => null,
            ]);
        }
    }
}