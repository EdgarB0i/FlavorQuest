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
                        <h2 class="card-title">Offer Information</h2>
                        <form action="{{ route('offer.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="restaurant_name">Restaurant Name:</label>
                                <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" required>
                            </div>
                            <div class="form-group">
                                <label for="restaurant_location">Restaurant Location:</label>
                                <input type="text" class="form-control" id="restaurant_location" name="restaurant_location" required>
                            </div>
                            <div class="form-group">
                                <label for="offer_description">Offer Description:</label>
                                <input type="text" class="form-control" id="offer_description" name="offer_description" required>
                            </div>
                            <div class="form-group"> <!-- Add this div for "Discount Percentage" -->
                                <label for="discount_percentage">Discount Percentage:</label>
                                <input type="number" step="0.01" class="form-control" id="discount_percentage" name="discount_percentage" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
