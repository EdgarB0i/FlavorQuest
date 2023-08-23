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
        max-width: 6000px; /* Adjust this value to your desired maximum width */
        margin: 0 auto; /* Center the container horizontally */
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
                    <h2 class="card-title">View Ratings</h2>
                    <form action="{{ route('ratings.viewDetails') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="searchRestaurantName" class="form-label">Enter Restaurant Name</label>
                            <input type="text" class="form-control" id="searchRestaurantName" name="searchRestaurantName" required>
                        </div>
                        <div class="mb-3">
                            <label for="searchLocation" class="form-label">Enter Location</label>
                            <input type="text" class="form-control" id="searchLocation" name="searchLocation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Search Restaurant</button>
                        <a href="{{ route('rate.restaurants') }}" class="btn btn-danger mx-2">Rate Restaurants</a>
                        <a href="{{ route('rate.dishes') }}" class="btn btn-danger mx-0">Rate Dishes</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4>Restaurant List</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Detailed Ratings</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loop through the restaurants and display the data -->
                            @foreach($restaurants as $restaurant)
                                <tr>
                                    <td>{{ $restaurant->name }}</td>
                                    <td>{{ $restaurant->location }}</td>
                                    <td>
                                        <a href="{{ route('ratings.details', ['id' => $restaurant->id]) }}" class="btn btn-primary">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
                                <!-- Error Toast Message -->
                                @if (session('error'))
                                <div class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 start-50 translate-middle" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                        Restaurant not found.
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif

                                <!-- Error Toast Message -->
                                @if (session('errorRate'))
                                <div class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 start-50 translate-middle" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                        Detailed ratings for this restaurant doesn't exist.
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    // Get the toast element
                                    const toastEl = document.querySelector('.toast');

                                    // Show the toast if it exists
                                    if (toastEl) {
                                        const bsToast = new bootstrap.Toast(toastEl);
                                        bsToast.show();
                                    }
                                });
                            </script>                            

</body>

</html>