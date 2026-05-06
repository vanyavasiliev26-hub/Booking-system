<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'category', 'is_available'];

    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_menu_item')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}