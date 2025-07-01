<?php

namespace App\Jobs;

use App\Events\AttendanceUpdated;
use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
class AttendanceJob implements ShouldQueue
{
    use Queueable, SerializesModels, InteractsWithQueue, Dispatchable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = $this->data;

        try {
            $employeeExists = Employee::where('id', $data['employee_id'])->first();

            if (empty($employeeExists)) {
                \Log::info('Employee not found', $data);
                return;
            }

            $isFirstAttendance = Attendance::whereDate('shift_date', date('Y-m-d', strtotime($data['timestamp'])))
                ->where('employee_id', $data['employee_id'])->first();

            if (empty($isFirstAttendance)) {
                if ($data['is_active'] == true) {
                    $activities = Activity::with('employees', 'scope', 'area', 'supervisor')
                        ->where('status_id', 1)
                        ->where('progress', '<', 100)
                        ->whereHas('employees', function ($query) use ($employeeExists) {
                            $query->where('employee_id', $employeeExists->id);
                        })
                        ->get();

                    if ($data['phone'] != null && $activities->count() > 0) {

                        foreach ($activities as $activity) {
                            $activeActivity = $activity;
                            $message = "*Notifikasi Aktivitas Hari Ini*\n\n" .
                                "Halo *{$data['name']}*,\n\n" .
                                "📋 *Detail Aktivitas*\n" .
                                "------------------------\n" .

                                "🔹 *Judul Aktivitas:* {$activity->scope->name}\n" .
                                "📅 *Forecast Date:* " . date('d M Y', strtotime($activity->forecast_date)) . "\n" .
                                "📆 *Plan Date:* " . date('d M Y', strtotime($activity->plan_date)) . "\n" .
                                "📊 *Progress:* {$activity->progress}%" . $this->getProgressIcon($activity->progress) . "\n" .
                                "👥 *Supervisor:* {$activity->supervisor->name}\n" .
                                "📍 *Area:* {$activity->area->name}\n" .
                                "📝 *Deskripsi:* {$activity->description}\n\n" .

                                "_Terima kasih_";

                            $this->sendWhatsAppNotification($data['phone'], $message);
                            \Log::info(date('Y-m-d H:i:s') . ' ' . 'Sent Whatsapp ' . $data['phone'] . ' Successfully');
                        }

                        $message = "Anda tercatat hadir pada waktu {$data['timestamp']} pada mesin {$data['sn']}.";
                        $this->sendWhatsAppNotification($data['phone'], $message);
                        \Log::info(date('Y-m-d H:i:s') . ' ' . 'Attendance Sync Job Completed With Send Activity Successfully');
                    }
                }
            }

            $attendance = Attendance::updateOrCreate(
                ['uid' => $data['uid']],
                [
                    'employee_id' => $data['employee_id'],
                    'state' => $data['state'],
                    'timestamp' => $data['timestamp'],
                    'machine_sn' => $data['sn'],
                    'shift_id' => $data['shift_id'],
                    'shift_date' => $data['shift_date'],
                ]
            );

            \Log::info(date('Y-m-d H:i:s') . ' ' . 'Attendance Sync Job Completed Successfully');
        } catch (\Throwable $th) {
            \Log::error(date('Y-m-d H:i:s') . ' ' . $th->getMessage());
        }
    }

    // Helper method to get progress icon
    private function getProgressIcon($progress)
    {
        if ($progress < 25)
            return '🔴';
        if ($progress < 50)
            return '🟠';
        if ($progress < 75)
            return '🟡';
        return '🟢';
    }

    /**
     * Mengirim notifikasi WhatsApp
     */
    private function sendWhatsAppNotification($phoneNumber, $message)
    {
        try {
            $no_hp = $phoneNumber; // No.HP yang dikirim (No.HP Penerima)

            // Memastikan nomor telepon menggunakan awalan 62
            if (substr($no_hp, 0, 1) == '0') {
                $no_hp = '62' . substr($no_hp, 1); // Mengganti 0 dengan 62
            }

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://app.wapanels.com/api/create-message',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'appkey' => '27e7f841-13e9-40e3-91c4-54ed22300573',
                    'authkey' => 'I1Dkd1vkWwXpatbjJKukv3AwBXJAq8on1ZRC0Rdl1Xn1HO8ky2',
                    'to' => $no_hp,
                    'message' => $message,
                    'sandbox' => 'false'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            \Log::info('WhatsApp Notification Sent', ['response' => $response]);
            return $response;
        } catch (\Throwable $th) {
            \Log::error(date('Y-m-d H:i:s') . ' ' . $th->getMessage());
        }
    }
}
