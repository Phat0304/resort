<?php

namespace App\Http\Controllers\view;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Bank;
use App\Models\Booking;
use App\Models\BookingStatus;
use App\Models\Carousel;
use App\Models\Contact;
use App\Models\Facilitie;
use App\Models\Feature;
use App\Models\LeaveMessage;
use App\Models\Room;
use App\Models\Settings;
use App\Models\TempBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BackController extends Controller
{
    public function adminPage(Request $request)
    {
        $page = $request->page;
        $user = Auth::guard('admin')->user();

        /* Settings page */
        $site_settings = Settings::where(['id' => 1])->get()->first();
        $contact_settings = Contact::where(['id' => 1])->get()->first();

        /* Carousel page */
        $carousel = Carousel::orderBy('priority', 'ASC')->get();

        /* Message page */
        $messages = LeaveMessage::orderBy('send_date', 'DESC')->get();

        foreach ($messages as $message) {
            $msg = $message->message;
            $submsg = substr($msg, 0, 40);
            $message->submsg = $submsg;
        }

        /* Feature&Fac page */
        $features = Feature::orderBy('priority', 'ASC')->get();
        $facilities = Facilitie::orderBy('priority', 'ASC')->get();

        /* Rooms page */
        $rooms = Room::orderBy('created_at', 'ASC')->get();
        $features_room = Feature::where(['display' => 1])->orderBy('priority', 'ASC')->get();
        $facilities_room = Facilitie::where(['display' => 1])->orderBy('priority', 'ASC')->get();

        /* Bank page */
        $banks = Bank::orderBy('priority', 'ASC')->get();

        /* Admins page */
        $admins = Admin::all();

        /* Managebook page */
        $bookings1 = Booking::join('booking_statuses AS bs', 'bs.id', 'bookings.status_id')
            ->join('rooms', 'rooms.id', 'bookings.room_id')
            ->select('bookings.*', 'rooms.name AS room_name', 'bs.name AS status_name', 'bs.bg_color AS bg_color')
            ->whereIn('bookings.status_id', [1, 2, 3])
            ->orderBy('bookings.created_at', 'DESC')
            ->get();

        $booking_online = $this->getBookingByType('Online');
        $booking_walkin = $this->getBookingByType('Walk-in');
        $statuses = BookingStatus::orderBy('id', 'ASC')->get();

        /* list_checkin_today page */
        $bookings = Booking::join('booking_statuses AS bs', 'bs.id', 'bookings.status_id')
            ->join('rooms', 'rooms.id', 'bookings.room_id')
            ->select('bookings.*', 'rooms.name AS room_name', 'bs.name AS status_name', 'bs.bg_color AS bg_color')
            ->whereIn('bookings.status_id', [2, 3, 4])
            ->orderBy('bookings.created_at', 'DESC')
            ->get();

        $today = now()->toDateString();
        $list_checkin_today = $this->getBookingByCheckin($today);
        $list_checkout_today = $this->getBookingByCheckout($today);
        $statuses = BookingStatus::orderBy('id', 'ASC')->get();

        /* bookinghistory page */
        $bookinghistory = Booking::join('booking_statuses AS bs', 'bs.id', 'bookings.status_id')
            ->join('rooms', 'rooms.id', 'bookings.room_id')
            ->select('bookings.*', 'rooms.name AS room_name', 'bs.name AS status_name', 'bs.bg_color AS bg_color')
            ->whereIn('bookings.status_id', [4, 5])
            ->orderBy('bookings.created_at', 'DESC')
            ->get();

        $bookinghistory_online = $this->getBookingHistoryByType('Online');
        $bookinghistory_walkin = $this->getBookingHistoryByType('Walk-in');

        /* Dashboard page */
        $allRoom = Room::count();
        $allCustomer = Booking::get()->groupBy('card_id');
        $bookingAll = Booking::get();
        $incomes = Booking::where('status_id', 4)->sum('price');
        $bookingCompleteAll = Booking::where('status_id', 4)->get();

        $bookingComplete = Booking::join('rooms', 'rooms.id', 'bookings.room_id')
            ->whereYear('date_checkin', date('Y'))
            ->select('bookings.*', 'rooms.name AS room_name')
            ->where('bookings.status_id', 4)
            ->get();

        foreach ($bookingComplete as $book) {
            $book->month = substr($book->date_checkin, 5, -3);
        }

        if ($user) {
            switch ($page) {
                case 'settings':
                    $this->removeTempBooking();
                    return view('backoffice.settings', [
                        'site' => $site_settings,
                        'contact' => $contact_settings,
                    ]);

                    break;

                case 'rooms':
                    $this->removeTempBooking();

                    return view('backoffice.rooms', [

                        'features' => $features_room,
                        'facilities' => $facilities_room,
                        'rooms' => $rooms,
                    ]);

                    break;

                case 'admins':
                    $this->removeTempBooking();
                    return view('backoffice.admins', ['banks' => $banks, 'admins' => $admins]);
                    break;

                case 'messages':
                    $this->removeTempBooking();
                    return view('backoffice.messages', ['messages' => $messages]);
                    break;

                case 'features_fac':
                    $this->removeTempBooking();
                    return view('backoffice.features-fac', [
                        'features' => $features,
                        'facilities' => $facilities,
                    ]);
                    break;

                case 'carousel':
                    $this->removeTempBooking();
                    return view('backoffice.carousel', [
                        'slide_img' => $carousel,
                    ]);
                    break;

                case 'bank':
                    $this->removeTempBooking();
                    return view('backoffice.bank', [
                        'banks' => $banks,
                    ]);
                    break;

                case 'managebook':

                    $this->removeTempBooking();
                    return view('backoffice.managebook', [
                        'bookings' => $bookings1,
                        'booking_online' => $booking_online,
                        'booking_walkin' => $booking_walkin,
                        'statuses' => $statuses,
                    ]);
                    break;
                case 'list_checkin_today':
                    $this->removeTempBooking();
                    return view('backoffice.list_checkin_today', [
                        'bookings' => $bookings,
                        'list_checkin_today' => $list_checkin_today,
                        'booking_online' => $booking_online,
                        'booking_walkin' => $booking_walkin,
                        'statuses' => $statuses,
                        'today' => $today,

                    ]);
                    break;

                case 'list_checkout_today':
                    $this->removeTempBooking();
                    return view('backoffice.list_checkout_today', [
                        'bookings' => $bookings,
                        'list_checkout_today' => $list_checkout_today,
                        'booking_online' => $booking_online,
                        'booking_walkin' => $booking_walkin,
                        'statuses' => $statuses,
                        'today' => $today,

                    ]);
                    break;

                case 'bookinghistory':
                    $this->removeTempBooking();
                    return view('backoffice.bookinghistory', [
                        'bookings' => $bookinghistory,
                        'booking_online' => $bookinghistory_online,
                        'booking_walkin' => $bookinghistory_walkin,
                        'statuses' => $statuses,
                    ]);
                    break;

                case 'booking':
                    $this->removeTempBooking();
                    $validator = Validator::make($request->all(), [
                        'checkin' => 'string|required',
                        'checkout' => 'string|required',
                        'adult' => 'numeric|required',
                        'children' => 'numeric|required',
                    ]);

                    $current_timestamp = strtotime(date('Y-m-d'));
                    $checkin_timestamp = strtotime($request->checkin);
                    $checkout_timestamp = strtotime($request->checkout);

                    if (($checkin_timestamp !== false && $checkin_timestamp < $current_timestamp) || ($checkout_timestamp !== false && $checkout_timestamp < $checkin_timestamp) || ($checkin_timestamp !== false && $checkin_timestamp === $checkout_timestamp)) {
                        return view('backoffice.booking', [
                            'rooms' => [],
                        ]);
                    }

                    $now = Carbon::now();
                    $tempLimit = $now->subMinutes(16);
                    $tempBooking = TempBooking::where('created_at', '>', $tempLimit)->get();

                    $rooms = Room::where(['display' => 1])->orderBy('price', 'ASC')->get();
                    $roomAvailable = [];

                    foreach ($rooms as $room) {
                        $fea_ids = explode(', ', $room->feature_ids);
                        $fac_ids = explode(', ', $room->fac_ids);

                        $features = Feature::whereIn('id', $fea_ids)->orderBy('priority', 'ASC')->get();
                        $facs = Facilitie::whereIn('id', $fac_ids)->orderBy('priority', 'ASC')->get();
                        $gallery = $room->gallery;

                        $room->features = $features;
                        $room->facs = $facs;
                        $room->gallery = $gallery;

                        if (count($room->gallery) !== 0) {
                            $roomAvailable[] = $room;
                        }
                    }

                    if (!$validator->fails()) {
                        // หาจำนวนคืนที่เข้าพัก
                        $start_date = $request->checkin;
                        $end_date = $request->checkout;
                        $start_timeStamp = strtotime($start_date);
                        $end_timeStamp = strtotime($end_date);
                        $secondsDiff = $end_timeStamp - $start_timeStamp;
                        $diff_date = $secondsDiff / (60 * 60 * 24);

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
                                foreach ($roomAvailable as $room_key => $room_value) {
                                    if (($room_value->id === $book_value->room_id) || ($room_value->adult < $request->adult || $room_value->children < $request->children)) {
                                        unset($roomAvailable[$room_key]);
                                    }
                                }
                            }
                        } else { // กรองจำนวนผู้เข้าพัก
                            foreach ($rooms as $room_key => $room_value) {
                                if (($room_value->adult < $request->adult || $room_value->children < $request->children)) {
                                    unset($roomAvailable[$room_key]);
                                }
                            }
                        }

                        if (count($tempBooking) > 0) { // temp booking
                            $roomTemp_ids = [];

                            foreach ($tempBooking as $temp) {
                                $current_date = $request->checkin;
                                for ($i = 0; $i < $diff_date; $i++) {
                                    if (Str::contains($temp->booking_date, $current_date)) { // เปรียบเทียบ String
                                        $roomTemp_ids[] = $temp->room_id;
                                    }
                                    $current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
                                }
                            }

                            if (count($roomTemp_ids) > 0) {
                                foreach ($roomTemp_ids as $id_key => $id) {
                                    foreach ($roomAvailable as $room_key => $room_value) {
                                        if ($id === $room_value->id) {
                                            unset($roomAvailable[$room_key]);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $this->removeTempBooking();

                    $today = now();
                    $month = $today->month - 1;
                    $year = $today->year;

                    return view('backoffice.booking', [
                        'rooms' => $roomAvailable,
                        'month' => $month,
                        'year' => $year,
                    ]);
                    break;

                default:
                    // dd($bookingComplete);
                    $this->removeTempBooking();
                    return view('backoffice.dashboard', [
                        'allRoom' => $allRoom,
                        'allCustomer' => $allCustomer,
                        'bookingAll' => $bookingAll,
                        'bookingCompleteAll' => $bookingCompleteAll,
                        'rooms' => $rooms,
                        'bookingComplete' => $bookingComplete,
                        'income' => number_format($incomes, 0),
                        'bookingOnline' => Booking::where('booking_type', 'Online')->count(),
                        'bookingWalkin' => Booking::where('booking_type', 'Walk-in')->count(),
                    ]);
                    break;
            }
        }
    }

    public function loginPage(Request $request)
    {

        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin');
        }

        return view('backoffice.login');

    }

    private function getBookingByCheckin($date_checkin)
    {
        $result = Booking::join('booking_statuses AS bs', 'bs.id', 'bookings.status_id')
            ->join('rooms', 'rooms.id', 'bookings.room_id')
            ->select('bookings.*', 'rooms.name AS room_name', 'bs.name AS status_name', 'bs.bg_color AS bg_color')
            ->whereIn('bookings.status_id', [2, 3, 4])
            ->where('bookings.date_checkin', $date_checkin)
            ->orderBy('bookings.created_at', 'DESC')
            ->get();

        return $result;
    }

    private function getBookingByCheckout($date_checkout)
    {
        $result = Booking::join('booking_statuses AS bs', 'bs.id', 'bookings.status_id')
            ->join('rooms', 'rooms.id', 'bookings.room_id')
            ->select('bookings.*', 'rooms.name AS room_name', 'bs.name AS status_name', 'bs.bg_color AS bg_color')
            ->whereIn('bookings.status_id', [2, 3, 4])
            ->where('bookings.date_checkout', $date_checkout)
            ->orderBy('bookings.created_at', 'DESC')
            ->get();

        return $result;
    }

    private function getBookingByType($type)
    {
        $result = Booking::join('booking_statuses AS bs', 'bs.id', 'bookings.status_id')
            ->join('rooms', 'rooms.id', 'bookings.room_id')
            ->select('bookings.*', 'rooms.name AS room_name', 'bs.name AS status_name', 'bs.bg_color AS bg_color')
            ->whereIn('bookings.status_id', [1, 2, 3])
            ->where('bookings.booking_type', $type)
            ->orderBy('bookings.created_at', 'DESC')
            ->get();

        return $result;
    }

    private function getBookingHistoryByType($type)
    {
        $result = Booking::join('booking_statuses AS bs', 'bs.id', 'bookings.status_id')
            ->join('rooms', 'rooms.id', 'bookings.room_id')
            ->select('bookings.*', 'rooms.name AS room_name', 'bs.name AS status_name', 'bs.bg_color AS bg_color')
            ->whereIn('bookings.status_id', [4, 5])
            ->where('bookings.booking_type', $type)
            ->orderBy('bookings.created_at', 'DESC')
            ->get();

        return $result;
    }

    private function checkedRoomAvailable($request)
    {
        $validator = Validator::make($request->all(), [
            'checkin' => 'string|required',
            'checkout' => 'string|required',
            'adult' => 'numeric|required',
            'children' => 'numeric|required',
        ]);

        $current_timestamp = strtotime(date('Y-m-d'));
        $checkin_timestamp = strtotime($request->checkin);
        $checkout_timestamp = strtotime($request->checkout);

        if (($checkin_timestamp !== false && $checkin_timestamp < $current_timestamp) || ($checkout_timestamp !== false && $checkout_timestamp < $checkin_timestamp) || ($checkin_timestamp !== false && $checkin_timestamp === $checkout_timestamp)) {
            return view('frontoffice.booking', [
                'rooms' => [],
            ]);
        }
    }
}
