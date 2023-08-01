<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\Menu;

class RestaurantviewController extends Controller
{
    public function showRestaurantDetails($name, $location = null)
    {
        // If $location is provided, fetch the specific restaurant at that location
        // Otherwise, fetch the first restaurant with the given name
        $restaurant = $location
            ? Restaurant::where('name', $name)->where('location', $location)->firstOrFail()
            : Restaurant::where('name', $name)->firstOrFail();

        $menuItems = Menu::where('restaurant_id', $restaurant->id)->get();

        // Get the authenticated user's username if available
        $username = Auth::check() ? Auth::user()->username : null;

        return view('restaurantview', compact('restaurant', 'menuItems', 'username'));
    }
}
