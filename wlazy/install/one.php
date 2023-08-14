<?php
$base = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base .= "://" . $_SERVER['HTTP_HOST'];
$base .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Install - Steps 1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="<?= $base ?>assets/images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= $base ?>assets/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= $base ?>assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= $base ?>assets/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= $base ?>assets/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= $base ?>assets/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= $base ?>assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="<?= $base ?>assets/css/main.css">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" style="margin-top: 5rem;" data-tilt>
                    <img src="<?= $base ?>assets/images/img-01.png" alt="IMG">
                </div>

                <form class="login100-form validate-form">
                    <span class="login100-form-title">
                        DB MYSQL Setup
                    </span>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="db_name" autocomplete="off" required placeholder="DB_NAME">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-database" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="db_username" autocomplete="off" required placeholder="DB_USERNAME">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100">
                        <input class="input100" type="text" name="db_password" autocomplete="off" placeholder="DB_PASSWORD">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    <hr>
                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="db_host" value="127.0.0.1" autocomplete="off" required placeholder="DB_HOST">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-server" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="db_port" value="3306" autocomplete="off" required placeholder="DB_PORT">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-code" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            CONNECT
                        </button>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="#">
                            Documentation
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>


            </div>
        </div>
    </div>


    <!--===============================================================================================-->
    <script src="<?= $base ?>assets/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= $base ?>assets/vendor/bootstrap/js/popper.js"></script>
    <script src="<?= $base ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= $base ?>assets/vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="<?= $base ?>assets/vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        })

        $("form").submit(function(e) {
            e.preventDefault();
            var db_name = $("input[name=db_name]").val();
            var db_username = $("input[name=db_username]").val();
            var db_password = $("input[name=db_password]").val();
            var db_host = $("input[name=db_host]").val();
            var db_port = $("input[name=db_port]").val();
            $.ajax({
                type: "POST",
                url: "db",
                data: {
                    db_name: db_name,
                    db_username: db_username,
                    db_password: db_password,
                    db_host: db_host,
                    db_port: db_port
                },
                // loading
                beforeSend: function() {
                    $("button[type=submit]").attr("disabled", true);
                    $("button[type=submit]").html("Loading...");
                },
                success: function(data) {
                    // alert(data.message)
                    window.location.href = "two";
                    $("button[type=submit]").attr("disabled", false);
                    $("button[type=submit]").html("CONNECT");
                },
                error: function(data) {
                    alert(data.responseJSON.message ?? 'Error')
                    $("button[type=submit]").attr("disabled", false);
                    $("button[type=submit]").html("CONNECT");
                }
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src="<?= $base ?>assets/js/main.js"></script>

</body>

</html>