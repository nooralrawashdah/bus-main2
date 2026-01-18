<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Region;
use App\Models\Trip;
use App\Models\Bus;
use App\Models\BusSeat;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Studentcontroller extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $student = Auth::user();
        return view('student.dashboard', compact('student'));
    }

    // عرض حجوزات الطالب
    public function reservations()
    {
        $student = Auth::user();
        $bookings = Booking::where('user_id', $student->id)
            ->with(['trip.route', 'trip.bus', 'busSeat.seat'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.reservations', compact('bookings'));
    }

    // عرض الرحلات حسب المنطقة
    public function trips()
    {
        $student = Auth::user();
        $trips = Trip::whereHas('route', function ($q) use ($student) {
            $q->where('region_id', $student->region_id);
        })->with(['route', 'bus'])->get();

        return view('student.trips', compact('trips'));
    }

    public function buses($tripId)
{
    // 1. جلب بيانات الرحلة
    $trip = Trip::with('bus')->findOrFail($tripId);

    $reservedSeatsCount = \DB::table('bookings')
        ->join('bus_seats', 'bookings.bus_seat_id', '=', 'bus_seats.id')  // هون ربطت يدوي  بين جدول الحجز و الوسيط
        ->where('bookings.trip_id', $tripId)
        ->where('bus_seats.bus_id', $trip->bus_id)
        ->count();

    // 3. جلب الباص وإضافة قيمة "reserved_seats" له يدوياً
    $buses = Bus::where('id', $trip->bus_id)->get()->map(function($bus) use ($reservedSeatsCount) {
        $bus->reserved_seats = $reservedSeatsCount;
        return $bus;
    });

    // 4. تصفية الباصات (إذا كان ممتلئاً لا يظهر)
    $buses = $buses->filter(function($bus) {
        return $bus->reserved_seats < $bus->capacity;
    });

    return view('student.buses', compact('trip', 'buses'));
}

    // عرض الباصات لرحلة معينة (مع إخفاء الباصات الممتلئة)
   /* public function buses($tripId)
    {
        $trip = Trip::with('bus')->findOrFail($tripId);

        // جلب الباصات المرتبطة بالرحلة والتصفية على مستوى قاعدة البيانات
        $buses = Bus::where('id', $trip->bus_id)
            ->withCount(['seats as reserved_seats' => function ($q) use ($tripId) {
                // نعد فقط الحجوزات لنفس الرحلة
                $q->whereHas('bookings', function ($q2) use ($tripId) {
                    $q2->where('trip_id', $tripId);
                });
            }])
            ->havingRaw('reserved_seats < capacity') // تصفية الباصات الممتلئة مباشرة من الداتابيز
            ->get();

        return view('student.buses', compact('trip', 'buses'));
    }*/

    // عرض المقاعد لباص معين
    public function seats($tripId, $busId)
    {
        $trip = Trip::findOrFail($tripId);
        $bus = Bus::findOrFail($busId);
       

        // نجيب المقاعد مع حالة حجزها في الرحلة دي
        $seats = BusSeat::where('bus_id', $busId)
            ->with(['seat','bookings' => function ($q) use ($tripId) {
                $q->where('trip_id', $tripId);
            }])
            ->get();

        return view('student.seats', compact('trip', 'bus', 'seats'));
    }

    // حجز مقعد
    public function reserveSeat(Request $request, $tripId, $seatId)
    {
        $student = Auth::user();

        return DB::transaction(function () use ($student, $tripId, $seatId) {
            // نتحقق الأول إن الطالب معندوش حجز في نفس الرحلة
            $existing = Booking::where('user_id', $student->id)
                ->where('trip_id', $tripId)
                ->lockForUpdate() // قفل مؤقت
                ->exists();

            if ($existing) {
                return back()->with('error', 'You already have a reservation for this trip.');
            }

            // 2. التحقق من أن المقعد شاغر
            $isReserved = Booking::where('trip_id', $tripId)
                ->where('bus_seat_id', $seatId)
                ->lockForUpdate() // قفل مؤقت عشان محدش يحجزه واحنا بنشيك
                ->exists();

            if ($isReserved) {
                return back()->with('error', 'This seat has just been reserved by someone else.');
            }

            // 3. إنشاء الحجز
            Booking::create([
                'user_id' => $student->id,
                'trip_id' => $tripId,
                'bus_seat_id' => $seatId,
            ]);

            return redirect()->route('student.dashboard')->with('success', 'Seat reserved successfully!');
        });
    }





    // إلغاء الحجز
    public function cancelReservation($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $student = Auth::user();

        if ($booking->user_id != $student->id) {
            abort(403, 'Unauthorized');
        }

        $booking->delete();

        return redirect()->route('student.reservations')->with('success', 'Reservation cancelled.');
    }

    // تعديل المنطقة/العنوان
    public function updateProfile(Request $request)
    {
        $student = Auth::user();

        $validated = $request->validate([
            'region_id' => 'required|exists:regions,id',
        ]);

        $student->update($validated); // This updates the User model since Auth::user() returns User instance

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
    }

    // صفحة البروفايل
    public function profile()
    {
        $student = Auth::user();
        $regions = Region::all();

        return view('student.profile', compact('student', 'regions'));
    }

     // تعديل الحجز
   /* public function editReservation(Request $request, $bookingId)
    {
        $request->validate([
            'seat_id' => 'required|exists:bus_seats,id',
        ]);

        $booking = Booking::findOrFail($bookingId);
        $student = Auth::user();

        if ($booking->user_id != $student->id) {
            abort(403, 'Unauthorized');
        }

        return DB::transaction(function () use ($booking, $request) {
            // نتأكد إن المقعد الجديد فاضي في نفس الرحلة
            $isNewSeatTaken = Booking::where('trip_id', $booking->trip_id)
                ->where('bus_seat_id', $request->seat_id)
                ->where('id', '!=', $booking->id) // نتجاهل حجزنا الحالي
                ->lockForUpdate()
                ->exists();

            if ($isNewSeatTaken) {
                return back()->with('error', 'The new seat is already taken.');
            }

            $booking->update([
                'bus_seat_id' => $request->seat_id,
            ]);

            return redirect()->route('student.dashboard')->with('success', 'Reservation updated successfully.');
        });*/

}
