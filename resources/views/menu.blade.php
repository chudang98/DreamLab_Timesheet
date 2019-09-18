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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/menu.css')}}">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    @yield('css')
    <title>Index</title>
</head>
<body>
<header>
    <img src="{{URL::asset('images/gdc-group-logo.jpg')}}" alt="DreamLab" class="logo">
    <div class="logout">
        <a href="#">Đăng xuất <i class='fas fa-angle-right'></i> </a>
    </div>
</header>
<div class="body">
    <div class="menu">
        <ul>
            <li><a href="/editProfile/{{auth()->user()->name}}"><i class='fas fa-user-circle username'></i>{{auth()->user()->name}}</a></li>
            <li><a href="#">Lịch làm việc</a></li>
            <li><a href="/listAttendances">Điểm danh</a></li>
            <li><a href="#">Chấm công</a></li>
        </ul>
    </div>
    <div class="content">
        @yield('content')
    </div>


</div>
</body>
</html>
