<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="utf-8" />
        <title>BLOX Staking | Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content />
        <meta name="author" content />

        <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">
        <link href="assets/css/vendor.min.css" rel="stylesheet" />
        <link href="assets/css/app.min.css" rel="stylesheet" />
    </head>
    <body class="pace-top">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
<?php include "config.php";

if (isset($_POST['signIn'])) {
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    if (!empty($email) && !empty($password)) {
        $user = mysqli_query($link, "SELECT * FROM `admins` WHERE `email` = '$email'");
        $userNum = mysqli_num_rows($user);
        if ($userNum > 0) {
            $userData = mysqli_fetch_assoc($user);
            if (password_verify($password, $userData['password'])) {
                $user = $userData;
                $verify = $user['status'];
                if ($verify == 1) {
                    $_SESSION['adminMail'] = $user['email'];
                    echo "<script>
                    setTimeout(function(){location.href='index.php'} , 1000);
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: 'User has been successfully login.',
                            animation: false,
                            position: 'top-right',
                            showConfirmButton: false,
                            timer: 3000,
                            animation: true,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                </script>";
                } else {
                    echo "<script>
                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        title: 'You are not authorized to access this panel.',
                        animation: false,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 3000,
                        animation: true,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    
                    </script>";
                }
            } else {
                echo "<script>
                Swal.fire({
                    toast: true,
                    icon: 'error',
                    title: 'Email and password do not match.',
                    animation: false,
                    position: 'top-right',
                    showConfirmButton: false,
                    timer: 3000,
                    animation: true,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                </script>";
            }
        } else {
            echo "<script>
            Swal.fire({
                toast: true,
                icon: 'error',
                title: 'User not found.',
                animation: false,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000,
                animation: true,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            </script>";
        }
    }
}

?>
        
        
        <div id="app" class="app app-full-height app-without-header">
            <div class="login">
                <div class="login-content">
                    <form method="POST">
                        <h1 class="text-center">Sign In</h1>
                        <div class="text-inverse text-opacity-50 text-center mb-4">
                            For your protection, please verify your identity.
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg bg-inverse bg-opacity-5" placeholder required/>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <!--<a href="#" class="ms-auto text-inverse text-decoration-none text-opacity-50">Forgot password?</a>-->
                            </div>
                            <input type="password" name="password" class="form-control form-control-lg bg-inverse bg-opacity-5"  placeholder required/>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value id="customCheck1" required/>
                                <label class="form-check-label" for="customCheck1">Remember me</label>
                            </div>
                        </div>
                        <button name="signIn" type="submit" class="btn btn-outline-theme btn-lg d-block w-100 fw-500 mb-3">Sign In</button>
                        <div class="text-center text-inverse text-opacity-50">Don't have an account yet? <a href="register.php">Sign up</a>.</div>
                    </form>
                </div>
            </div>

            

            <a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade"><i class="fa fa-arrow-up"></i></a>
        </div>

        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>

        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-53034621-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-53034621-1');
        </script>
        <script src="../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="3b59c65890abb707892cd9a2-|49" defer></script>
        <script
            defer
            src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
            integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
            data-cf-beacon='{"rayId":"8a16023b4ffa3b39","version":"2024.6.1","r":1,"serverTiming":{},"token":"4db8c6ef997743fda032d4f73cfeff63","b":1}'
            crossorigin="anonymous"
        ></script>
    </body>
</html>
