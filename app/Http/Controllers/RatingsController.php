<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\RestaurantRating;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RatingsController extends Controller
{
    public function showForm()
    {
        $username = Auth::user()->username;
        $restaurants = Restaurant::all(); // Fetch all restaurants

        return view('ratings', compact('username', 'restaurants'));
    }

    public function viewDetails($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurantRatings = RestaurantRating::where('restaurant_id', $id)->first();
        $menuRatings = Menu::where('restaurant_id', $id)->get();
        $username = Auth::user()->username;
    
        // Check if any of the ratings fields are null
        if (!$restaurantRatings || $restaurantRatings->ambience === null || $restaurantRatings->service === null || $restaurantRatings->pricing === null) {
            return redirect()->route('ratings.show')->with('errorRate', 'This restaurant hasn\'t been rated.');
        }
    
        return view('ratings_details', compact('restaurant', 'restaurantRatings', 'menuRatings', 'username'));
    }
    


    public function searchAndRedirect(Request $request)
    {
        $searchRestaurantName = $request->input('searchRestaurantName');
        $searchLocation = $request->input('searchLocation');
        
        $restaurant = Restaurant::where('name', $searchRestaurantName)->where('location', $searchLocation)->first();
    
        if ($restaurant) {
            return redirect()->route('ratings.details', ['id' => $restaurant->id]);
        }
    
        return redirect()->route('ratings.show')->with('error', 'Restaurant not found.');
    }

}
