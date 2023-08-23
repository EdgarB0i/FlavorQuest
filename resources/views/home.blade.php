<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>FlavorQuest</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&amp;display=swap" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        /* Custom styles */
        body {
            background-image: url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            margin: 0;
            padding-top: 0; /* Remove padding for the white bar */
        }
        .navbar {
            display: none; /* Hide the navigation bar */
        }
        .masthead-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-direction: column;
        }
        .masthead-content p {
            text-align: justify;
        }
    </style>
</head>

<body>
    <!-- Include the layout -->
    @extends('layout')
    <!-- Masthead -->
    <div class="masthead">
        <div class="masthead-content text-white">
            <div class="container-fluid px-4 px-lg-0">
 
                <h1 class="fst-italic lh-1 mb-4">Welcome back on your journey with FlavorQuest,
                {{ Auth::user()->name }}!
                </h1>
                <p class="mb-5">
                    <span style="text-align: right;">Search through Restaurants and Meals based on locations, ratings, reviews, menus etc. to find the best savory options out there. Also, don't forget to share your own experiences!</span>
                </p>
            </div>
        </div>
    </div>




    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>
