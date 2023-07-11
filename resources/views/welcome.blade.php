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
        .login-button,
        .signup-button {
            display: inline-block;
            padding: 10px 20px;
            margin-right: 10px;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            background-color: #c3e6cb;
            color: #333;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .login-button:hover,
        .signup-button:hover {
            background-color: #b1dfb1;
        }
    </style>
</head>
<body>
    <!-- Masthead-->
    <div class="masthead">
        <div class="masthead-content text-white">
            <div class="container-fluid px-4 px-lg-0">
                <h1 class="fst-italic lh-1 mb-4">Welcome to FlavorQuest!</h1>
                <p class="mb-5">
                    <span style="text-align: left;">Discover the finest flavors in town!</span>
                    <br />
                    <span style="text-align: right;">FlavorQuest connects you with the best-rated eateries that serve your favorite dishes, ensuring an unforgettable culinary journey to relinquish your hunger.</span>
                </p>
                <div>
                    <a href="{{ route('login.form') }}" class="login-button">Sign In</a>
                    <a href="{{ route('signup.form') }}" class="signup-button">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>
