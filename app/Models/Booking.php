<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'table_id', 'booking_date', 'booking_time', 
        'guests_count', 'special_requests', 'status'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime:H:i'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function menuItems()
    {
        return $this->belongsToMany(MenuItem::class, 'booking_menu_item')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function getTotalPriceAttribute()
    {
        $total = 0;
        foreach ($this->menuItems as $item) {
            $total += $item->price * $item->pivot->quantity;
        }
        return $total;
    }
}