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

                .search-form {
            display: flex;
            flex-direction: column;
            max-width: 400px;
            
        }

        .search-form .form-group {
            margin-bottom: 15px;
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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-9" style="margin-top:40px">
            <div class="card">
                    <div class="card-body">
                <h2>Search Restaurants</h2><hr>
                <form action="{{ route('web.search')}}" method="GET" class="search-form">
                <div class="form-group">
                    <label for="nam">Enter Restaurant Name</label>
                    <input type="text" class="form-control" name="nam" id="nam" placeholder="Search by name">
                </div>
                <div class="form-group">
                    <label for="loc">Enter Restaurant Location</label>
                    <input type="text" class="form-control" name="loc" id="loc" placeholder="Search by location">
                </div>
                <div class="form-group">
                    <label for="men">Enter Restaurant dish name</label>
                    <input type="text" class="form-control" name="men" id="men" placeholder="Search by dish name">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
                <br>



                @if(isset($restaurants))
<table class="table table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Location</th>
        </tr>
    </thead>
    <tbody>
        @if(count($restaurants)>0)
            @foreach($restaurants as $restaurant)
                <tr>
                    <td><a href="{{ route('restaurant.details', ['name' => $restaurant->name, 'location' => $restaurant->location]) }}">{{ $restaurant->name }}</a></td>
                    <td>{{ $restaurant->location }}</td>
                </tr>
            @endforeach
        @else
            <tr><td>No result found!</td></tr>
        @endif
    </tbody>
</table>
<div class="pagination-block">
    {{ $restaurants->links('paginationlinks') }}
</div>
@elseif(isset($menu))
<table class="table table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Dish</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        @if(count($menu)>0)
            @foreach($menu as $men)
                <tr>
                    <td><a href="{{ route('restaurant.details', ['name' => $men->name, 'location' => $men->location]) }}">{{ $men->name }}</a></td>
                    <td>{{ $men->location }}</td>
                    <td>{{ $men->dish_name }}</td>
                    <td>{{ $men->price }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td>No result found!</td>
                <td></td>
            </tr>
        @endif
    </tbody>
</table>
<div class="pagination-block">
    {{ $menu->links('paginationlinks') }}
</div>
@endif


                </div>
        </div>
            </div>
        </div>
    </div>





</body>

</html>
