<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Menu;

class RestaurantController extends Controller
{
    public function showAddRestaurantForm()
    {
        // Here, you can get the authenticated user's username and pass it to the view
        // Assuming you have a 'username' column in your users table.
        $username = auth()->user()->username;

        return view('add-restaurant', compact('username'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'restaurant_location' => 'required|string|max:255',
            'dish_name' => 'required|array',
            'dish_name.*' => 'string|max:255',
            'dish_price' => 'required|array',
            'dish_price.*' => 'numeric',
        ]);
    
        // Get the input data
        $restaurantName = $request->input('restaurant_name');
        $restaurantLocation = $request->input('restaurant_location');
        $dishNames = $request->input('dish_name');
        $dishPrices = $request->input('dish_price');
    
        // Check if the restaurant already exists in the database
        $restaurant = Restaurant::where('name', $restaurantName)->where('location', $restaurantLocation)->first();
    
        if (!$restaurant) {
            // If the restaurant doesn't exist, create it
            $restaurant = Restaurant::create([
                'name' => $restaurantName,
                'location' => $restaurantLocation,
            ]);
        }
    
        // Loop through the dish names and prices
        foreach ($dishNames as $key => $dishName) {
            // Check if the dish already exists for this restaurant
            $menu = Menu::where('restaurant_id', $restaurant->id)->where('dish_name', $dishName)->first();
    
            if ($menu) {
                // If the dish exists, update its price
                $menu->price = $dishPrices[$key];
                $menu->save();
            } else {
                // If the dish doesn't exist, create a new menu item for it
                $newMenu = new Menu([
                    'dish_name' => $dishName,
                    'price' => $dishPrices[$key],
                    'rating' => 0, // Set the default rating to 0
                    'restaurant_id' => $restaurant->id,
                ]);
                $newMenu->save();
            }
        }
    
        return redirect()->route('restaurant.add')->with('success', 'Restaurant and menu added/updated successfully!');
    }
    
    
}