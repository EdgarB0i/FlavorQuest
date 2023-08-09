<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Menu; 
use App\Models\Offer; 
use Illuminate\Support\Facades\Auth;

class UpdateRestaurantController extends Controller
{
    public function showUpdateForm()
    {
        $restaurants = Restaurant::all();
        $selectedRestaurantId = request()->input('restaurant');
        $selectedLocation = request()->input('location');
        $username = Auth::user()->username;

        // Fetch the locations based on the selected restaurant
        if ($selectedRestaurantId) {
            $restaurant = Restaurant::find($selectedRestaurantId);
            $locations = [$restaurant->location];
        } else {
            $locations = Restaurant::pluck('location')->unique();
        }

        return view('update', compact('restaurants', 'selectedRestaurantId', 'locations', 'selectedLocation', 'username'));
    }

    public function updateRestaurant(Request $request)
    {
        $selectedRestaurantId = $request->input('restaurant');
        $updateOption = $request->input('update_option');

        if (!$selectedRestaurantId) {
            return redirect()->route('update.form')
                ->with('update_error', 'Please select a restaurant.');
        }
    
        if ($updateOption === 'menu') {
            // Handle menu update
            $dishNames = $request->input('dish_name');
            $prices = $request->input('price');
    
            // Validate that both dish names and prices are present
            if (count($dishNames) !== count($prices)) {
                return redirect()->route('update.form')
                    ->with('update_error', 'Please provide valid dish names and prices.');
            }
    
            // Loop through dish names and prices
            foreach ($dishNames as $index => $dishName) {
                $price = $prices[$index];
    
                // Find or create the menu item based on dish name and restaurant ID
                Menu::updateOrCreate(
                    ['restaurant_id' => $selectedRestaurantId, 'dish_name' => $dishName],
                    ['price' => $price, 'rating' => 0]
                );
            }
    
            // Set a session variable for successful update
            session()->flash('update_success', true);
        } elseif ($updateOption === 'offers') {
            // Handle offers update
            $offerDescription = $request->input('offer_description');
            $discountPercentage = $request->input('discount_percentage');
    
            // Find or create the offer based on description and restaurant ID
            Offer::updateOrCreate(
                ['restaurant_id' => $selectedRestaurantId, 'description' => $offerDescription],
                ['discount_percentage' => $discountPercentage]
            );
    
            // Set a session variable for successful update
            session()->flash('update_success', true);
        } else {
            // If no option is selected, redirect back with an error message
            return redirect()->route('update.form')
                ->with('update_error', 'Please select an update option.');
        }
    
        // Redirect back to the update form
        return redirect()->route('update.form');
    }
    
    
    
    
}