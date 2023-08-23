<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>FlavorQuest - Log In</title>
    <!-- Icon -->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
    <style>
        body {
            background-image: url('{{ asset("bckgrnd.png") }}');
            background-size: cover;
            background-repeat: no-repeat;
        }

        .text-danger {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="page-wrapper p-t-180 p-b-100 font-robo">
        <div class="wrapper wrapper--w960">
            <div class="card card-2">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Start Your Quests!</h2>
                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="input-group">
                            <input class="input--style-2" type="email" placeholder="Email" name="email" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="input-group">
                            <input class="input--style-2" type="password" placeholder="Password" name="password" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        @if(session('error'))
                            <div class="text-danger">{{ session('error') }}</div>
                        @endif

                        <div class="p-t-30">
                            <button class="btn btn--radius btn--green" type="submit">Sign In</button>
                        </div>
                    </form>
                    <br>
                    <br>
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>




</body>


</html>
<!-- end document-->
