<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Bus;
use App\Models\Trip;
use App\Models\Driver;
use App\Models\Booking;
use App\Models\Student;
use App\Models\Region;

class ManagerController extends Controller
{

    public function __construct()
    {
        // Middleware is now handled in web.php
        
    }



    public function index()
    {

        $stats = [
            'total_routes' => Route::count(),
            'total_buses' => Bus::count(),
            'total_drivers' => Driver::count(),
            // 'total_students' => Student::count(),
            'active_trips' => Trip::where('status', 'STARTED')->count(),
        ];
        return view('manager.mdashboard', compact('stats'));
    }

    // -------------------------------------------------------------------
    // II. Routes Management (CRUD)
    // -------------------------------------------------------------------

    public function viewRoutes()
    {
        $routes = Route::all();
        $regions = Region::all();
        return view('manager.routes', compact('routes', 'regions'));
    }

    public function createRoute(Request $request)
    {
        $validated = $request->validate([

            'route_name' => 'required|string|max:255|unique:routes,route_name,',
            'start_point' => 'required|string|max:255',
            'end_point' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        Route::create($validated);
        return redirect()->route('manager.routes')->with('success', 'Route added successfully.');
    }

    public function updateRoute(Request $request, Route $route)
    {
        $validated = $request->validate([
            'route_name' => 'required|string|max:255|unique:routes,route_name,' . $route->id,
            'start_point' => 'required|string|max:255',
            'end_point' => 'required|string|max:255',
            'region_id' => 'required|exists:regions,id',
        ]);

        $route->update($validated);
        return redirect()->route('manager.routes')->with('success', 'Route updated successfully.');
    }

    public function deleteRoute(Route $route)
    {
        // Check if there are any trips associated before deletion
        if ($route->trips()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete route. Trips are currently associated with it.');
        }
        $route->delete();
        return redirect()->route('manager.routes')->with('success', 'Route deleted successfully.');
    }

    // -------------------------------------------------------------------
    // III. Buses Management (CRUD)
    // -------------------------------------------------------------------

    public function viewBuses()
    {
        // Fetch buses along with their assigned driver information
        $buses = Bus::with('driver')->get();
        return view('manager.buses', compact('buses'));
    }

    public function showCreateBus()
    {
        $availabelDrivers = Driver::whereDoesntHave('bus')->with('user')->get();

        return view('manager.buses.create', compact('availabelDrivers'));
    }

    public function editBus(Bus $bus)
    {
        return view('manager.buses.edit', compact('bus'));
    }

    public function createBus(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:50|unique:buses,plate_number',
            'capacity' => 'required|integer|min:10',
        ]);

        $bus = Bus::create([
            'plate_number' => $validated['plate_number'],
            'capacity'     => $validated['capacity'],
            // driver_id will be null by default (or column removed)
        ]);

        return redirect()->route('manager.buses')->with('success', 'Bus added successfully.');
    }

    public function updateBus(Request $request, Bus $bus)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:50|unique:buses,plate_number,' . $bus->id,
            'capacity' => 'required|integer|min:10',
        ]);

        $bus->update($validated);
        return redirect()->route('manager.buses')->with('success', 'Bus updated successfully.');
    }

    public function deleteBus(Bus $bus)
    {
        // Optional: Check conflicts (e.g. if bus has future trips)
        if ($bus->trips()->where('status', '!=', 'COMPLETED')->where('status', '!=', 'CANCELLED')->exists()) {
            return redirect()->back()->with('error', 'Cannot delete bus. It has active or scheduled trips.');
        }

        $bus->delete();
        return redirect()->route('manager.buses')->with('success', 'Bus deleted successfully.');
    }



    // -------------------------------------------------------------------
    // IV. Trips Management (CRUD)
    // -------------------------------------------------------------------

    public function viewTrips()
    {
        // Fetch trips along with route and bus details
        $trips = Trip::with(['route', 'bus'])->get();
        // Fetch routes and buses for the create form
        $routes = Route::all();
        $buses = Bus::all();
        return view('manager.trips', compact('trips', 'routes', 'buses'));
    }

    public function createTrip(Request $request)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_id' => 'required|exists:buses,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:SCHEDULED,CANCELLED', // Initial state
            'trip_date' => 'required|date',
        ]);

        // Check for time conflicts for the assigned bus
        // Logic: (StartA < EndB) and (EndA > StartB)

        $conflict = Trip::where('bus_id', $validated['bus_id'])
            ->where('trip_date', $validated['trip_date'])
            ->where(function ($query) use ($validated) {
                $query->where('start_time', '<', $validated['end_time'])
                    ->where('end_time', '>', $validated['start_time']);
            })
            ->where('status', '!=', 'CANCELLED')
            ->exists();

        if ($conflict) {
            return redirect()->back()->with('error', 'Time conflict detected. The assigned bus is busy during this period.');
        }

        Trip::create($validated);
        return redirect()->route('manager.trips')->with('success', 'Trip scheduled successfully.');
    }


    public function editTrip(Trip $trip)
    {
        $routes = Route::all();
        $buses = Bus::all();
        return view('manager.trips.edit', compact('trip', 'routes', 'buses'));
    }

    public function updateTrip(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'route_id' => 'required|exists:routes,id',
            'bus_id' => 'required|exists:buses,id',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:SCHEDULED,CANCELLED,COMPLETED,STARTED',
            'trip_date' => 'required|date',
        ]);

        // Check for time conflicts (excluding current trip)
        $conflict = Trip::where('bus_id', $validated['bus_id'])
            ->where('trip_date', $validated['trip_date'])
            ->where('id', '!=', $trip->id) // Exclude current trip
            ->where(function ($query) use ($validated) {
                $query->where('start_time', '<', $validated['end_time'])
                    ->where('end_time', '>', $validated['start_time']);
            })
            ->where('status', '!=', 'CANCELLED')
            ->exists();

        if ($conflict) {
            return redirect()->back()->with('error', 'Time conflict detected. The assigned bus is busy during this period.');
        }

        $trip->update($validated);
        return redirect()->route('manager.trips')->with('success', 'Trip updated successfully.');
    }

    public function deleteTrip(Trip $trip)
    {
        // Optional: Check for bookings
        if ($trip->bookings()->exists()) {
            // You might want to allow this but notify students, or block it.
            // Blocking for safety.
            return redirect()->back()->with('error', 'Cannot delete trip. It has active bookings.');
        }

        $trip->delete();
        return redirect()->route('manager.trips')->with('success', 'Trip deleted successfully.');
    }

    // -------------------------------------------------------------------
    // VI. Driver Management and Bus Assignment
    // -------------------------------------------------------------------

    public function viewDrivers()
    {
        // Fetch drivers (from the Driver table) along with their assigned bus
        $drivers = Driver::with(['bus', 'user'])->get(); // Eager load user too
        $availableBuses = Bus::whereNull('driver_id')->get(); // Buses not currently assigned

        return view('manager.drivers', compact('drivers', 'availableBuses'));
    }

    public function createDriver(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string|max:15',
            'driver_license_number' => 'required|string|max:50',
            'bus_id' => 'nullable|exists:buses,id',
        ]);

        // 1. Create User
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone_number' => $validated['phone_number'],
            'region_id' => 1, // Default or nullable if allowed? Assuming 1 for now or we need region input
        ]);
        $user->addRole('driver');

        // 2. Create Driver Profile
        $driver = Driver::create([
            'user_id' => $user->id,
            'driver_license_number' => $validated['driver_license_number'],
        ]);

        // 3. Assign Bus if selected
        if (!empty($validated['bus_id'])) {
            $bus = Bus::findOrFail($validated['bus_id']);
            // Double check availability
            if ($bus->driver_id !== null) {
                return redirect()->route('manager.drivers')->with('error', 'Selected bus was already assigned.');
            }
            $bus->driver_id = $driver->id;
            $bus->save();
        }

        return redirect()->route('manager.drivers')->with('success', 'Driver created successfully.');
    }


    public function editDriver(Driver $driver)
    {
        $driver->load(['user', 'bus']);
        // Get buses that are either unassigned OR assigned to THIS driver
        // Actually, 'availableBuses' are unassigned. We need to manually append current bus in the view loop effectively,
        // OR just fetch unassigned and let Blade handle the "Current" option if it exists.
        $availableBuses = Bus::whereNull('driver_id')->get();
        return view('manager.drivers.edit', compact('driver', 'availableBuses'));
    }

    public function updateDriver(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $driver->user_id,
            'phone_number' => 'required|string|max:15',
            'driver_license_number' => 'required|string|max:50',
            'bus_id' => 'nullable|exists:buses,id',
        ]);

        // 1. Update User Info
        $driver->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
        ]);

        // 2. Update Driver Info
        $driver->update([
            'driver_license_number' => $validated['driver_license_number'],
        ]);

        // 3. Handle Bus Assignment
        // First, unassign current bus if it exists and is different from new bus
        if ($driver->bus && $driver->bus->id != $request->bus_id) {
            $driver->bus->update(['driver_id' => null]);
        }

        if (!empty($validated['bus_id'])) {
            $bus = Bus::findOrFail($validated['bus_id']);
            // If selecting a new bus, ensure it's not taken (though UI filters it, backend must verify)
            if ($bus->driver_id !== null && $bus->driver_id !== $driver->id) {
                return redirect()->back()->with('error', 'Selected bus is already assigned to another driver.');
            }
            $bus->update(['driver_id' => $driver->id]);
        }

        return redirect()->route('manager.drivers')->with('success', 'Driver updated successfully.');
    }

    public function deleteDriver(Driver $driver)
    {
        // Delete the User account associated with the driver
        // This relies on DB cascading to delete the Driver record.
        // If not cascading, we should delete driver first.
        // Usually User deletion is the primary action.
        $user = $driver->user;

        // Unassign bus first to be safe
        if ($driver->bus) {
            $driver->bus->update(['driver_id' => null]);
        }

        if ($user) {
            $user->delete(); // This should cascade if set up, or we might leave orphan if not.
            // Explicitly delete driver just in case foreign key isn't cascading User->Driver
            try {
                $driver->delete();
            } catch (\Exception $e) {
                // Driver might already be deleted by cascade
            }
        } else {
            $driver->delete();
        }

        return redirect()->route('manager.drivers')->with('success', 'Driver deleted successfully.');
    }

    public function assignBusToDriver(Request $request, Driver $driver)
    {
        // Kept for backward compatibility or if using separate endpoint
        $validated = $request->validate([
            'bus_id' => 'nullable|exists:buses,id',
        ]);

        // ... (logic handled in updateDriver now, but keeping if needed) ...
        return redirect()->route('manager.drivers');
    }
}
