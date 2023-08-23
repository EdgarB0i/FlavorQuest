<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'restaurant_id', 'review_text', 'photo','votes',
        'upvotes', 'downvotes', 'upvoted_by', 'downvoted_by'
    ];

    protected $casts = [
        'upvoted_by' => 'array',
        'downvoted_by' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function updateVotes()
    {
        $this->votes = $this->upvotes - $this->downvotes;
        $this->save();
    }

    protected static function booted()
    {
        static::saving(function ($review) {
            $review->votes = $review->upvotes - $review->downvotes;
        });
    }
    
}




