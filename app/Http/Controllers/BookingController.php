<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Table;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = Auth::user()->bookings()->with('table')->orderBy('booking_date', 'desc')->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $tables = Table::where('is_active', true)->get();
        $menuItems = MenuItem::where('is_available', true)->get();
        $times = $this->getAvailableTimes();
        
        return view('bookings.create', compact('tables', 'menuItems', 'times'));
    }

    public function store(Request $request)
    {
        $messages = [
            'table_id.required' => 'Выберите столик',
            'table_id.exists' => 'Выбранный столик не существует',
            'booking_date.required' => 'Укажите дату бронирования',
            'booking_date.date' => 'Неверный формат даты',
            'booking_date.after_or_equal' => 'Дата бронирования не может быть раньше сегодняшнего дня',
            'booking_time.required' => 'Укажите время бронирования',
            'guests_count.required' => 'Укажите количество гостей',
            'guests_count.integer' => 'Количество гостей должно быть числом',
            'guests_count.min' => 'Количество гостей должно быть не менее 1',
            'menu_items.array' => 'Неверный формат меню',
            'menu_items.*.exists' => 'Выбранное блюдо не существует'
        ];

        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'guests_count' => 'required|integer|min:1',
            'menu_items' => 'array',
            'menu_items.*' => 'exists:menu_items,id'
        ], $messages);

        $table = Table::findOrFail($request->table_id);

        if (!$table->isAvailable($request->booking_date, $request->booking_time, $request->guests_count)) {
            return back()->with('error', 'Этот столик уже забронирован на выбранное время');
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'table_id' => $request->table_id,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'guests_count' => $request->guests_count,
            'special_requests' => $request->special_requests,
            'status' => 'pending'
        ]);

        if ($request->has('menu_items')) {
            $itemsWithQuantities = [];
            foreach ($request->menu_items as $itemId) {
                $itemsWithQuantities[$itemId] = ['quantity' => 1];
            }
            $booking->menuItems()->attach($itemsWithQuantities);
        }

        return redirect()->route('bookings.index')->with('success', 'Столик успешно забронирован! Ожидайте подтверждения администратора.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Бронирование отменено');
    }

    private function getAvailableTimes()
    {
        $times = [];
        for ($hour = 12; $hour <= 23; $hour++) {
            $times[] = sprintf('%02d:00', $hour);
            if ($hour < 23) {
                $times[] = sprintf('%02d:30', $hour);
            }
        }
        return $times;
    }
}