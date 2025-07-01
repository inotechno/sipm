<?php

namespace App\Console\Commands;

use App\Jobs\SendWhatsappJob;
use App\Models\ActivityIssue;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckUnresolvedIssues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:checkunresolved';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for unresolved issues to Project Manager and Project Director';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        try {
            // Notifikasi ke Site Manager setiap 10 menit selama 30 menit (total 3 kali)
            $issuesForSM = ActivityIssue::whereNull('resolved_at')
                ->where('created_at', '<=', $now) // Issue sudah dibuat
                ->where('notified_site_manager_count', '<', 3) // Batasi notifikasi ke 3 kali
                ->where(function ($query) use ($now) {
                    $query->whereNull('last_notified_site_manager_at') // Belum pernah dikirim
                        ->orWhere('last_notified_site_manager_at', '<=', $now->subMinutes(10)); // Terakhir dikirim lebih dari 10 menit yang lalu
                })
                ->get();

            // $issuesForSM = ActivityIssue::whereNull('resolved_at')
            //     ->where('created_at', '<=', $now) // Issue sudah dibuat
            //     ->where('notified_site_manager_count', '<', 3) // Batasi notifikasi ke 3 kali
            //     ->where(function ($query) use ($now) {
            //         $query->whereNull('last_notified_site_manager_at') // Belum pernah dikirim
            //             ->orWhere('last_notified_site_manager_at', '<=', $now->subMinutes(1)); // Terakhir dikirim lebih dari 10 menit yang lalu
            //     })
            //     ->get();

            foreach ($issuesForSM as $issue) {
                $activity = $issue->activity;
                $supervisorName = $activity->supervisor ? $activity->supervisor->name : 'Unknown Supervisor';
                $url = urldecode(route('activity.issues', ['activity_id' => $activity->id], true));

                $title = "🔔 *Reminder: Issue Pending!*";
                $message = $title . "\n\n"
                    . "*Scope:* {$activity->scope->name}\n"
                    . "*Area:* {$activity->area->name}\n"
                    . "*Posisi:* {$activity->position->name}\n"
                    . "*Planned Date:* {$activity->plan_date}\n"
                    . "*Supervisor:* {$supervisorName}\n\n"

                    . "*Date:* {$issue->date}\n"
                    . "*Category Dependency:* {$issue->categoryDependency->name}\n"
                    . "*Percentage Dependency:* {$issue->percentage_dependency}%\n\n"
                    . "*Description:* {$issue->description}\n\n"

                    . "Please resolve this issue as soon as possible, click {$url} for more details.";

                // $siteManagers = User::where('id', 1)->get();
                $siteManagers = User::role('Site Manager')->get();
                foreach ($siteManagers as $sm) {
                    \Log::info('Message sent to Site Manager: ' . $sm->name);
                    SendWhatsappJob::dispatch($sm->phone, $message);
                }

                // Update waktu notifikasi terakhir dan jumlah notifikasi ke Site Manager
                $issue->update([
                    'last_notified_site_manager_at' => $now,
                    'notified_site_manager_count' => $issue->notified_site_manager_count + 1,
                ]);
            }

            // Notifikasi ke Project Manager setiap 1 jam selama 3 jam (total 3 kali), dimulai setelah 30 menit sejak issue dibuat
            $issuesForPM = ActivityIssue::whereNull('resolved_at')
                ->where('created_at', '<=', $now->subMinutes(30)) // Issue sudah lebih dari 30 menit
                ->where('notified_project_manager_count', '<', 3) // Batasi notifikasi ke 3 kali
                ->where(function ($query) use ($now) {
                    $query->whereNull('last_notified_project_manager_at') // Belum pernah dikirim ke Project Manager
                        ->orWhere('last_notified_project_manager_at', '<=', $now->subHours(1)); // Terakhir dikirim lebih dari 1 jam yang lalu
                })
                ->get();

            // $issuesForPM = ActivityIssue::whereNull('resolved_at')
            //     ->where('created_at', '<=', $now->subMinutes(3)) // Issue sudah lebih dari 30 menit
            //     ->where('notified_project_manager_count', '<', 3) // Batasi notifikasi ke 3 kali
            //     ->where(function ($query) use ($now) {
            //         $query->whereNull('last_notified_project_manager_at') // Belum pernah dikirim ke Project Manager
            //             ->orWhere('last_notified_project_manager_at', '<=', $now->subMinutes(1)); // Terakhir dikirim lebih dari 1 jam yang lalu
            //     })
            //     ->get();

            foreach ($issuesForPM as $issue) {
                $activity = $issue->activity;
                $supervisorName = $activity->supervisor ? $activity->supervisor->name : 'Unknown Supervisor';
                $url = urldecode(route('activity.issues', ['activity_id' => $activity->id], true));

                $title = "🔔 *Reminder: Issue Pending for Over 30 Minutes!*";
                $message = $title . "\n\n"
                    . "*Scope:* {$activity->scope->name}\n"
                    . "*Area:* {$activity->area->name}\n"
                    . "*Posisi:* {$activity->position->name}\n"
                    . "*Planned Date:* {$activity->plan_date}\n"
                    . "*Supervisor:* {$supervisorName}\n\n"

                    . "*Date:* {$issue->date}\n"
                    . "*Category Dependency:* {$issue->categoryDependency->name}\n"
                    . "*Percentage Dependency:* {$issue->percentage_dependency}%\n\n"
                    . "*Description:* {$issue->description}\n\n"
                    . "Please follow up with the Site Manager and update solution as soon as possible, click {$url} for more details.";

                // $projectManagers = User::where('id', 1)->get();
                $projectManagers = User::role('Project Manager')->get();
                foreach ($projectManagers as $pm) {
                    \Log::info('Message sent to Project Manager: ' . $pm->name);
                    SendWhatsappJob::dispatch($pm->phone, $message);
                }

                // Update waktu notifikasi terakhir dan jumlah notifikasi ke Project Manager
                $issue->update([
                    'last_notified_project_manager_at' => $now,
                    'notified_project_manager_count' => $issue->notified_project_manager_count + 1,
                ]);
            }

            // Notifikasi ke Project Director setiap 1 jam selama 3 jam (total 3 kali), dimulai setelah 3 jam sejak issue dibuat
            $issuesForPD = ActivityIssue::whereNull('resolved_at')
                ->where('created_at', '<=', $now->subHours(3)) // Issue sudah lebih dari 3 jam
                ->where('notified_project_director_count', '<', 3) // Batasi notifikasi ke 3 kali
                ->where(function ($query) use ($now) {
                    $query->whereNull('last_notified_project_director_at') // Belum pernah dikirim ke Project Director
                        ->orWhere('last_notified_project_director_at', '<=', $now->subHours(1)); // Terakhir dikirim lebih dari 1 jam yang lalu
                })
                ->get();

            // $issuesForPD = ActivityIssue::whereNull('resolved_at')
            //     ->where('created_at', '<=', $now->subMinutes(10)) // Issue sudah lebih dari 3 jam
            //     ->where('notified_project_director_count', '<', 3) // Batasi notifikasi ke 3 kali
            //     ->where(function ($query) use ($now) {
            //         $query->whereNull('last_notified_project_director_at') // Belum pernah dikirim ke Project Director
            //             ->orWhere('last_notified_project_director_at', '<=', $now->subMinutes(1)); // Terakhir dikirim lebih dari 1 jam yang lalu
            //     })
            //     ->get();

            foreach ($issuesForPD as $issue) {
                $activity = $issue->activity;
                $supervisorName = $activity->supervisor ? $activity->supervisor->name : 'Unknown Supervisor';
                $url = urldecode(route('activity.issues', ['activity_id' => $activity->id], true));

                $title = "🚨 *Urgent: Issue Pending for Over 3 Hours!*";
                $message = $title . "\n\n"
                    . "*Scope:* {$activity->scope->name}\n"
                    . "*Area:* {$activity->area->name}\n"
                    . "*Posisi:* {$activity->position->name}\n"
                    . "*Planned Date:* {$activity->plan_date}\n"
                    . "*Supervisor:* {$supervisorName}\n\n"

                    . "*Date:* {$issue->date}\n"
                    . "*Category Dependency:* {$issue->categoryDependency->name}\n"
                    . "*Percentage Dependency:* {$issue->percentage_dependency}%\n\n"
                    . "*Description:* {$issue->description}\n\n"
                    . "Immediate action is required!, click {$url} for more details.";

                // $projectDirectors = User::where('id', 1)->get();
                $projectDirectors = User::role('Project Director')->get();
                foreach ($projectDirectors as $pd) {
                    \Log::info('Message sent to Project Director: ' . $pd->name);
                    SendWhatsappJob::dispatch($pd->phone, $message);
                }

                // Update waktu notifikasi terakhir dan jumlah notifikasi ke Project Director
                $issue->update([
                    'last_notified_project_director_at' => $now,
                    'notified_project_director_count' => $issue->notified_project_director_count + 1,
                ]);
            }

            \Log::info('Unresolved issues checked successfully.');
        } catch (\Exception $e) {
            \Log::error('Error checking unresolved issues: ' . $e->getMessage());
        }
    }
}
