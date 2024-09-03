<?php
$servername = "localhost";
$username = "blox";
$password = "";
$dbname = "blox_public";

$link = mysqli_connect($servername, $username, $password, $dbname);
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$NODE_API="https://apic.myreview.website:8443/api"; 