<?php

namespace App\Http\Controllers;

use App\Jobs\AttendanceJob;
use App\Jobs\AttendanceSyncJob;
use App\Models\ConfigAttendance;
use App\Models\Employee;
use App\Models\Machine;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isTrue;

class IClockController extends Controller
{
    public function __invoke(Request $request) {}

    public function handshake(Request $request)
    {
        $r = "GET OPTION FROM: {$request->input('SN')}\r\n" .
            "Stamp=9999\r\n" .
            "OpStamp=" . time() . "\r\n" .
            "ErrorDelay=60\r\n" .
            "Delay=30\r\n" .
            "ResLogDay=18250\r\n" .
            "ResLogDelCount=10000\r\n" .
            "ResLogCount=50000\r\n" .
            "TransTimes=00:00;14:05\r\n" .
            "TransInterval=1\r\n" .
            "TransFlag=1111000000\r\n" .
            "TimeZone=7\r\n" .
            "Realtime=1\r\n" .
            "Encrypt=0";

        \Log::info('Handshake', $request->all());
        return $r;
    }

    public function test(Request $request)
    {
        \Log::info('Test', $request->all());
    }

    public function receiveRecords(Request $request)
    {
        \Log::info('Receive Records', $request->all());
        // return "OK: 0";

        try {
            $sn = $request->input('SN');
            $arr = preg_split('/\\r\\n|\\r|,|\\n/', $request->getContent());

            // \Log::info('Arr: '. json_encode($arr));

            $tot = 0;

            //operation log
            if ($request->input('table') == "OPERLOG") {
                foreach ($arr as $rey) {
                    if (isset($rey)) {
                        $tot++;
                    }
                }

                \Log::info('Operation Log', $request->all());
                return "OK: " . $tot;
            }

            //attendance
            foreach ($arr as $rey) {
                if (empty($rey)) {
                    continue;
                }

                $data = explode("\t", $rey);

                $time = date('H:i:s', strtotime($data[1]));

                $employee = $this->getEmployee($data[0]);

                $name = '';
                $phone = '';
                $shift = null;
                $shiftDate = null;
                $is_active = false;

                \Log::info('Data: '. json_encode($data));

                if ($employee != null) {
                    $name = $employee->name;
                    $phone = $employee->phone;
                    $is_active = true;
                } else {
                    $employee = Employee::updateOrCreate([
                        'id' => $data[0]
                    ], [
                        'name' => $data[0],
                    ]);

                    $name = $employee->name;
                    $is_active = false;
                }

                $shift_employee = $employee->shift;
                // $machine = Machine::where('serial_number', $request->input('SN'))->first();
                // $shift_employee = $machine->shift;

                $dayOfWeek = Carbon::parse($data[1])->format('l'); // Mendapatkan nama hari

                if ($shift_employee == 1) {
                    $dayOfWeek = Carbon::parse($data[1])->format('l'); // Mendapatkan nama hari
                    $shiftDate = Carbon::parse($data[1])->toDateString();
                } else if ($shift_employee == 2) {
                    if (Carbon::parse($data[1])->hour >= 0 && Carbon::parse($data[1])->hour <= 11) {
                        $dayOfWeek = Carbon::parse($data[1])->subDay()->format('l');
                        $shiftDate = Carbon::parse($data[1])->subDay()->toDateString();
                    } else {
                        $dayOfWeek = Carbon::parse($data[1])->format('l'); // Mendapatkan nama hari
                        $shiftDate = Carbon::parse($data[1])->toDateString();
                    }
                }

                // Ambil semua shift yang berlaku untuk hari tersebut
                $shift = Shift::where('day_of_week', strtolower($dayOfWeek))->where('shift', $shift_employee)->first();

                if(!isset($shift)) {
                    \Log::info('Shift Not Found', $request->all());
                }

                // if ($shifts->isNotEmpty()) {
                //     foreach ($shifts as $potentialShift) {
                //         // Validasi apakah fingerprint sesuai dengan waktu shift
                //         if ($this->isValidFingerprintTime($data[1], $potentialShift)) {
                //             $shift = $potentialShift; // Pilih shift yang sesuai
                //             break; // Berhenti pada shift pertama yang valid
                //         }
                //     }
                // }

                if (isset($shift)) {

                    // Tetapkan shift_date berdasarkan waktu fingerprint
                    $timestamp = Carbon::parse($request->datetime);

                    // // Tetapkan waktu awal dan akhir shift dengan tanggal yang sesuai
                    // $shiftStartAdjustment = Carbon::parse($timestamp->toDateString() . ' ' . $shift->start_adjustment);
                    // $shiftEndAdjustment = Carbon::parse($timestamp->toDateString() . ' ' . $shift->end_adjustment);

                    // // Jika shift berakhir keesokan harinya (melewati tengah malam)
                    // if ($shiftEndAdjustment->lt($shiftStartAdjustment)) {
                    //     $shiftEndAdjustment = $shiftEndAdjustment->addDay(); // Tambahkan 1 hari pada waktu akhir shift
                    // }

                    // // Tetapkan shift_date berdasarkan waktu fingerprint
                    // if ($timestamp->hour < 6) {
                    //     // Jika fingerprint setelah waktu akhir shift, gunakan tanggal shift sebelumnya
                    //     $shiftDate = $shiftStartAdjustment->subDay()->toDateString();
                    // } else {
                    //     // Jika fingerprint masih dalam rentang shift, gunakan tanggal saat shift mulai
                    //     $shiftDate = $shiftStartAdjustment->toDateString();
                    // }

                    $attendanceData = [
                        'sn' => $sn,
                        'uid' => $data[0] . date('dHi'),
                        'employee_id' => $data[0],
                        'state' => $data[2],
                        'timestamp' => $data[1],
                        'name' => $name,
                        'phone' => $phone,
                        'group_id' => $employee->group_id,
                        'position_id' => $employee->position_id,
                        'is_active' => $is_active,
                        'shift_id' => $shift->id,
                        'shift_date' => $shiftDate
                    ];

                    AttendanceJob::dispatch($attendanceData);
                    $tot++;

                    \Log::info('Attendance Data', $attendanceData);
                }
            }

            \Log::info('Receive Records', $request->all());
            return "OK: " . $tot;
        } catch (Exception $e) {
            \Log::error('Error', $e->getMessage());
            return "ERROR: " . $tot . "\n";
        }
    }

    public function getrequest(Request $request)
    {
        // \Log::info('Get Request', $request->all());
        return "OK";
    }

    protected function getEmployee($id)
    {
        return Employee::withTrashed()->find($id) ?? null;
    }

    public function testAttendance(Request $request)
    {
        try {
            $shift = null;
            $shiftDate = null;

            $employee = $this->getEmployee($request->employee_id);

            $name = '';
            $phone = '';
            $shift = null;
            $shiftDate = null;
            $is_active = false;

            dd($employee);
            if ($employee != null) {
                $name = $employee->name;
                $phone = $employee->phone;
                $is_active = true;
            } else {
                $employee = Employee::updateOrCreate([
                    'id' => $request->employee_id
                ], [
                    'name' => $request->employee_id,
                ]);

                $name = $employee->name;
                $is_active = false;
            }

            $shift_employee = $employee->shift;
                // $machine = Machine::where('serial_number', $request->input('SN'))->first();
                // $shift_employee = $machine->shift;
            // $machine = Machine::where('serial_number', $request->input('SN'))->first();

            // if (!isset($machine)) {
            //     return "ERROR: Machine Not Found";
            // }

            $dayOfWeek = Carbon::parse($request->timestamp)->format('l'); // Mendapatkan nama hari

            if ($shift_employee == 1) {
                $dayOfWeek = Carbon::parse($request->timestamp)->format('l'); // Mendapatkan nama hari
                $shiftDate = Carbon::parse($request->timestamp)->toDateString();
            } else if ($shift_employee == 2) {
                if (Carbon::parse($request->timestamp)->hour >= 0 && Carbon::parse($request->timestamp)->hour <= 12) {
                    $dayOfWeek = Carbon::parse($request->timestamp)->subDay()->format('l');
                    $shiftDate = Carbon::parse($request->timestamp)->subDay()->toDateString();
                } else {
                    $dayOfWeek = Carbon::parse($request->timestamp)->format('l'); // Mendapatkan nama hari
                    $shiftDate = Carbon::parse($request->timestamp)->toDateString();
                }
            }

            // Ambil semua shift yang berlaku untuk hari tersebut
            $shift = Shift::where('day_of_week', strtolower($dayOfWeek))->where('shift', $shift_employee)->first();

            // dd($shift);

            if (isset($shift)) {

                // Tetapkan shift_date berdasarkan waktu fingerprint
                $timestamp = Carbon::parse($request->timestamp);

                $attendanceData = [
                    'sn' => 'TESTSN',
                    'uid' => 'test' . date('dHi'),
                    'employee_id' => $request->employee_id,
                    'state' => 1,
                    'timestamp' => $request->timestamp,
                    'name' => 'Achmad Fatoni',
                    'phone' => '6289676490971',
                    'group_id' => 1,
                    'position_id' => 1,
                    'is_active' => 1,
                    'shift_id' => $shift->id,
                    'shift_date' => $shiftDate
                ];

                AttendanceJob::dispatch($attendanceData);

                return "OK";
            }
        } catch (Exception $e) {
            \Log::error('Error', $e->getMessage());
            return "ERROR";
        }
    }

    // Fungsi untuk mengecek apakah waktu fingerprint sesuai dengan shift
    protected function isValidFingerprintTime($timestamp, $shift)
    {
        $time = Carbon::parse($timestamp);

        // Dapatkan tanggal awal shift
        $shiftStartDate = $time->toDateString(); // Default tanggal awal shift

        // Jika fingerprint sebelum jam 6 pagi, kita anggap shift dari hari sebelumnya
        if ($time->hour < 6) {
            $shiftStartDate = Carbon::parse($time->toDateString())->subDay()->toDateString();
        }

        // Hitung waktu mulai dan selesai shift berdasarkan tanggal awal shift
        $startAdjustment = Carbon::parse($shiftStartDate . ' ' . $shift->start_adjustment);
        $endAdjustment = Carbon::parse($shiftStartDate . ' ' . $shift->end_adjustment);

        // Jika endAdjustment lebih kecil dari startAdjustment, tambahkan satu hari (shift melewati tengah malam)
        if ($endAdjustment->lt($startAdjustment)) {
            $endAdjustment = $endAdjustment->addDay();
        }

        // Debugging untuk memastikan waktu yang diperiksa
        \Log::info('Shift ID: ' . $shift->id);
        \Log::info('Timestamp: ' . $time);
        \Log::info('Start Adjustment: ' . $startAdjustment);
        \Log::info('End Adjustment: ' . $endAdjustment);

        // Periksa apakah waktu fingerprint berada dalam rentang waktu shift
        return $time->between($startAdjustment, $endAdjustment);
    }
}
