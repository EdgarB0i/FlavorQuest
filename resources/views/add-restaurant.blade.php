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
                        <h2 class="card-title">Restaurant Information</h2>
                        <form action="{{ route('restaurant.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="restaurant_name">Restaurant Name:</label>
                                <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" required>
                            </div>
                            <div class="form-group"> <!-- Add this div for "Restaurant Location" -->
                                <label for="restaurant_location">Restaurant Location:</label>
                                <input type="text" class="form-control" id="restaurant_location" name="restaurant_location" required>
                            </div>
                            <div id="dish_fields">
                                <!-- The dynamic dish fields will be added here -->
                            </div>
                            <div>
                                <br>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-success" onclick="addDishField()">Add Dish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ... (your script section code) ... -->
    <script>
        function addDishField() {
            const dishFields = document.getElementById('dish_fields');
            const dishCount = dishFields.querySelectorAll('.dish-input-group').length + 1;

            const newDishField = `
                <div class="dish-input-group">
                    <div>
                        <label for="dish_name${dishCount}">${dishCount})Enter Dish Name:</label>
                        <input type="text" class="form-control" id="dish_name${dishCount}" name="dish_name[]" required>
                    </div>
                    <div>
                        <label for="dish_price${dishCount}">${dishCount})Enter Price:</label>
                        <input type="number" step="0.01" class="form-control" id="dish_price${dishCount}" name="dish_price[]" required>
                    </div>
                </div>
            `;

            const dishGroup = document.createElement('div');
            dishGroup.classList.add('mb-3');
            dishGroup.innerHTML = newDishField;

            dishFields.appendChild(dishGroup);
        }
    </script>
</body>

</html>
