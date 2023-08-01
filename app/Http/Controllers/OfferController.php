<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Offer;

class OfferController extends Controller
{
    public function showAddOfferForm()
    {
        // Here, you can get the authenticated user's username and pass it to the view
        // Assuming you have a 'username' column in your users table.
        $username = auth()->user()->username;

        return view('add-offer', compact('username'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'restaurant_location' => 'required|string|max:255',
            'offer_description' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric',
        ]);
    
        // Check if the restaurant exists in the database based on name and location
        $restaurant = Restaurant::where('name', $request->input('restaurant_name'))
            ->where('location', $request->input('restaurant_location'))
            ->first();
    
        if (!$restaurant) {
            // Restaurant doesn't exist, create a new one
            $restaurant = Restaurant::create([
                'name' => $request->input('restaurant_name'),
                'location' => $request->input('restaurant_location'),
            ]);
        }
    
        // Find the offer for the restaurant based on description
        $offer = Offer::where('restaurant_id', $restaurant->id)
            ->where('description', $request->input('offer_description'))
            ->first();
    
        if ($offer) {
            // Offer already exists, update the discount percentage
            $offer->update([
                'discount_percentage' => $request->input('discount_percentage'),
            ]);
        } else {
            // Offer doesn't exist, create a new one
            $offer = new Offer([
                'description' => $request->input('offer_description'),
                'discount_percentage' => $request->input('discount_percentage'),
                'restaurant_id' => $restaurant->id,
            ]);
            $offer->save();
        }
    
        return redirect()->route('offer.add')->with('success', 'Offer added/updated successfully!');
    }
    
}