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
                        <h2 class="card-title">Update Restaurant</h2>
                        <br>
                        <form id="update-form" action="{{ route('update.restaurant') }}" method="post">
                            @csrf
                            <!-- select restaurant dropdown-->
                            <div class="mb-3">
                            <label for="restaurant" class="form-label">Select Restaurant:</label>
                            <select name="restaurant" id="restaurant" class="form-select">
                                <option value="">Select a restaurant</option>
                                @foreach ($restaurants as $restaurant)
                                    <option value="{{ $restaurant->id }}"{{ $selectedRestaurantId == $restaurant->id ? ' selected' : '' }}>
                                        {{ $restaurant->name }} ({{ $restaurant->location }})
                                    </option>
                                @endforeach
                            </select>
                            <br>
                            <!-- select option dropdown-->
                            <div class="mb-3">
                            <label for="update_option" class="form-label">Choose Update Options:</label>
                            <select name="update_option" id="update_option" class="form-select">
                                <option value="">Select an option</option>
                                <option value="menu">Update Menu</option>
                                <option value="offers">Update Offers</option>
                            </select>
                        </div>



                        <div id="add-dish" style="display: none;">
    <h4>Update Menu:</h4>
    <button type="button" id="add-dish-btn" class="btn btn-success">Add More Fields</button>
    <div id="dish-forms">
    </div>
</div>

<div id="add-offer" style="display: none;">
    <h4>Update Offers:</h4>
    <div class="mb-3">
        <label for="offer_description" class="form-label">Offer Description:</label>
        <input type="text" name="offer_description" class="form-control" required disabled>
    </div>
    <div class="mb-3">
        <label for="discount_percentage" class="form-label">Discount Percentage:</label>
        <input type="number" name="discount_percentage" class="form-control" required disabled>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const updateOptionSelect = document.getElementById('update_option');
        const addDishSection = document.getElementById('add-dish');
        const addDishBtn = document.getElementById('add-dish-btn');
        const updateMenuForm = document.getElementById('update-form');
        const dishForms = document.getElementById('dish-forms');
        const addOfferSection = document.getElementById('add-offer');
        const offerDescriptionInput = document.getElementsByName('offer_description')[0];
        const discountPercentageInput = document.getElementsByName('discount_percentage')[0];

        function updateMenuFormVisibility() {
            addDishSection.style.display = 'block';
            addDishBtn.style.display = 'block';
            addOfferSection.style.display = 'none';
            offerDescriptionInput.disabled = true;
            discountPercentageInput.disabled = true;
            dishForms.innerHTML = '';
        }

        function updateOfferFormVisibility() {
            addDishSection.style.display = 'none';
            addDishBtn.style.display = 'none';
            addOfferSection.style.display = 'block';
            offerDescriptionInput.disabled = false;
            discountPercentageInput.disabled = false;
            dishForms.innerHTML = '';
        }

        updateOptionSelect.addEventListener('change', function () {
            const selectedOption = this.value;
            if (selectedOption === 'menu') {
                updateMenuFormVisibility();
            } else if (selectedOption === 'offers') {
                updateOfferFormVisibility();
            } else {
                addDishSection.style.display = 'none';
                addDishBtn.style.display = 'none';
                addOfferSection.style.display = 'none';
                offerDescriptionInput.disabled = true;
                discountPercentageInput.disabled = true;
                dishForms.innerHTML = '';
            }
        });

        addDishBtn.addEventListener('click', function () {
            const newDishForm = document.createElement('div');
            newDishForm.className = 'mb-3 dish-input-group';
            newDishForm.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <label for="dish_name" class="form-label">Enter Dish Name:</label>
                        <input type="text" name="dish_name[]" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label">Enter Price:</label>
                        <input type="number" name="price[]" class="form-control" required>
                    </div>
                </div>
            `;
            dishForms.appendChild(newDishForm);
        });

        updateMenuForm.addEventListener('submit', function (event) {
        const selectedOption = updateOptionSelect.value;
        if (selectedOption === 'menu') {
            // Preventing the default form submission
            event.preventDefault();

            // Check if any dish fields have been added
            if (dishForms.children.length === 0) {
                // Show the error message
                document.getElementById('error-message').style.display = 'block';
            } else {
                // Hide the error message and submit the form
                document.getElementById('error-message').style.display = 'none';
                updateMenuForm.submit();
            }
        }
    });
    });
</script>


                        </div>           
                        <button type="submit" class="btn btn-primary">Update Restaurant</button>


      
                                              
                            <!-- Success Toast Message -->
                            @if (session('update_success'))
                                <div class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 start-50 translate-middle" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                            Restaurant updated successfully!
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
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<!-- this is an error message if no restaurant is selected. -->
@if (session('update_error'))
        <div class="alert alert-danger mt-4 text-center" style="width: fit-content; margin-left: auto; margin-right: auto;">
            {{ session('update_error') }}
        </div>
@endif
<!-- this is an error message if no dish fields are added. -->
<div id="error-message" class="alert alert-danger mt-4 text-center" style="width: fit-content; margin-left: auto; margin-right: auto; display: none;">
    Add a Dish Name and it's Price first.
</div>



</html>