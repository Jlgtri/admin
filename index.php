<?php include "header.php"; 

$totalUsers = mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(DISTINCT `address`) AS total__users FROM `purchases`;"));
$totalPresales = mysqli_num_rows(mysqli_query($link, "SELECT `id` FROM `presales`"));
$totalCurrency = mysqli_fetch_assoc(mysqli_query($link, "SELECT count(*) as totalCurrency FROM `tokens`"));
$TotalNetworks = mysqli_fetch_assoc(mysqli_query($link, "SELECT count(*) as totalChains FROM `chains`")); 



?>

<div id="content" class="app-content">
                <div class="row">
                    <div class="col-xl-3 col-lg-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex fw-bold small mb-3">
                                    <span class="flex-grow-1">Total User</span>
                                    <a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
                                </div>

                                <div class="row align-items-center mb-2">
                                    <div class="col-7">
                                        <h3 class="mb-0"><?php echo $totalUsers['total__users']; ?></h3>
                                    </div>
                                     
                                </div>
 
                            </div>

                            <?php include "card-arrow.php"; ?>
                        </div>
                    </div>

                   

                    <div class="col-xl-3 col-lg-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex fw-bold small mb-3">
                                    <span class="flex-grow-1">Total Round</span>
                                    <a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
                                </div>

                                <div class="row align-items-center mb-2">
                                    <div class="col-7">
                                        <h3 class="mb-0"><?php echo $totalPresales; ?></h3>
                                    </div> 
                                </div>
 
                            </div>

                            <?php include "card-arrow.php"; ?>
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-lg-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex fw-bold small mb-3">
                                    <span class="flex-grow-1">Total Networks</span>
                                    <a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
                                </div>

                                <div class="row align-items-center mb-2">
                                    <div class="col-7">
                                        <h3 class="mb-0"><?php echo $TotalNetworks['totalChains']; ?></h3>
                                    </div> 
                                </div>
 
                            </div>

                            <?php include "card-arrow.php"; ?>
                        </div>
                    </div>
                    
                     <div class="col-xl-3 col-lg-6">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex fw-bold small mb-3">
                                    <span class="flex-grow-1">Total Currency</span>
                                    <a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
                                </div>

                                <div class="row align-items-center mb-2">
                                    <div class="col-7">
                                        <h3 class="mb-0"><?php echo $totalCurrency['totalCurrency']; ?></h3>
                                    </div> 
                                </div>
 
                            </div>

                            <?php include "card-arrow.php"; ?>
                        </div>
                    </div>

  
                    <div class="col-xl-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex fw-bold small mb-3">
                                    <span class="flex-grow-1">RECENT PURCHASE</span>
                                    <a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none"><i class="bi bi-fullscreen"></i></a>
                                </div>

                                 <table id="datatableDefault" class="table text-nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: left;">#</th>
                                                    <th  style="text-align: left;">Wallet Address</th>
                                                    <th>Buy With</th>
                                                    <th>Tokens</th>
                                                    <th style="text-align: justify;">Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1;  
                                                $user = mysqli_query($link, "SELECT * FROM `purchases`  WHERE `payment_status`='paid' ORDER BY `id` DESC LIMIT 20");
                                                foreach($user as $users){
                                                    echo '<tr>
                                                            <td style="text-align: left;">'.$i++.'</td>
                                                            <td style="text-align: left;">'.$users['address'].'</td>
                                                            <td>'.floatval($users['amount']).' '.$users['token_symbol'].'</td>
                                                            <td>'.floatval($users['purchased_amount']).' BLOX</td>
                                                            <td>'.$users['purchased_at'].'</td>
                                                        </tr>';
                                                }
                                                
                                                ?> 
                                                
                                            </tbody>
                                        </table>
                            </div>

                            <?php include "card-arrow.php"; ?>
                        </div>
                    </div>
                </div>
            </div>

 <?php include "footer.php"; ?>