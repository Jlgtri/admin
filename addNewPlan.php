<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting POST data
    $assets = $_POST['assets'];
    $planIndex = $_POST['planIndex'];
    $network = $_POST['network'];
    $period = $_POST['plansperiod'];
    $rate = $_POST['plansrate'];
    $tax = $_POST['planstax'];
    $minDepositRange = $_POST['minimum_deposit'];
    $maxDepositRange = $_POST['maximum_deposit'];

    // Inserting data into the database
    $query  = "INSERT INTO `plans`(`chainId`, `assets_id`, `planIndex`, `period`, `rate`, `tax`, `minDepositRange`, `maxDepositRange`) VALUES ('$network','$assets', '$planIndex', '$period','$rate', '$tax', '$minDepositRange','$maxDepositRange')";
    $insert = mysqli_query($link, $query);

    // Responding based on insert success or failure
    if ($insert) {
        echo json_encode(array("message" => "New Plan has been successfully activated!", "code" => 201, $query));
    } else {
        echo json_encode(array("message" => "Data inserting failed", $query));
    }
}
?>
