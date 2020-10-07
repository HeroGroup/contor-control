<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کنتور برق</title>
    <link rel=stylesheet href="css/bootstrap.min.css">
    <link rel=stylesheet href="css/rtlbootstrap.min.css">
    <link rel="stylesheet" href="samim-font-master/dist/Farsi-Digits/Samim-Bold-FD.ttf">
    <style>
        li a {
            color: #A60500;
        }

        li a:hover {
            color: #ffca00;
            /* background-color: #; */
        }
    </style>

    <script src="./js/jquery-3.4.1.min.js"></script>
    <script src="./js/sweetalert.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</head>



<body dir="rtl">

    <nav class="navbar navbar-expand-lg navbar-light" style=" background: linear-gradient(177deg, #0c3d78 20%, #ddc454 80%);">
        <a class="navbar-brand" href="#" style="font-weight: bold;">کنترل برق</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="{{route('client.login')}}" style="font-weight: bold;font-size: large;color: rgb(46, 46, 207);">ورود</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('client.home')}}" style="font-weight: bold;font-size: large;color: rgb(46, 46, 207);">صفحه اصلی</a></li>
            </ul>
        </div>
    </nav>
    <div class="container-index" style="background-image: url('image/bulbs.jpg');">
        <div class="container">

            <!--    -->


        </div>
    </div>

    <script>
        swal("خدانگهدار", "برای خروج کلیک نمایید!", "warning");
    </script>


</body>

</html>
