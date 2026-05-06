<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'seats', 'is_active'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable($date, $time, $guests)
    {
        if (!$this->is_active || $this->seats < $guests) {
            return false;
        }

        $existingBooking = $this->bookings()
            ->where('booking_date', $date)
            ->where('booking_time', $time)
            ->where('status', '!=', 'cancelled')
            ->first();

        return !$existingBooking;
    }
}