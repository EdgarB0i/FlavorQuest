<?php
namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RateRestaurantsController extends Controller
{
    public function show()
    {
        $restaurants = Restaurant::all();
        $username = Auth::user()->username;

        return view('rate_restaurants', compact('restaurants', 'username'));
    }

    public function rate(Request $request)
    {
        try {
            $restaurantId = $request->input('restaurant');
            $ambience = $request->input('ambience');
            $service = $request->input('service');
            $pricing = $request->input('pricing');
    
            if ($ambience < 0 || $ambience > 5 || $service < 0 || $service > 5 || $pricing < 0 || $pricing > 5) {
                return response()->json(['error' => 'Ratings can only be from 0 to 5.'], 400);
            }
            
    
            $username = Auth::user()->username;
    
            $rating = RestaurantRating::updateOrCreate(
                ['restaurant_id' => $restaurantId]
            );
    
            // Update average ratings and counts
            $rating->ambience = (($rating->ambience * $rating->ambience_count) + $ambience) / ($rating->ambience_count + 1);
            $rating->ambience_count += 1;
    
            $rating->service = (($rating->service * $rating->service_count) + $service) / ($rating->service_count + 1);
            $rating->service_count += 1;
    
            $rating->pricing = (($rating->pricing * $rating->pricing_count) + $pricing) / ($rating->pricing_count + 1);
            $rating->pricing_count += 1;
    
            $rating->save();
    
            return response()->json(['message' => 'Ratings submitted successfully.'], 200);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred while processing your request.'], 500);
        }
    }
    
}
