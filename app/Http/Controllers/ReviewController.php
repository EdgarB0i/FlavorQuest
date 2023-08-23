<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class ReviewController extends Controller
{

    
    // Show the review creation form
    public function create(Restaurant $restaurant)
    {
        return view('reviews.create', ['restaurant' => $restaurant]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:signup,id',
            'restaurant_id' => 'required|exists:restaurants,id',
            'review_text' => 'required|string',
            'photo' => 'image|mimes:jpg,png|max:2048', // Image Validation
        ]);
    
        // Checking if a review already exists for the user and restaurant
        $existingReview = Review::where('user_id', $request->user_id)
            ->where('restaurant_id', $request->restaurant_id)
            ->first();
    
        // Handling photo upload and storage
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('public/photos');
            $photoPath = str_replace('public/', '', $photoPath); // Path for storage
        }
    
        if ($existingReview) {
            // Updating the existing review including the photo filepath
            $existingReview->update([
                'review_text' => $request->review_text,
                'photo' => $photoPath,
            ]);
    
            return back()->with('successUpdate', 'Review updated successfully.');
        }
    
        // Creating and storing the review if no existing review
        Review::create([
            'user_id' => $request->user_id,
            'restaurant_id' => $request->restaurant_id,
            'review_text' => $request->review_text,
            'photo' => $photoPath,
        ]);
    
        return back()->with('successAdd', 'Review added successfully.');
    }
    
    public function index(Request $request)
    {
        $restaurantName = $request->input('restaurant_name');
        $restaurantLocation = $request->input('restaurant_location');
        $username = Auth::user()->username;
    
        $restaurant = Restaurant::where('name', $restaurantName)
                                ->where('location', $restaurantLocation)
                                ->first();
    
        $reviews = [];
    
        if ($restaurant) {
            $reviews = Review::with('user') // Eager load user relationship
                ->where('restaurant_id', $restaurant->id)
                ->orderByDesc('votes') // Order by votes in descending order
                ->get();
        }
    
        return view('review', ['restaurant' => $restaurant, 'reviews' => $reviews, 'username' => $username]);
    }
    

    // Upvote a review
    public function upvote(Review $review)
    {
        $review->timestamps = false; // Disable updating the updated_at timestamp
        $review->upvoted_by = $review->upvoted_by ?? [];
        $review->downvoted_by = $review->downvoted_by ?? [];
        $review->upvoted_by = array_unique(array_merge($review->upvoted_by, [Auth::user()->id]));
        $review->downvoted_by = array_diff($review->downvoted_by, [Auth::user()->id]);
        $review->upvotes = count($review->upvoted_by);
        $review->downvotes = count($review->downvoted_by);
        $review->save();
        $review->timestamps = true; // Enable updating the updated_at timestamp
        return back();
    }

    public function downvote(Review $review)
    {
        $review->timestamps = false; // Disable updating the updated_at timestamp
        
        $review->upvoted_by = $review->upvoted_by ?? [];
        $review->downvoted_by = $review->downvoted_by ?? [];
        $review->downvoted_by = array_unique(array_merge($review->downvoted_by, [Auth::user()->id]));
        $review->upvoted_by = array_diff($review->upvoted_by, [Auth::user()->id]);
        $review->upvotes = count($review->upvoted_by);
        $review->downvotes = count($review->downvoted_by);
        $review->save();
        $review->timestamps = true; // Enable updating the updated_at timestamp
        return back();
    }


    

}
