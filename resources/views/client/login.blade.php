<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/rtlbootstrap.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/util.css">
    <link rel="stylesheet" href="css/main.css">


    <script src="./js/jquery-3.4.1.min.js"></script>
    <script src="./js/sweetalert.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</head>
</head>

<body id="demo" style="background-color: #666666;">

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" id="login">
                    <span class="login100-form-title p-b-43">
						ورود به برنامه
					</span>


                    <div class="wrap-input100 validate-input" data-validate="نام کاربری را وارد نمایید.">
                        <input class="input100" type="name" id="username" name="username">
                        <span class="focus-input100"></span>
                        <span class="label-input100">نام کاربری</span>
                    </div>


                    <div class="wrap-input100 validate-input" data-validate="رمز عبور را وارد نمایید.">
                        <input class="input100" type="password" id="password" name="password">
                        <span class="focus-input100"></span>
                        <span class="label-input100">کلمه عبور</span>
                    </div>


                    <div class="container-login100-form-btn">
                        <button onclick="myFunction()" class="login100-form-btn" style="font-size: large;">
							ورود
						</button>
                    </div>
                </form>

                <div class="login100-more" style="background-image: url('image/login.jpg');">
                </div>
            </div>
        </div>
    </div>
    <script>
        /* attach a submit handler to the form */
        $("#login").submit(function(event) {

            /* stop form from submitting normally */
            event.preventDefault();

            /* get the action attribute from the <form action=""> element */
            var $form = $(this),
                url = $form.attr('action');

            /* Send the data using post with element id name and name2*/
            var posting = $.post(url, {
                username: $('#username').val(),
                password: $('#password').val()
            });

            /* Alerts the results */
            posting.done(function(data) {
                swal('success');
            });
        });
    </script>
</body>

</html>