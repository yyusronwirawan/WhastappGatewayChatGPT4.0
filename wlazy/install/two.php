<?php
session_start();
if (!isset($_SESSION['db'])) {
    header("Location: one");
    exit();
}

$base = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$base .= "://" . $_SERVER['HTTP_HOST'];
$base .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Install - Steps 2</title>
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
    <style>
        select {
            border: 0px;
        }

        /* select arrow down margin */
        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
    </style>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="<?= $base ?>assets/images/img-01.png" alt="IMG">
                </div>

                <form class="login100-form validate-form">
                    <span class="login100-form-title">
                        WALazy Settings
                    </span>

                    <div class="wrap-input100 validate-input">
                        <input class="input100" type="text" name="base_node" autocomplete="off" required placeholder="BASE NODE">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-link" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input">
                        <select class="input100" name="socket_default" required>
                            <option value="">Socket Url</option>
                            <option value="true">Default</option>
                            <option value="false">Use Base Node</option>
                        </select>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-server" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            FINISH
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
            $.ajax({
                type: "POST",
                url: "finish",
                data: {
                    base_node: $("input[name=base_node]").val(),
                    socket_default: $("select[name=socket_default]").val(),
                },
                // loading
                beforeSend: function() {
                    $("button[type=submit]").attr("disabled", true);
                    $("button[type=submit]").html("Loading...");
                },
                success: function(data) {
                    // alert(data.message)
                    window.location.href = "done";
                    $("button[type=submit]").attr("disabled", false);
                    $("button[type=submit]").html("FINISH");
                },
                error: function(data) {
                    alert(data.responseJSON.message ?? 'Error')
                    $("button[type=submit]").attr("disabled", false);
                    $("button[type=submit]").html("FINISH");
                }
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src="<?= $base ?>assets/js/main.js"></script>

</body>

</html>