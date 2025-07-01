<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Scope;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Activity::factory(10)->create();
        // Activity::create(
        //     [
        //         'date' => date('Y-m-d'),
        //         'title' => fake('id_ID')->sentence(3),
        //         'slug' => fake('id_ID')->slug(),
        //         'group_id' => 1,
        //         'position_id' => 1,
        //         'total_estimate' => 3,
        //         'type_estimate' => 'day',
        //         'forecast_date' =>  Carbon::now()->addDays(2),
        //         'plan_date' => Carbon::now()->addDays(3),
        //         'actual_date' => Carbon::now()->addDays(5),
        //         'supervisor_id' => 3,
        //         'description' => fake('id_ID')->text(100),
        //         'status_id' => 1
        //     ]
        // );


        DB::statement("insert  into `activities`(`id`,`scope_id`,`group_id`,`position_id`,`total_estimate`,`forecast_date`,`plan_date`,`actual_date`,`supervisor_id`,`description`,`progress`,`status_id`,`created_at`,`updated_at`) values
            (1,1,1,2,12,'2025-01-19','2025-01-10',NULL,7,NULL,0,3,'2025-01-22 21:49:24','2025-01-22 21:49:24'),
            (3,1,2,2,8,'2025-01-22','2025-01-14',NULL,8,NULL,0,3,'2025-01-22 21:52:12','2025-01-22 21:52:12'),
            (4,1,3,2,45,'2025-01-15','2025-01-01',NULL,9,NULL,0,3,'2025-01-22 21:55:13','2025-01-22 21:55:13'),
            (5,1,4,2,5,'2025-01-15','2025-01-10',NULL,10,NULL,0,3,'2025-01-22 21:56:54','2025-01-22 21:56:54'),
            (6,1,5,2,60,'2025-01-22','2025-01-01',NULL,11,NULL,0,3,'2025-01-22 21:58:23','2025-01-22 21:58:23'),
            (7,1,6,2,5,'2025-01-19','2025-01-14',NULL,12,NULL,0,3,'2025-01-22 22:00:52','2025-01-22 22:00:52'),
            (8,1,7,2,5,'2025-01-19','2025-01-14',NULL,12,NULL,0,3,'2025-01-22 22:02:14','2025-01-22 22:02:14'),
            (9,3,7,2,14,'2025-01-16','2025-01-02',NULL,9,NULL,0,3,'2025-01-22 22:05:57','2025-01-22 22:05:57'),
            (10,1,8,2,5,'2025-01-22','2025-01-17',NULL,12,NULL,0,3,'2025-01-22 22:07:19','2025-01-22 22:07:19'),
            (11,1,9,2,5,'2025-01-22','2025-01-17',NULL,14,NULL,0,3,'2025-01-22 22:08:07','2025-01-22 22:08:07');
        ");
    }
}
