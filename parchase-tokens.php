<?php include "header.php"; ?>

<div id="content" class="app-content py-3">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Purchase History</li>
                </ul>
                <h1 class="page-header">
                    Purchase Token 
                </h1>
                <hr class="mb-4" />

                <div class="staking-history-area">
                    <ul class="nav nav-pills my-3" id="pills-tab">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-Active-tab" data-bs-toggle="pill" href="#pills-Active">Paid</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-Completed-tab" data-bs-toggle="pill" href="#pills-Completed">Unpaid</a>
                        </li>
                    </ul>
                    
                    
                    <div class="card mb-5">
                        <div class="card-body"> 
                    <div class="tab-content" id="pills-tabContent">
                        <?php
                        $statuses = ['paid' => 'Active', 'unpaid' => 'Completed'];

                        foreach ($statuses as $status => $tabId) {
                            $query = "SELECT `address`, `amount`, `token_symbol`, `purchased_amount`, `purchased_at` 
                                      FROM `purchases` 
                                      WHERE `payment_status` = '$status' 
                                      ORDER BY `id` DESC";
                            $result = mysqli_query($link, $query);

                            echo '<div class="tab-pane fade' . ($status == 'paid' ? ' show active' : '') . '" id="pills-' . $tabId . '">';
                            echo '<div class="data-management" data-id="table">';
                            echo '<table id="datatableDefault" class="table text-nowrap w-100">';
                            echo '<thead><tr>';
                            echo '<th style="text-align: left;">#</th>';
                            echo '<th style="text-align: left;">Wallet Address</th>';
                            echo '<th>Buy With</th>';
                            echo '<th>Tokens</th>';
                            echo '<th style="text-align: left;">Date</th>';
                            echo '</tr></thead>';
                            echo '<tbody>';

                            if (mysqli_num_rows($result) > 0) {
                                $i = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>';
                                    echo '<td style="text-align: left;">' . $i++ . '</td>';
                                    echo '<td style="text-align: left;">' . htmlspecialchars($row['address']) . '</td>';
                                    echo '<td>' . floatval($row['amount']) . ' ' . htmlspecialchars($row['token_symbol']) . '</td>';
                                    echo '<td>' . floatval($row['purchased_amount']) . ' BLOX</td>';
                                    echo '<td style="text-align: left;">' . htmlspecialchars($row['purchased_at']) . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="5" style="text-align: center;">No purchases found for this status.</td></tr>';
                            }

                            echo '</tbody></table></div></div>';
                        }
                        ?>
                    </div>
                    </div>
                        <?php include "card-arrow.php"; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
