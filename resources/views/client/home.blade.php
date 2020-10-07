<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>کنتور برق</title>
    <link rel="stylesheet" href="/css/rtl/bootstrap.min.css">
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/sweetalert.min.css">



    <style>
        li a {
            color: #A60500;
        }

        li a:hover {
            color: #ffca00;
            /* background-color: #; */
        }

        .menu-item {
            font-weight: bold;font-size: large;color: rgb(46, 46, 207);
        }

        lbl {
            font-size: 20px;font-weight: 600;color: white;
        }
    </style>

    <script src="/js/jquery-1.11.0.min.js"></script>
    <script src="/js/sweetalert.min.js"></script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
</head>



<body dir="rtl">

    <nav class="navbar navbar-expand-lg navbar-light" style=" background: linear-gradient(177deg, #0c3d78 20%, #ddc454 80%);">
        <a class="navbar-brand" href="#" style="font-weight: bold;">کنترل برق</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link menu-item" href="/login">ورود</a></li>
                <li class="nav-item"><a class="nav-link menu-item" href="#">صفحه اصلی</a></li>
                <li class="nav-item"><a class="nav-link menu-item" href="#">خروج</a></li>
            </ul>
        </div>
    </nav>
    <div class="container-index" style="background-image: url('/image/bulbs.jpg');">
        <div class="container">

            <!--    -->
            <div style="margin-left: auto;  margin-right: auto; margin-top: 80px;" class="card col-md-8 col-sm-10">
                <h5 class="card-header">انتخاب کنتور <button style="margin-top:5px;" class="btn btn-primary btn-xs float-right" onclick="refresh()">
                    <i class="fa fa-refresh" aria-hidden="true"></i>بروزرسانی</button></h5>
                <div class="card-body" style="font-weight: bold;">
                    <form method="POST" action="#">
                        <select class="form-control" style="font-weight: bold;">
                        <option id="1" value="60000001">درگاه 60000001</option>
                        </select>
                        <select id="mySelect" style="margin-top: 20px;font-weight: bold;" class="form-control" onchange="myFunction()">
                        <option id="1" value="1">61000001</option>
                        <option id="2" value="2">61000002</option>
                        </select>
                    </form>
                </div>
                <div class="form-group row d-flex justify-content-center">
                    <label style="font-weight: bold;">روشن </label>

                    <label class="switch" style="margin-left:7px;margin-right:7px;">
                    <input id="x" type="checkbox" onchange="changeStatus()">
                    <span class="slider"></span>
                    </label>
                    <label style="font-weight: bold;">خاموش </label>
                </div>
            </div>
            <div style="display: table; margin-top: 20px;margin-left: auto;justify-content: center ; margin-right: auto;padding: 4px;">
                <label class="lbl" id="lbL1"></label>
                <br>
                <label class="lbl" id="lbL2"></label>
                <br>
                <label class="lbl" id="lbL3"></label>
                <br>
                <label class="lbl" id="lbL4"></label>
                <br>
                <label class="lbl" id="lbL6"></label>
                <br>
                <label class="lbl" id="lbL7"></label>
                <br>
                <label class="lbl" id="lbL8"></label>
                <br>
                <label class="lbl" id="lbL9"></label>
                <br>
                <label class="lbl" id="lbL10"></label>
                <br>
                <label class="lbl" id="lbL11"></label>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(myFunction());


        function myFunction() {

            AnimateRotate(360);

            var x = document.getElementById("mySelect").value;

            jQuery.ajax({
                url: "http://ami.itmc.ir/api/getLatestElectricalMeterConfig/" + x,
                type: "GET",
                success: function(response) {
                    if (response.status === 1) {
                        console.log(response);
                        $("#x").prop("checked", response.data.relay1_status == 1);
                    } else {
                        alert('خطایی رخ داده است.');
                    };
                    document.getElementById("lbL1").innerHTML = "تاریخ: " + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" + response.data.date.substring(0, 4) + "/" + response.data.date.substring(4, 6) + "/" + response.data.date.substring(6, 8);
                    document.getElementById("lbL2").innerHTML = "زمان: " + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" + response.data.time.substring(0, 2) + ":" + response.data.time.substring(2, 4) + ":" + response.data.time.substring(4, 6);
                    document.getElementById("lbL3").innerHTML = "ولتاژ: " + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" + response.data.voltage + " V";
                    document.getElementById("lbL4").innerHTML = "جریان: " + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" + response.data.current + " A";
                    document.getElementById("lbL6").innerHTML = "شماره سریال: " + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" + response.data.serial_number;
                    document.getElementById("lbL7").innerHTML = "تعرفه1: " + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" + response.data.active_import_energy_tariff_1 + " kWh";
                    document.getElementById("lbL8").innerHTML = "تعرفه2: " + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" + response.data.active_import_energy_tariff_1 + " kWh";
                    document.getElementById("lbL9").innerHTML = "تعرفه3: " + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" + response.data.active_import_energy_tariff_3 + " kWh";
                    document.getElementById("lbL10").innerHTML = "تعرفه4: " + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" + response.data.active_import_energy_tariff_4 + " kWh";
                    document.getElementById("lbL11").innerHTML = "مجموع مصرف: " + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;" + response.data.total_active_import_energy + " kWh";

                }
            })
        }

        function changeStatus() {
            var element = document.getElementById("mySelect").value;
            var status = $("#x").prop("checked");

            $.ajax({
                url: "http://ami.itmc.ir/api/updateElectricityMeterRelayStatus",
                type: "post",
                data: {
                    electricalMeterId: element,
                    relay1_status: status === true ? 1 : 0

                },
                success: function(response) {

                    console.log(response);

                    swal(response.message);
                }
            })
        }

        function AnimateRotate(angel) {
            var $elem = $('#refresh');
            $({
                deg: 0
            }).animate({
                deg: angel
            }, {
                duration: 1000,
                step: function(now) {
                    $elem.css({
                        transform: 'rotate(' + now + 'deg)'
                    });
                }
            });
        }
    </script>

</body>

</html>
