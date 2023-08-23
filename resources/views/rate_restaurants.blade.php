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
                    <h2 class="card-title">Rate Restaurants</h2>
                    <br>

                    <form id="rate-form" action="{{ route('rate.restaurant') }}" method="post">
                        @csrf
                        <!-- select restaurant dropdown -->
                        <div class="mb-3">
                            <label for="restaurant" class="form-label">Select Restaurant:</label>
                            <select name="restaurant" id="restaurant" class="form-select">
                                <option value="">Select a restaurant</option>
                                @foreach ($restaurants as $restaurant)
                                    <option value="{{ $restaurant->id }}">
                                        {{ $restaurant->name }} ({{ $restaurant->location }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ambience" class="form-label">Rate Ambience:</label>
                            <input type="text" name="ambience" class="form-control" min="0" max="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="service" class="form-label">Rate Service:</label>
                            <input type="text" name="service" class="form-control" min="0" max="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="pricing" class="form-label">Rate Pricing:</label>
                            <input type="text" name="pricing" class="form-control" min="0" max="5" required>
                        </div>

                        <div class="mb-3 text-center">
                            <button type="submit" class="btn btn-primary">Submit Ratings</button>
                        </div>
                    </form>
                    <div id="messages" class="mt-3 text-center"><!-- This is the container for error and success messages -->
                        @if (session('rate_success'))
                            <div class="alert alert-success">{{ session('rate_success') }}</div>
                        @endif
                        @if (session('rate_error'))
                            <div class="alert alert-danger">{{ session('rate_error') }}</div>
                        @endif
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const rateForm = document.getElementById('rate-form');
    const messagesContainer = document.getElementById('messages');

    rateForm.addEventListener('submit', async function (event) {
    event.preventDefault();

    const restaurantId = document.getElementById('restaurant').value;
    const ambience = parseFloat(document.querySelector('input[name="ambience"]').value);
    const service = parseFloat(document.querySelector('input[name="service"]').value);
    const pricing = parseFloat(document.querySelector('input[name="pricing"]').value);

    if (isNaN(ambience) || isNaN(service) || isNaN(pricing) ||
        ambience < 0 || ambience > 5 ||
        service < 0 || service > 5 ||
        pricing < 0 || pricing > 5) {
        messagesContainer.innerHTML = '<div class="alert alert-danger">Invalid ratings. Ratings can only be from 0 to 5.</div>';
        return;
    }

        try {
            const response = await fetch("{{ route('rate.restaurant') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: `restaurant=${restaurantId}&ambience=${ambience}&service=${service}&pricing=${pricing}`
            });

            if (response.ok) {
                // Store success message in localStorage
                localStorage.setItem('rate_success_message', 'Ratings submitted successfully.');
                // Reload the page after successful submission
                location.reload();
            } else {
                // Show error message
                messagesContainer.innerHTML = '<div class="alert alert-danger">There was an error submitting the ratings.</div>';
            }
        } catch (error) {
            // Show error message
            messagesContainer.innerHTML = '<div class="alert alert-danger">There was an error submitting the ratings.</div>';
        }
    });

    //uccess message after page reload
    window.onload = function() {
        const successMessage = localStorage.getItem('rate_success_message');
        if (successMessage) {
            messagesContainer.innerHTML = '<div class="alert alert-success">' + successMessage + '</div>';
            // Clear the success message
            localStorage.removeItem('rate_success_message');
        }
    };
</script>

@endsection
</body>
</html>