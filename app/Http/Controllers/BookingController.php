<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestStoreBookingVilla;
use App\Models\Booking;
use App\Models\Villa;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function bookingVilla($id)
    {   
        $villa = Villa::with(['bookings' => function($q){
            $q->orderBy('tanggal_checkin')->take(10);
        }])->whereUuid($id)->firstOrFail();

        $userBooked = Booking::whereUserId(Auth::id())->whereVillaId($villa->id)->first();

        $snapToken = '';

        return view('frontend.villa.booking-villa', compact('villa', 'userBooked', 'snapToken'));
    }

    public function bookingStoreVilla(RequestStoreBookingVilla $request, $id)
    {
        $validated = $request->validated() + ['uuid' => Str::uuid(), 'created_at' => now(), 'user_id' => Auth::id(), 'villa_id' => $id];

        $villa = Villa::whereUuid($id)->with('bookings')->firstOrFail();
        $bookedvilla = Booking::whereVillaId($villa->id)->where('tanggal_checkin', '<=', $request->tanggal_checkin)
                                                        ->where('tanggal_checkout', '>=', $request->tanggal_checkin)
        ->get();
        
        if(count($bookedvilla) > 0){
            return redirect()->back()->with('error', 'Villa sudah terbooking pada tanggal '.$request->tanggal_checkin. ' sampai tanggal '.$request->tanggal_checkout)->withErrors(['tanggal_checkin', 'tanggal_checkout']);
        }

        $newbooking = $villa->bookings()->create($validated);

        return redirect(route('booking.villa', $villa->uuid))->with('success', 'Berhasil sewa, silahkan klik "Bayar" untuk melanjutkan.');
    }

    public function bookingDestroyVilla($bookingId)
    {
        $booking = Booking::whereUuid($bookingId)->firstOrFail();
        $booking->delete();

        return response()->json([
            'message' => 'Berhasil membatalkan sewa villa.',
        ]);
    }

    public function listBookingVilla()
    {
        $user = Auth::user();

        $bookings = Booking::whereUserId($user->id)->get();

        return view('frontend.villa.list-booking', compact('bookings'));
    }

    public function bayarBooking(Request $request)
    {
        $booking = Booking::whereUuid($request->bookingId)->firstOrFail();
        $validated = ['status_pembayaran' => 'sudah bayar', 'updated_at' => now() ];
        $booking->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil',
            're' => $request->all()
        ]);
    }
}
