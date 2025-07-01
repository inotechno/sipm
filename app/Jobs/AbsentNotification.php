<?php

namespace App\Jobs;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AbsentNotification implements ShouldQueue
{
    use Queueable;

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
            } else {
                $date = Carbon::parse($data['date'])->format('d F Y H:i');
                if($employeeExists->phone){
                    $message = "Anda tercatat tidak hadir pada tanggal {$date} shift: {$data['shift']}";
                    $this->sendWhatsAppNotification($employeeExists->phone, $message);
                }
            }
        } catch (\Throwable $th) {
            \Log::error(date('Y-m-d H:i:s') . ' ' . $th->getMessage());
        } 
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
