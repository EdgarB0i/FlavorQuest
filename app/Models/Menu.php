<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu'; // Specify the custom table name

    protected $fillable = [
        'dish_name',
        'price',
        'rating',
        'restaurant_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
