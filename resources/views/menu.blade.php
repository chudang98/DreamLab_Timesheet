<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/menu.css')}}">
    @yield('css')
    <title>Index</title>
</head>
<body>
<header>
    <img src="{{URL::asset('images/gdc-group-logo.jpg')}}" alt="DreamLab" class="logo">
    <div class="logout">
        <a href="#">Log out <i class='fas fa-angle-right'></i> </a>
    </div>
</header>
<div class="body">
    <div class="menu">
        <ul>
            <li><a href="#"><i class='fas fa-user-circle username'></i> Username</a></li>
            <li><a href="#">Attendance logs</a></li>
            <li><a href="#">Timesheets</a></li>
        </ul>
    </div>
    <div class="content">
        @yield('content')
    </div>


</div>
</body>
</html>
