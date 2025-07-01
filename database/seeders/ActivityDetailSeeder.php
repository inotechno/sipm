<?php

namespace Database\Seeders;

use App\Models\ActivityDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement("insert  into `activity_details`(`id`,`activity_id`,`scope_id`,`progress`,`created_at`,`updated_at`) values
            (1,1,1,0,'2025-01-22 21:49:24','2025-01-22 21:49:24'),
            (3,3,1,0,'2025-01-22 21:52:12','2025-01-22 21:52:12'),
            (4,4,1,0,'2025-01-22 21:55:13','2025-01-22 21:55:13'),
            (5,5,1,0,'2025-01-22 21:56:54','2025-01-22 21:56:54'),
            (6,6,1,0,'2025-01-22 21:58:23','2025-01-22 21:58:23'),
            (7,7,1,0,'2025-01-22 22:00:52','2025-01-22 22:00:52'),
            (8,8,1,0,'2025-01-22 22:02:14','2025-01-22 22:02:14'),
            (9,9,3,0,'2025-01-22 22:05:58','2025-01-22 22:05:58'),
            (10,10,1,0,'2025-01-22 22:07:19','2025-01-22 22:07:19'),
            (11,11,1,0,'2025-01-22 22:08:07','2025-01-22 22:08:07');
        ");
    }
}
