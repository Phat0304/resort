<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = "bookings";
    protected $primaryKey = "id";
    protected $guarded = [];

    protected $fillable = ['order_number'];

    protected static function booted()
    {
        static::creating(function ($book) {
            $latestBook = static::latest('id')->first();
            if ($latestBook) {
                $bookNumber = 'BK-' . str_pad((int) substr($latestBook->booking_number, 3) + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $bookNumber = 'BK-0001';
            }
            $book->booking_number = $bookNumber;
        });
    }

}
