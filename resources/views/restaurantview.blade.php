<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        /* Custom styles */
        body {
            background-image: url('{{ asset("bckgrnd.png") }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            margin: 0;
            padding-top: 50px; /* Add padding for the fixed navbar */
        }
        .navbar {
            background-color: white;
            height: 50px;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            display: flex;
            justify-content: center;
        }
        .navbar-links {
            display: flex;
            align-items: center;
        }
        .navbar-links a {
            color: black;
            text-decoration: none;
            margin-left: 20px;
        }
        .navbar-links a:hover {
            text-decoration: underline;
        }
        .card {
            margin-top: 50px;
            background-color: rgba(255, 255, 255, 0.9);
        }
        .card-title {
            text-align: center;
        }
        /* Increase font size for menu items */
        .menu-item {
            font-size: 18px;
            display: flex;
            justify-content: space-between;
        }
        .menu-item-name {
            font-weight: bold;
        }
        .menu-item-price {
            font-weight: bold;
        }
        .menu-item-rating {
            font-size: 12px;
        }
        .must-haves {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    @extends('layout')
    <!-- Navigation Bar/Header -->
    <nav class="navbar">
        <div class="navbar-links">
            <!-- ... (your navigation links) ... -->
        </div>
    </nav>

    <!-- Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Restaurant Details</h2>
                        <br>
                        <h3>Restaurant Name: {{ $restaurant->name }}</h3>
                        @if ($restaurant->location)
                            <h5>Location: {{ $restaurant->location }}</h5>
                        @endif
                        <br>
                        <h3>Menu Items</h3>
                        <ul>
                            @foreach ($menuItems as $menuItem)
                                <li class="menu-item">
                                    <span class="menu-item-name">{{ $menuItem->dish_name }}</span>
                                    <span class="menu-item-price">TK{{ $menuItem->price }}</span>      
                                </li>
                                <span class="menu-item-rating">Rating: {{ $menuItem->average_rating }}</span>
                            @endforeach
                        </ul>

                        <!-- Must Haves -->
                        @php
                            $mustHaves = $menuItems->filter(function ($item) {
                                return $item->rating >= 4;
                            });
                        @endphp

                        @if ($mustHaves->isNotEmpty())
                            <div class="must-haves">
                                <h3>Must Haves</h3>
                                <ul>
                                    @foreach ($mustHaves as $mustHaveItem)
                                        <li class="menu-item">
                                            <span class="menu-item-name">{{ $mustHaveItem->dish_name }}</span>
                                            <span class="menu-item-price">TK{{ $mustHaveItem->price }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Available Offers -->
                        @php
                            $offers = \App\Models\Offer::where('restaurant_id', $restaurant->id)->get();
                        @endphp

                        @if ($offers->isNotEmpty())
                            <div class="available-offers">
                                <h3>Available Offers</h3>
                                <ul>
                                    @foreach ($offers as $offer)
                                        <h5 style="color: red;">{{ $offer->description }} {{ $offer->discount_percentage }}% off!</h5>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>