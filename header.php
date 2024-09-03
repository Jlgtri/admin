<?php session_start();
$email = $_SESSION['adminMail'] ?? '';
if (empty($email) || $email == "" || !$email) {
    header('location: ./login.php');
    die();
}
date_default_timezone_set('Asia/Kolkata');

$time = time();

include "config.php";

$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$file_name = basename($actual_link);
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="utf-8" />
        <title>BLOX Staking | Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="description" content />
        <meta name="author" content />

        <link rel="shortcut icon" href="./assets/img/favicon.png" type="image/x-icon">

        <link href="assets/css/vendor.min.css" rel="stylesheet" />
        <link href="assets/css/app.min.css" rel="stylesheet" />

        <link href="assets/plugins/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
        <link href="assets/plugins/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" />
        <link href="assets/plugins/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" />
        <link href="assets/plugins/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" />    </head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/web3/4.10.1-dev.89711ab.0/web3.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="contracts.js"></script>
    <body>
        <div id="app" class="app">
            <div id="header" class="app-header">
                <div class="desktop-toggler">
                    <button type="button" class="menu-toggler" data-toggle-class="app-sidebar-collapsed" data-dismiss-class="app-sidebar-toggled" data-toggle-target=".app">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </button>
                </div>

                <div class="mobile-toggler">
                    <button type="button" class="menu-toggler" data-toggle-class="app-sidebar-mobile-toggled" data-toggle-target=".app">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </button>
                </div>

                <div class="brand">
                    <a href="index.php" class="brand-logo">

                        <img src="./assets/img/blox-logo.png" class="" width="120px" alt="">  
                    </a>
                </div>

                <div class="menu">
                    <div class="menu-item dropdown">
                    
                    </div>
                    <div class="menu-item dropdown dropdown-mobile-full">
                        <a href="#" data-bs-toggle="dropdown" data-bs-display="static" class="menu-link">
                            <div class="menu-img online">
                                <img src="assets/img/user/profile.jpg" alt="Profile" height="60" />
                            </div>
                            <div class="menu-text d-sm-block d-none w-170px"><span class="__cf_email__" data-cfemail="cbbeb8aeb9a5aaa6ae8baaa8a8a4bea5bfe5a8a4a6"><?php echo $email; ?></span></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end me-lg-3 fs-11px mt-1">
                            <!--<a class="dropdown-item d-flex align-items-center" href="profile.php">PROFILE <i class="bi bi-person-circle ms-auto text-theme fs-16px my-n1"></i></a>                             <div class="dropdown-divider"></div>-->
                            <a class="dropdown-item d-flex align-items-center" href="logout.php">LOGOUT <i class="bi bi-toggle-off ms-auto text-theme fs-16px my-n1"></i></a>
                        </div>
                    </div>
                </div>

            </div>

            <div id="sidebar" class="app-sidebar">
                <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
                    <div class="menu">
                        <div class="menu-header">Navigation</div>
                        <div class="menu-item <?php echo $file_name=="index.php" ? "active" : "" ?>">
                            <a href="index.php" class="menu-link">
                                <span class="menu-icon"><i class="bi bi-cpu"></i></span>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </div>  
                        <div class="menu-header">Components</div>
                        <div class="menu-item <?php echo $file_name=="presale.php" ? "active" : "" ?>">
                            <a href="presale.php" class="menu-link">
                                <span class="menu-icon"><i class="bi bi-columns-gap"></i></span>
                                <span class="menu-text">Add Presale </span>
                            </a>
                        </div> 
                        <div class="menu-item <?php echo $file_name=="add-network.php" ? "active" : "" ?>">
                            <a href="add-network.php" class="menu-link">
                                <span class="menu-icon"><i class="fas fa-address-card"></i></span>
                                <span class="menu-text">Add Chain</span>
                            </a>
                        </div>  
                        <div class="menu-item <?php echo $file_name=="parchase-tokens.php" ? "active" : "" ?>">
                            <a href="parchase-tokens.php" class="menu-link">
                                <span class="menu-icon"><i class="bi bi-compass"></i></span>
                                <span class="menu-text">Parchase Tokens</span>
                            </a>
                        </div>   
                        <div class="menu-divider"></div>  
                    </div>

                </div>
            </div>

            <button class="app-sidebar-mobile-backdrop" data-toggle-target=".app" data-toggle-class="app-sidebar-mobile-toggled"></button>

        