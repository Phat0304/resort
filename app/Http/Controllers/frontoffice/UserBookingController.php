<?php

namespace App\Http\Controllers\frontoffice;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\TempBooking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserBookingController extends Controller
{
   

    public function createBookOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "image" => "image|required|mimes:jpeg,png,jpg",
            "fname" => "string|required",
            "lname" => "string|required",
            "phone" => "string|required",
            "email" => "email|required",
            "card_id" => "numeric|required",
            "four_id" => "numeric|required",
            "line_id" => "string|nullable",
            "checkin" => "string|required",
            "checkout" => "string|required",
            "room_id" => "numeric|required",
            'g-recaptcha-response' => 'required|captcha', 
        ]);

        if ($validator->fails()) {
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => 'Invalid params!',
            ], 404);
        }

        $room = Room::where(['id' => $request->room_id])->first();

        $isAvailable = $this->checkAvailableRoom($request, $room);

        if (!$isAvailable) {
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => 'This room is not available!',
                'isAvailable' => $isAvailable,
            ], 403);
        }

        try {
            DB::beginTransaction();

            $current_date = $request->checkin;
            $booking_date = "";
            for ($i = 0; $i < $request->days; $i++) {
                $booking_date .= "," . date('Y-m-d', strtotime($current_date));
                $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
            }

            $files = $request->allFiles();
            $slip_image = "";
            if (isset($files['image'])) {
                /* Upload Image */
                $newFolder = "upload/frontoffice/slip/";
                $slip_image = $this->uploadImage($newFolder, $files['image'], "newslip", "", "");
            }

            $order = new Booking();
            $order->room_id = $request->room_id;
            $order->price_per_date = $request->price_per_date;
            $order->price = $request->price;
            $order->date_checkin = date('Y-m-d', strtotime($request->checkin));
            $order->date_checkout = date('Y-m-d', strtotime($request->checkout));
            $order->booking_date = $booking_date;
            $order->days = $request->days;
            $order->status_id = 1;
            $order->booking_type = "Online";
            $order->cus_fname = $request->fname;
            $order->cus_lname = $request->lname;
            $order->cus_phone = $request->phone;
            $order->email = $request->email;
            $order->card_id = $request->card_id;
            $order->four_id = $request->four_id;
            $order->line_id = $request->line_id;
            $order->payment_type = "transfer";
            $order->slip = $slip_image;
            $order->save();

            $this->sendLineNotify($order, $room); //ส่งข้อความไปไลน์
            $this->removeTempBooking();

            DB::commit();
            return response([
                'message' => 'ok',
                'status' => true,
                'description' => 'Order has been created successfully.',
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            $this->removeTempBooking();

            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkBookTimeout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "temp_id" => "string|required",
        ]);

        $temp_booking = TempBooking::where('temp_id', $request->temp_id)->first();

        if ($validator->fails() || !session()->has('temp_id') || !$temp_booking) {
            return response([
                'message' => 'error',
                'status' => false,
                'errorMessage' => 'Booking timeout!',
            ], 408);
        }

        // หาระยะห่างเวลาการจองจากตาราง temp_bookings
        $time_current = now();
        $timebook = $temp_booking->created_at;
        $diffminute = $timebook->diffInMinutes($time_current);

        if ($diffminute >= 16) {
            TempBooking::where('temp_id', $request->temp_id)->delete();
            session()->forget('temp_id');

            return response([
                'message' => 'Booking timeout!',
            ], 408);
        }

        return response([
            'temp_id' => $request->temp_id,
            'temp_booking' => $temp_booking,
            'validate' => $validator->fails(),
            'diffminute' => $diffminute,
        ]);
    }

    
    public function deleteTempBooking(Request $request)
    {
        try {
            DB::beginTransaction();

            TempBooking::where('temp_id', $request->temp_id)->delete();
            session()->forget('temp_id');

            DB::commit();
            return response()->json([
                'message' => 'success',
                'status' => true,
                'description' => 'Delete temp booking successfully.',
            ], 201);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'error',
                'status' => false,
                'errorsMessage' => $e->getMessage(),
            ], 501);
        }
    }
}
