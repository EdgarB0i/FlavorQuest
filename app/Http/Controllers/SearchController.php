<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Restaurant;
use App\Models\Offer;



class SearchController extends Controller{
    function search(Request $request){
        $username = Auth::user()->username;

        if(isset($_GET['nam']) && strlen($_GET['nam'])>0){
            $search_nam=$_GET['nam'];
            $restaurants=DB::table('restaurants')
            ->select('restaurants.name as name','restaurants.location as location')
            
            ->where('name','LIKE',$search_nam.'%')
            ->paginate(5);
            $restaurants->appends($request->all());
            return view('search',['restaurants'=>$restaurants,'username'=>$username]);
        }

        elseif(isset($_GET['loc']) && strlen($_GET['loc'])>0){
            $search_loc=$_GET['loc'];
            $restaurants=DB::table('restaurants')

            ->select('restaurants.name as name','restaurants.location as location')
            
            ->where('location','LIKE',$search_loc.'%')
            ->paginate(5);
            $restaurants->appends($request->all());
            return view('search',['restaurants'=>$restaurants,'username'=>$username]);
        }

        elseif(isset($_GET['men']) && strlen($_GET['men'])>0){
            $search_men=$_GET['men'];
            $menu=DB::table('menu')
            ->join('restaurants','restaurants.id','=','menu.restaurant_id')
            ->select('restaurants.name as name','restaurants.location as location','menu.dish_name as dish_name','menu.price as price')
            ->where('dish_name','LIKE',$search_men.'%')
            ->paginate(5);
            $menu->appends($request->all());
            return view('search',['menu'=>$menu,'username'=>$username]);
        }
        
        else{
            return view('search',compact('username'));
        }
    }

    public function showDetails($name, $location = null)
    {
        // Retrieve the restaurant details based on name and location
        $restaurant = Restaurant::where('name', $name)
            ->where('location', $location)
            ->first();

        // You can pass the $restaurant data to a view and display it
        return view('restaurant.details', ['restaurant' => $restaurant]);
    }
        
}