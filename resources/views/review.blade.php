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
            max-width: 100000px; /* Adjust this value to your desired maximum width */
            margin: 0 auto; /* Center the container horizontally */
            padding: 10px;
        }
    </style>
<style>
    .review-container {
        display: grid;
        grid-template-columns: 1fr; /* Change this line */
        gap: -300px;
    }

    .review-card {
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
        background-color: #fff;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px; /* Add margin between cards */
    }

    .review-card-header {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .review-card-body {
        font-size: 14px;
    }
    .edited-text {
    font-weight: normal; 
    color: gray;
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
                    <h2 class="card-title">Restaurant Reviews</h2>

                    <form action="{{ route('reviews.index') }}" method="get">
                        @csrf
                        <div class="mb-3 d-flex align-items-start">
                            <label for="restaurant_name" class="form-label me-2">Restaurant Name:&#160&#160&#160&#160</label>
                            <input type="text" name="restaurant_name" id="restaurant_name" class="form-control form-control-sm" style="width: 50%;" required>
                        </div>
                        <div class="mb-3 d-flex align-items-start">
                            <label for="restaurant_location" class="form-label me-2">Restaurant Location:</label>
                            <input type="text" name="restaurant_location" id="restaurant_location" class="form-control form-control-sm" style="width: 50%;" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Search Reviews</button>
                    </form>

                    @if ($restaurant)
                        <h3 class="mt-4">Reviews for {{ $restaurant->name }} - {{ $restaurant->location }}</h3>
                        @if ($reviews->count() > 0)
                            <div class="review-container">
                            @foreach ($reviews as $review)
                            <div class="review-card">
                                <div class="review-card-header">
                                    <strong>{{ $review->user->name }}</strong>
                                    @if ($review->user_id === Auth::user()->id && $review->updated_at != $review->created_at)
                                        <span class="edited-text">(edited)</span>
                                    @endif

                                </div>
                                <div class="review-card-body">
                                    @if ($review->photo)
                                        <img src="{{ asset('storage/' . $review->photo) }}" alt="Review Photo" width="30%" height="30%">
                                    @endif
                                    <p>{{ $review->review_text }}</p>
                                </div>
                                <div class="review-votes">
                                    <div style="display: inline-block; text-align: center;">
                                        <form action="{{ route('reviews.upvote', $review) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-link">
                                                <img src="{{ asset('icons/Upvote.png') }}" alt="Upvote" class="vote-icon" data-review-id="{{ $review->id }}">
                                            </button>
                                        </form>
                                        <div class="votes-count" style="font-size: 12px;">
                                            {{ $review->upvotes }}
                                        </div>
                                    </div>
                                    
                                    <div style="display: inline-block; text-align: center;">
                                        <form action="{{ route('reviews.downvote', $review) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-link">
                                                <img src="{{ asset('icons/Downvote.png') }}" alt="Downvote" class="vote-icon" data-review-id="{{ $review->id }}">
                                            </button>
                                        </form>
                                        <div class="votes-count" style="font-size: 12px;">
                                            {{ $review->downvotes }}
                                        </div>
                                    </div>
                                </div>

                            </div>




                                @endforeach
                            </div>
                        @else
                            <p>No reviews available for this restaurant.</p>
                        @endif
                    @endif

                    @if ($restaurant)
                        <div class="mb-3">
                            <button id="addReviewButton" class="btn btn-success">Add Review</button>
                        </div>

                        <div class="add-review-options" style="display: none;">
                            <form action="{{ route('reviews.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                @if ($restaurant)
                                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                                @endif
                                <div class="mb-3">
                                    <label for="review_text">Review:</label>
                                    <textarea name="review_text" id="review_text" class="form-control" rows="4" required>{{ old('review_text') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="photo">Upload Photo (jpg or png only):</label>
                                    <input type="file" name="photo" id="photo" class="form-control" accept=".jpg, .png">
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-danger">Submit Review</button>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addReviewButton = document.getElementById('addReviewButton');
        const addReviewOptions = document.querySelector('.add-review-options');

        addReviewButton.addEventListener('click', () => {
            addReviewOptions.style.display = addReviewOptions.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>


                                <!-- Success Toast Message -->
                                @if (session('successAdd'))
                                <div class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 start-50 translate-middle" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                        Review added successfully!
                                        </div>
                                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                                <!-- Success Toast Message -->
                                @if (session('successUpdate'))
                                <div class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 start-50 translate-middle" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                        Review updated successfully!
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