<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="utf-8" />
        <title>BLOX Staking | Register</title>
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

if (isset($_POST['signUp'])) {
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $re_password = mysqli_real_escape_string($link, $_POST['re_password']);

    if (!empty($name) && !empty($email) && !empty($password) && !empty($re_password)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (strlen($password) >= 8) {
                if ($password === $re_password && $password) {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    // Check if the email is already registered
                    $sql = mysqli_query($link, "SELECT email FROM admins WHERE email = '$email'");
                    $numRows = mysqli_num_rows($sql);
                    
                    $quer = "INSERT INTO `admins` (`name`, `email`, `password`, `time`) VALUES ('$name', '$email', '$hashedPassword', '" . time() . "')";
echo $quer;
                    if ($numRows == 0) {
                        // Insert the new user into the database
                        $insert = mysqli_query($link, "INSERT INTO `admins` (`name`, `email`, `password`, `time`) VALUES ('$name', '$email',
        '$hashedPassword', '" . time() . "')");

                        if ($insert) {
                            echo "
        <script>
            setTimeout(function() {
                location.href = 'login.php'
            }, 3000);
            Swal.fire({
                toast: true,
                icon: 'success',
                title: 'User has been successfully registered',
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
                            echo "
        <script>
            Swal.fire({
                toast: true,
                icon: 'error',
                title: 'Internal server error',
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
                        echo "
        <script>
            Swal.fire({
                toast: true,
                icon: 'error',
                title: 'User already registered',
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
                    echo "
        <script>
            Swal.fire({
                toast: true,
                icon: 'error',
                title: 'Password mismatch',
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
                echo "
        <script>
            Swal.fire({
                toast: true,
                icon: 'error',
                title: 'Password must be at least 8 characters long',
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
            echo "
        <script>
            Swal.fire({
                toast: true,
                icon: 'error',
                title: 'Invalid email address.',
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
            <div class="register">
                <div class="register-content">
                    <form  method="POST" name="register_form">
                        <h1 class="text-center">Sign Up</h1>
                        <p class="text-inverse text-opacity-50 text-center">One Admin ID is all you need to access all the Admin services.</p>
                        <div class="mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-lg bg-inverse bg-opacity-5" placeholder="e.g John Smith" Required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="text" name="email" class="form-control form-control-lg bg-inverse bg-opacity-5" placeholder="username@address.com"  Required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control form-control-lg bg-inverse bg-opacity-5"  Required/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="re_password" class="form-control form-control-lg bg-inverse bg-opacity-5" Required />
                        </div>
                        <div class="mb-3">
                            <button name="signUp" type="submit" class="btn btn-outline-theme btn-lg d-block w-100">Sign Up</button>
                        </div>
                        <div class="text-inverse text-opacity-50 text-center">Already have an Admin ID? <a href="login.php">Sign In</a></div>
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
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());

            gtag("config", "UA-53034621-1");
        </script>
        <script src="../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="191ca390919237300aa02529-|49" defer></script>
        <script
            defer
            src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
            integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
            data-cf-beacon='{"rayId":"8a1602890c633ad7","version":"2024.6.1","r":1,"serverTiming":{},"token":"4db8c6ef997743fda032d4f73cfeff63","b":1}'
            crossorigin="anonymous"
        ></script>
    </body>
</html>
