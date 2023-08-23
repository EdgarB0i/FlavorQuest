<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class RateDishesController extends Controller
{
    public function show()
    {
        $restaurants = Restaurant::all();
        $username = Auth::user()->username;
        return view('rate_dishes', compact('restaurants','username'));
    }

    public function getMenuItems($restaurantId)
    {
        $menuItems = Menu::where('restaurant_id', $restaurantId)->get();
        return response()->json($menuItems);
    }

    public function rateDishes(Request $request)
    {
        try {
            foreach ($request->input('ratings') as $itemId => $rating) {
                $menuItem = Menu::find($itemId);
                if ($menuItem) {
                    $menuItem->average_rating = ($menuItem->average_rating * $menuItem->ratings_count + $rating) / ($menuItem->ratings_count + 1);
                    $menuItem->ratings_count += 1;
                    $menuItem->save();
                }
            }

            return redirect()->route('rate.dishes')->with('success', 'Dish ratings updated successfully.');
        } catch (\Exception $e) {
            // Log the error if needed
            return redirect()->route('rate.dishes')->with('error', 'Please select a restaurant and fill up at least one field.');
        }
    }
}
