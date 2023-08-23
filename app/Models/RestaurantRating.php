<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantRating extends Model
{
    protected $table = 'restaurant_ratings';

    protected $fillable = ['restaurant_id', 'ambience', 'service', 'pricing','ambience_count','service_count','pricing_count'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
