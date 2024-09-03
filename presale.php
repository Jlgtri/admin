<?php include "header.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['endPresale'])) {
    $presaleId = $_POST['endPresale'];
    $presaleId = mysqli_real_escape_string($link, $presaleId);

    // Get the current timestamp
    $currentTimestamp = date('Y-m-d H:i:s');

    // SQL query to update the status of the presale to 'Ended' and set the ends_at timestamp to the current time
    $query = "UPDATE presales SET status = 'Ended', ends_at = '$currentTimestamp' WHERE id = '$presaleId'";

    // Execute the query
    if (mysqli_query($link, $query)) {
        // Optional: Update the status of the next presale to 'Live'
        $nextPresaleId = $presaleId + 1;
        mysqli_query($link, "UPDATE presales SET status = 'Live' WHERE id = '$nextPresaleId'");

        echo "<script>Swal.fire('Success','Presale ended successfully.', 'success')</script>";
    } else {
        echo "<script>Swal.fire('Error','Failed to end the presale.', 'error')</script>";
    }
}


function convertTimestampToYMDMS($t)
{
    $year = $month = $day = $hour = $minute = $second = 0;

    $second = $t % 60;
    $t = floor($t / 60);
    $minute = $t % 60;
    $t = floor($t / 60);
    $hour = $t % 24;
    $t = floor($t / 24);
    $day = $t % 30;
    $t = floor($t / 30);
    $month = $t % 12;
    $t = floor($t / 12);
    $year = $t;

    if ($year > 0) {
        return $year . ' Year' . ($year > 1 ? 's' : '');
    }
    if ($month > 0) {
        return $month . ' Month' . ($month > 1 ? 's' : '');
    }
    if ($day > 0) {
        return $day . ' Day' . ($day > 1 ? 's' : '');
    }
    if ($hour > 0) {
        return $hour . ' Hour' . ($hour > 1 ? 's' : '');
    }
    if ($minute > 0) {
        return $minute . ' Minute' . ($minute > 1 ? 's' : '');
    }
    if ($second > 0) {
        return $second . ' Second' . ($second > 1 ? 's' : '');
    }
    return "0 Second"; // If the duration is 0
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitPlanButton'])) { 
    // Capture the form data 
    $name = $_POST['name']; 
    $starts_at = $_POST['starts_at'];
    $ends_at = $_POST['ends_at'] || "null";
    $price = $_POST['price'];
    $minimum_buy = $_POST['minimum_buy'];
    $maximum_buy = $_POST['maximum_buy'];
    $total_supply = $_POST['total_supply'];
    $vesting_initial_unlock = $_POST['vesting_initial_unlock'];
    $vesting_starts_after = $_POST['vesting_starts_after'];
    $vesting_period = $_POST['vesting_period'] * 2629743;
    $vesting_period_count = $_POST['vesting_period_count'];

    $presale = mysqli_query($link, "SELECT `id` FROM `presales` ORDER BY `id` DESC LIMIT 1");
    $presaleAssoc = mysqli_fetch_assoc($presale);
    $presale_id = $presaleAssoc['id']+1;

    // SQL query to insert the new presale data
    $insertQuery = "INSERT INTO presales (id,name, starts_at, ends_at, price, minimum_buy, maximum_buy, total_supply, vesting_initial_unlock, vesting_starts_after, vesting_period, vesting_period_count) 
                    VALUES ('$presale_id','$name', '$starts_at', '$ends_at', '$price', '$minimum_buy', '$maximum_buy', '$total_supply', '$vesting_initial_unlock', '$vesting_starts_after', '$vesting_period', '$vesting_period_count')";

    // Prepare and execute the statement
    $insert = mysqli_query($link, $insertQuery);
    if ($insert) {
        echo "<script>Swal.fire('Success', 'New presale data inserted successfully.', 'success')</script>";
        // echo "<div class='alert alert-success'>New presale data inserted successfully.</div>";
    } else {
        echo "<script>
                        Swal.fire({
                            title: 'Error: Could not execute query.',
                            text: `" . mysqli_error($link) . "`,
                            icon: 'error'
                        });
                  </script>";
        // echo "<div class='alert alert-danger'>Error: Could not execute query. " . mysqli_error($link) . "</div>";
    }
}



?>


<div id="content" class="app-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Add Presale</li>
                </ul>
                <h1 class="page-header">
                    Add Presale
                    <small>page header description goes here...</small>
                </h1>
                <hr class="mb-4" />
            </div>
            <div class="col-xl-4">
                <div class="d-flex align-items-center justify-content-end gap-3">
                    <div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row mb-n3">
                                <div class="col-xl-3">
                                    <div class="">
                                        <label class="form-label">Name</label>
                                        <input id="name" name="name" class="form-control form-control-lg mb-3"
                                            type="text" placeholder="" required />
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="">
                                        <label class="form-label">Start Date</label>
                                        <input id="starts_at" name="starts_at" class="form-control form-control-lg mb-3"
                                            type="datetime-local" placeholder="" required />
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="">
                                        <label class="form-label">End Date</label>
                                        <input id="ends_at" name="ends_at" class="form-control form-control-lg mb-3"
                                            type="datetime-local" placeholder="" />
                                    </div>
                                </div>

                                <div class="col-xl-3">
                                    <div class="">
                                        <label class="form-label">Price</label>
                                        <input id="price" name="price" class="form-control form-control-lg mb-3"
                                            type="text" placeholder="" required />
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3 mb-n3">
                                <div class="col-xl-4">
                                    <div class="">
                                        <label class="form-label">Minimum Buy</label>
                                        <input id="minimum_buy" name='minimum_buy'
                                            class="form-control form-control-lg mb-3" type="text" placeholder=""
                                            required />
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="">
                                        <label class="form-label">Maximum Buy</label>
                                        <input id="maximum_buy" name="maximum_buy"
                                            class="form-control form-control-lg mb-3" type="text" placeholder=""
                                            required />
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="">
                                        <label class="form-label">Tokens</label>
                                        <input id="total_supply" name="total_supply"
                                            class="form-control form-control-lg mb-3" type="text" placeholder=""
                                            required />
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="">
                                        <label class="form-label">TGE Unlock</label>
                                        <input id="vesting_initial_unlock" name="vesting_initial_unlock"
                                            class="form-control form-control-lg mb-3" type="text" placeholder=""
                                            required />
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="">
                                        <label class="form-label">Cliff</label>
                                        <input id="vesting_starts_after" name="vesting_starts_after"
                                            class="form-control form-control-lg mb-3" type="text" placeholder=""
                                            required />
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="">
                                        <label class="form-label">Vesting Period (Month)</label>
                                        <input id="vesting_period" name="vesting_period"
                                            class="form-control form-control-lg mb-3" type="text" placeholder=""
                                            required />
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="">
                                        <label class="form-label">Vesting Month</label>
                                        <input id="vesting_period_count" name="vesting_period_count"
                                            class="form-control form-control-lg mb-3" type="text" placeholder=""
                                            required />
                                    </div>
                                </div>

                            </div>
                            <div class="pt-5">
                                <button name="submitPlanButton" type="submit"
                                    class="btn btn-outline-theme btn-lg d-block w-100 fw-500">Submit Now</button>
                            </div>
                        </form>
                    </div>
                    <?php include "card-arrow.php"; ?>
                </div>

            </div>

            <div class="col-xl-12">

                <div id="datatable" class="mb-5">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatableDefault" class="table text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Minimum Buy</th>
                                        <th>Maximum Buy</th>
                                        <th>Tokens</th>
                                        <th>TGE Unlock</th>
                                        <th>Cliff</th>
                                        <th>Vesting Period</th>
                                        <th>Vesting Month</th>
                                        <th>Add Date</th>
                                        <th>Update Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $presaleQuery = "SELECT * FROM presales";
                                    $presaleResult = mysqli_query($link, $presaleQuery);
                                    while ($row = mysqli_fetch_assoc($presaleResult)) {
                                        echo '<tr>
                                            <td>' . htmlspecialchars($row['id']) . '</td>
                                            <td>' . htmlspecialchars($row['name']) . '</td>
                                            <td>' . htmlspecialchars($row['starts_at']) . '</td>
                                            <td>' . htmlspecialchars($row['ends_at']) . '</td>
                                            <td>$' . floatval($row['price']) . '</td>
                                            <td>' . htmlspecialchars($row['status']) . '</td>
                                            <td>' . floatval($row['minimum_buy']) . '</td>
                                            <td>' . floatval($row['maximum_buy']) . '</td>
                                            <td>' . floatval($row['total_supply']) . '</td>
                                            <td>' . floatval($row['vesting_initial_unlock']) . '</td>
                                            <td>' . htmlspecialchars($row['vesting_starts_after']) . ' months</td>
                                            <td>' . convertTimestampToYMDMS($row['vesting_period']) . '</td>
                                            <td>' . htmlspecialchars($row['vesting_period_count']) . '</td>
                                            <td>' . htmlspecialchars($row['created_at']) . '</td>
                                            <td>' . htmlspecialchars($row['updated_at']) . '</td>
                                            <td>';

                                            // Only show action buttons if the status is not 'Ended'
                                            if ($row['status'] !== 'Ended') {
                                                echo '<a href="edit_presale.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a>';
                                    
                                                if ($row['status'] === 'Live') {
                                                    echo '<form method="post" style="display:inline;">
                                                            <button name="endPresale" value="' . $row['id'] . '" class="btn btn-warning">End Sale</button>
                                                          </form>';
                                                }
                                            }
                                    
                                            echo '</td></tr>';
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
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
       // Get the current date and time
    const currentDate = new Date();

    // Format the current date and time to match the datetime-local format (YYYY-MM-DDTHH:MM)
    const formattedDateTime = currentDate.toISOString().slice(0, 16);

    // Set the min attribute of the start date and end date inputs to the current date and time
    const startDateInput = document.getElementById('starts_at');
    const endDateInput = document.getElementById('ends_at');

    startDateInput.setAttribute('min', formattedDateTime);
    endDateInput.setAttribute('min', formattedDateTime);

    // Update the end date's min attribute whenever the start date changes
    startDateInput.addEventListener('change', function() {
        const selectedStartDate = startDateInput.value;
        if (selectedStartDate) {
            endDateInput.setAttribute('min', selectedStartDate);
        }
    });
    });
</script>


<?php include "footer.php"; ?>