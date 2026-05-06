<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Table;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()?->isAdmin()) abort(403, 'Доступ запрещен');
            return $next($request);
        });
    }

    
    public function tables()
    {
        return view('admin.tables', ['tables' => Table::all()]);
    }

    public function storeTable(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:50', 'seats' => 'required|integer|min:1']);
        Table::create($data);
        return back()->with('success', 'Столик добавлен');
    }

    public function updateTable(Request $request, Table $table)
    {
        $data = $request->validate(['name' => 'required|string|max:50', 'seats' => 'required|integer|min:1']);
        $table->update($data);
        return back()->with('success', 'Столик обновлен');
    }

    public function deleteTable(Table $table)
    {
        $table->delete();
        return back()->with('success', 'Столик удален');
    }

    
    public function menu()
    {
        return view('admin.menu', ['menuItems' => MenuItem::all()]);
    }

    public function storeMenuItem(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string'
        ]);
        MenuItem::create($data);
        return back()->with('success', 'Блюдо добавлено');
    }

    public function updateMenuItem(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string'
        ]);
        $menuItem->update($data);
        return back()->with('success', 'Блюдо обновлено');
    }

    public function deleteMenuItem(MenuItem $menuItem)
    {
        $menuItem->delete();
        return back()->with('success', 'Блюдо удалено');
    }

    
    public function allBookings(Request $request)
    {
        $sort = in_array($request->sort, ['id', 'booking_date', 'booking_time', 'guests_count', 'status']) 
            ? $request->sort : 'created_at';
        $order = in_array($request->order, ['asc', 'desc']) ? $request->order : 'desc';
        $statusFilter = $request->status ?? 'all';

        $query = Booking::with(['user', 'table']);
        if ($statusFilter !== 'all') $query->where('status', $statusFilter);
        
        $bookings = $query->orderBy($sort, $order)->get();
        
        $stats = [
            'all' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];
        
        return view('admin.bookings', compact('bookings', 'sort', 'order', 'statusFilter', 'stats'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,cancelled']);
        $booking->update(['status' => $request->status]);
        return back()->with('success', 'Статус обновлен');
    }
}