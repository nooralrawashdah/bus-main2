<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Trip;
use App\Models\Bus;
use Carbon\Carbon;
use App\Models\User;

class DriverController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // جبت  باقي معلومات من جدول سائق لانو هو يلي بدي اتعامل معو مشان باص
        $driverRecord = $user->driver;

        $personalInfo = [
            'name'         => $user->name,
            'email'        => $user->email,
            'phone_number' => $user->phone_number,
            'licenseId'    => $driverRecord ? $driverRecord->driver_license_number : 'N/A',
        ];

        $assignedBus = null;
        if ($driverRecord) {
            $assignedBus = Bus::where('driver_id', $driverRecord->id)->first();
        }

        $todayTrips = $this->getScheduledTrips(Carbon::today());

        return view('driver.dashboard', compact('personalInfo', 'assignedBus', 'todayTrips'));
    }

    public function getScheduledTrips(Carbon $date)
    {
        $user = Auth::user();
        $driverRecord = $user->driver;

        // البحث عن الباص بناءً على سجل السائق
        $assignedBus = $driverRecord ? Bus::where('driver_id', $driverRecord->id)->first() : null;

        if (!$assignedBus) {
            return collect([]);
        }

        return Trip::with(['route', 'bus'])
            ->withCount('bookings')
            ->where('bus_id', $assignedBus->id)
            ->whereDate('start_time', $date)
            ->get();
    }

    public function trips()
    {
        $todayTrips = $this->getScheduledTrips(Carbon::today());
        return view('driver.trips', compact('todayTrips'));
    }

    public function bus()
    {
        $user = Auth::user();
        $driverRecord = $user->driver;

        $assignedBus = $driverRecord ? Bus::where('driver_id', $driverRecord->id)->first() : null;

        return view('driver.bus', compact('assignedBus'));
    }

    public function checkSeatStatus(Trip $trip)
    {
        $bookedSeats = $trip->bookings()->count();
        $busCapacity = $trip->bus->capacity;
        $isFull = $bookedSeats >= $busCapacity;

        return [
            'booked'       => $bookedSeats,
            'capacity'     => $busCapacity,
            'status'       => $isFull ? 'Seats Full' : 'Waiting For Seats',
            'readyToStart' => $isFull
        ];
    }

    public function startTrip(Trip $trip)
    {
        $seatStatus = $this->checkSeatStatus($trip);

        if ($seatStatus['readyToStart']) {
            $trip->status = 'STARTED';
            $trip->save();

            return redirect()->back()->with('success', 'Trip started successfully');
        }

        return redirect()->back()->with('error', 'The bus is not full yet. All seats must be booked to start.');
    }
}
