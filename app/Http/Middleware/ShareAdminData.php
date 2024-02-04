<?php

namespace App\Http\Middleware;

use App\Models\Booking;
use App\Models\Contact;
use App\Models\LeaveMessage;
use App\Models\Settings;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ShareAdminData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('admin')->user();
        $site_settings = Settings::where(['id' => 1])->get()->first();
        $contact_settings = Contact::where(['id' => 1])->get()->first();
        $booking_new = Booking::where(['status_id' => 1])->count();
        $booking_verified = Booking::whereIn('status_id', [2])->count();
        $booking_inprogress = Booking::whereIn('status_id', [3])->count();
        $booking_history = Booking::whereIn('status_id', [4])->count();
        $booking_cancel = Booking::whereIn('status_id', [5])->count();
        $unseen_messages = LeaveMessage::where('seen', 0)->count();

        /* frontoffice */
        $temp_id = session('temp_id');

        View::share([
            'shareUser' => $user,
            'shareSite' => $site_settings,
            'shareContact' => $contact_settings,
            'shareBookingNew' => $booking_new,
            'shareBookingPending' => $booking_history,
            'shareBookingVerified' => $booking_verified,
            'shareBookingInprogress' => $booking_inprogress,
            'shareBookingHistory' => $booking_history,
            'shareBookingCancel' => $booking_cancel,
            'share_messages' => $unseen_messages,
            'share_tempId' => $temp_id,
        ]);

        return $next($request);
    }
}
