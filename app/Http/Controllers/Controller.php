<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\TempBooking;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendErrorValidators($message, $errorMessages)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errorMessage' => $errorMessages,
        ], 422);
    }

    public function uploadImage($folderPath = "upload/", $image = null, $preName = "", $postName = "", $customName = null)
    {
        if ($image) {
            /* Checking folder */
            if (!file_exists($folderPath)) {
                File::makeDirectory($folderPath, $mode = 0777, true, true);
            }
            $extName = "." . $image->extension();
            $name = ($customName !== null) ? str_replace($extName, "", $customName) : time();
            $fullName = $preName . $name . $postName;
            $newImageName = $fullName . $extName;
            if (file_exists($folderPath . $newImageName)) {
                for ($ii = 1; true; $ii++) {
                    $editNameDuplicate = $fullName . "({$ii})" . $extName;
                    if (!file_exists($folderPath . $editNameDuplicate)) {
                        $newImageName = $editNameDuplicate;
                        break;
                    }
                }
            }
            if ($image->move($folderPath, $newImageName)) {
                return $folderPath . $newImageName;
            }
        }
        return false;
    }

    public function checkAvailableRoom($request, $room)
    {
        // หาจำนวนคืนที่เข้าพัก
        $start_date = $request->checkin;
        $end_date = $request->checkout;
        $start_timeStamp = strtotime($start_date);
        $end_timeStamp = strtotime($end_date);
        $secondsDiff = $end_timeStamp - $start_timeStamp;
        $diff_date = $secondsDiff / (60 * 60 * 24);
        $isAvailable = true;

        $bookings = DB::table('bookings')
            ->select('bookings.*')
            ->where(function ($query) use ($request, $diff_date) {
                $current_date = $request->checkin;
                for ($i = 0; $i < $diff_date; $i++) {
                    $query->orWhere('booking_date', 'like', '%' . $current_date . '%');
                    $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
                }
            })
            ->whereIn('status_id', [1, 2, 3])
            ->get();
        if (count($bookings) > 0) {
            foreach ($bookings as $book_key => $book_value) {
                if ($book_value->room_id === $room->id) {
                    $isAvailable = false;
                }
            }
        }

        return $isAvailable;
    }

    public function sendLineNotify(Booking $booking, Room $room)
    {
        // dd($booking);
        $message = "👇👇 มีรายการจองห้องพักใหม่ 👇👇 \n\n"
        . "No. ►► " . $booking->booking_number . "\n"
        . "เลขอ้างอิงการจอง ►► " . $booking->card_id . "\n"
        . "ประเภทการจอง ►► " . "【 Online 】" . "\n"
        // . "สถานะ ►► " . "รอการตรวจสอบ" . "\n"
        . "ชื่อ-นามสกุล ผู้จอง ►► " . $booking->cus_fname . " " . $booking->cus_lname . "\n"
        . "เบอร์โทร ►► " . $booking->cus_phone . "\n"
        . "ห้องพัก ►► " . $room->name . "\n"
        . "เช็คอิน ►► " . $booking->date_checkin . "\n"
        . "เช็คเอาท์ ►► " . $booking->date_checkout . "\n"
        . "ระยะเวลาเข้าพัก ►► " . $booking->days . ' วัน' . "\n"
        . "ราคารวม ►► " . $booking->price . ' บาท' . "\n";

        $LINE_API = "https://notify-api.line.me/api/notify";
        $LINE_TOKEN = "m70EtTZS2dna8TPfXIaTdK05bhVZN1oWgSoaqJtJzRz";
        $queryData = array('message' => $message);
        $queryData = http_build_query($queryData, '', '&');
        $headerOptions = array(
            'http' => array(
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                . "Authorization: Bearer " . $LINE_TOKEN . "\r\n"
                . "Content-Length: " . strlen($queryData) . "\r\n",
                'content' => $queryData,
            ),
        );
        $context = stream_context_create($headerOptions);
        $result = file_get_contents($LINE_API, false, $context);
        $res = json_decode($result);
        return $res;

    }

    public function removeTempBooking()
    {
        if (session()->has('temp_id')) { //ตรวจสอบ temp_id อยู่ใน session นี้มั้ย
            TempBooking::where('temp_id', session('temp_id'))->delete(); //ลบ temp_id ที่ตรงกัน
            session()->forget('temp_id'); //ลบ temp_id ออกจาก session
        }
    }

    /* Private Function */
    public function createTempBooking(Request $request)
    {
        // session()->forget('temp_id');

        if (!session()->has('temp_id')) { //ตรวจสอบ  temp_id
            $temp_id = 'Temp-' . str_shuffle(time()); // random temp_id

            // หาจำนวนคืนที่เข้าพัก
            $start_date = $request->checkin;
            $end_date = $request->checkout;
            $secondsDiff = strtotime($end_date) - strtotime($start_date);
            $diff_date = $secondsDiff / (60 * 60 * 24);

            $current_date = $request->checkin;
            $booking_date = "";
            for ($i = 0; $i < $diff_date; $i++) {
                $booking_date .= "," . date('Y-m-d', strtotime($current_date));
                $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
            }

            // dd(session('temp_id'));
            $TempBooking = new TempBooking();
            $TempBooking->temp_id = $temp_id;
            $TempBooking->room_id = $request->id;
            $TempBooking->ip_address = $request->ip();
            $TempBooking->date_checkin = date('Y-m-d', strtotime($request->checkin));
            $TempBooking->date_checkout = date('Y-m-d', strtotime($request->checkout));
            $TempBooking->booking_date = $booking_date;
            $TempBooking->days = $diff_date;
            $TempBooking->booking_type = '';
            $TempBooking->save();

            session(['temp_id' => $temp_id]);
            session()->put('tempId_timeout', now()->addMinutes(20));

        }
    }
}
