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
            padding-top: 50px; 
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

        /* Additional styles */
        .dish-input-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .dish-input-group label {
            flex-basis: 100%;
        }
        .dish-input-group input {
            flex-basis: 100%;
        }
    </style>
</head>

<body>
@extends('layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Rate Dishes</h2>
                    <!-- Dropdown menu to select a restaurant -->
                    <select id="restaurant-dropdown" class="form-select">
                        <option value="">Select a restaurant</option>
                        @foreach ($restaurants as $restaurant)
                            <option value="{{ $restaurant->id }}">{{ $restaurant->name }} ({{ $restaurant->location }})</option>
                        @endforeach
                    </select>
                    <br>
                    <!-- Form for submitting dish ratings -->
                    <form id="rate-form" action="{{ route('rate.dishes.submit') }}" method="post">
                        @csrf
                        <!-- Placeholder for displaying menu items and ratings -->
                        <div id="menu-items"></div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Submit Ratings</button>
                        </div>
                    </form>
                    @if (session('success'))
                            <div class="alert alert-success mt-4 text-center" style="width: fit-content; margin-left: auto; margin-right: auto;">
                                {{ session('success') }}
                            </div>
                    @endif
                    @if (session('error'))
                            <div class="alert alert-danger mt-4 text-center" style="width: fit-content; margin-left: auto; margin-right: auto;">
                                {{ session('error') }}
                            </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const restaurantDropdown = document.getElementById('restaurant-dropdown');
        const menuItemsContainer = document.getElementById('menu-items');

        restaurantDropdown.addEventListener('change', async function () {
            const restaurantId = restaurantDropdown.value;

            if (restaurantId) {
                // Fetch menu items for the selected restaurant
                const response = await fetch(`/get-menu-items/${restaurantId}`);
                const menuItems = await response.json();

                // Generate HTML for menu items and input fields
                let menuHtml = '';
                menuItems.forEach(item => {
                    menuHtml += `
                        <div class="dish-input-group">
                            <label>${item.dish_name}</label>
                            <input type="text" class="form-control dish-rating-input" name="ratings[${item.id}]" 
                                   data-validation="number range[0;5]" value="">
                        </div>`;
                });

                menuItemsContainer.innerHTML = menuHtml;
            } else {
                menuItemsContainer.innerHTML = ''; // Clear menu items
            }
        });
    });

    document.getElementById('rate-form').addEventListener('submit', function (event) {
        const ratingInputs = document.querySelectorAll('.dish-rating-input');

        for (const input of ratingInputs) {
            if (input.value !== '') {
                if (!validateInput(input)) {
                    event.preventDefault();
                    return;
                }
            } else {
                input.removeAttribute('name'); // Ignore null entries
            }
        }
    });

    function validateInput(input) {
        const parsedValue = parseFloat(input.value);
        return !isNaN(parsedValue) && parsedValue >= 0 && parsedValue <= 5;
    }
</script>
@endsection

</body>
</html>