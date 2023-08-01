<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'discount_percentage', 'restaurant_id'];

    // Define the relationship between Offer and Restaurant
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
