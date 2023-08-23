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
    .container {
        max-width: 1100px; /* container width */
        margin: 0 auto; 
    }
</style>

</head>
<body>
@extends('layout')
@section('content')
<div class="container">
    @isset($restaurant)
        
        <div class="card mt-3">
            <div class="card-body">
                <h2 class="mt-4 text-center">{{ $restaurant->name }}</h2>
                <h4>Restaurant Ratings</h4>
                <!-- Display restaurant ratings if available -->
                @isset($restaurantRatings)
                    <p><strong>Ambience Rating:</strong> {{ $restaurantRatings->ambience }} out of 5</p>
                    <p><strong>Service Rating:</strong> {{ $restaurantRatings->service }} out of 5</p>
                    <p><strong>Pricing Rating:</strong> {{ $restaurantRatings->pricing }} out of 5</p>
                    <p><strong>Overall Rating:</strong>
                        {{ number_format(($restaurantRatings->ambience + $restaurantRatings->service + $restaurantRatings->pricing) / 3, 2) }} out of 5
                    </p>
                    <canvas id="ratingsHistogram" width="400" height="200"></canvas>
                @else
                    <p>No restaurant ratings available.</p>
                @endisset
            </div>
        </div>
        <!-- Display menu ratings if available -->
        @isset($menuRatings)
            <div class="card mt-3">
                <div class="card-body">
                    <h4>Menu Ratings</h4>
                    <ul>
                        @foreach($menuRatings as $menuItem)
                            <li><strong>{{ $menuItem->dish_name }} Rating:</strong> {{ $menuItem->average_rating }} out of 5</li>
                        @endforeach
                    </ul>
                </div>
                <canvas id="menuRatingsHistogram" width="400" height="200"></canvas>
            </div>
        @else
            <p>No menu ratings available.</p>
        @endisset
    @else
        @isset($error)
            <div class="card mt-4">
                <div class="card-body">
                    <p>{{ $error }}</p>
                </div>
            </div>
        @endisset
    @endif
</div>

<!-- Include your histogram scripts here -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
const restaurantRatings = {
    ambience: {{ $restaurantRatings->ambience }},
    service: {{ $restaurantRatings->service }},
    pricing: {{ $restaurantRatings->pricing }}
};

document.addEventListener("DOMContentLoaded", function () {
    const ratingsHistogram = document.getElementById('ratingsHistogram').getContext('2d');
    
    new Chart(ratingsHistogram, {
        type: 'bar',
        data: {
            labels: ['Ambience', 'Service', 'Pricing'],
            datasets: [{
                label: 'Restaurant Ratings',
                data: [restaurantRatings.ambience, restaurantRatings.service, restaurantRatings.pricing],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Create a histogram for menu ratings
    const menuRatingsData = @json($menuRatings);
    const menuRatingsHistogram = document.getElementById('menuRatingsHistogram').getContext('2d');

    const menuLabels = menuRatingsData.map(item => item.dish_name);
    const menuRatings = menuRatingsData.map(item => item.average_rating);

    new Chart(menuRatingsHistogram, {
        type: 'bar',
        data: {
            labels: menuLabels,
            datasets: [{
                label: 'Menu Ratings',
                data: menuRatings,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});




</script>
</body>
</html>