<?php 
include "header.php";

// Check if an ID is provided in the query string
if (isset($_GET['id'])) {
    $presale_id = $_GET['id'];

    // Fetch presale details from the database
    $presaleQuery = "SELECT * FROM presales WHERE id='$presale_id'";
    $presaleResult = mysqli_query($link, $presaleQuery);
    $presale = mysqli_fetch_assoc($presaleResult);

    if (!$presale) {
        echo "<script>Swal.fire('Error', 'Presale not found.', 'error')</script>";
        exit();
    }
} else {
    echo "<script>Swal.fire('Error', 'No presale ID provided.', 'error')</script>";
    exit();
}

// Handle form submission for update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture the form data 
    $name = $_POST['name'];
    $starts_at = $_POST['starts_at'];
    $price = $_POST['price'];
    $minimum_buy = $_POST['minimum_buy'];
    $maximum_buy = $_POST['maximum_buy'];
    $total_supply = $_POST['total_supply'];
    $vesting_initial_unlock = $_POST['vesting_initial_unlock'];
    $vesting_starts_after = $_POST['vesting_starts_after'];
    $vesting_period = $_POST['vesting_period'] * 2629743; // Convert months to seconds
    $vesting_period_count = $_POST['vesting_period_count'];

    // SQL query to update the presale data
    $updateQuery = "UPDATE presales 
                    SET name='$name', starts_at='$starts_at', price='$price', 
                    minimum_buy='$minimum_buy', maximum_buy='$maximum_buy', total_supply='$total_supply', 
                    vesting_initial_unlock='$vesting_initial_unlock', vesting_starts_after='$vesting_starts_after', 
                    vesting_period='$vesting_period', vesting_period_count='$vesting_period_count'
                    WHERE id='$presale_id'";
    // Execute the update query
    $update = mysqli_query($link, $updateQuery);

    if ($update) {
        echo "<script>
                Swal.fire('Success', 'Presale updated successfully.', 'success')
                .then(() => {
                    window.location.href = 'presale.php';
                });
              </script>";
    } else {
        echo "<script>Swal.fire('Error', `Error updating presale: " . mysqli_error($link) . "`, 'error')</script>";
    }
}

?>

<div id="content" class="app-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Presale</li>
                </ul>
                <h1 class="page-header">
                    Edit Presale
                    <small>Update the presale details here...</small>
                </h1>
                <hr class="mb-4" /> 
            </div>
            <div class="col-xl-4">
                <div class="d-flex align-items-center justify-content-end gap-3">
                    <div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row mb-n3">
                                <div class="col-xl-3">
                                    <label class="form-label">Name</label>
                                    <input id="name" name="name" class="form-control form-control-lg mb-3" type="text"
                                        value="<?php echo htmlspecialchars($presale['name']); ?>" required />
                                </div>
                                <div class="col-xl-3">
                                    <label class="form-label">Start Date</label>
                                    <input id="starts_at" name="starts_at" class="form-control form-control-lg mb-3" type="datetime-local"
                                        value="<?php echo date('Y-m-d\TH:i', strtotime($presale['starts_at'])); ?>" required />
                                </div>
                                <div class="col-xl-3">
                                    <label class="form-label">Tokens</label>
                                    <input id="total_supply" name="total_supply" class="form-control form-control-lg mb-3" type="text"
                                        value="<?php echo floatval($presale['total_supply']); ?>" />
                                </div>
                                <div class="col-xl-3">
                                    <label class="form-label">Price</label>
                                    <input id="price" name="price" class="form-control form-control-lg mb-3" type="text"
                                        value="<?php echo floatval($presale['price']); ?>" required />
                                </div>
                            </div>

                            <div class="row mt-3 mb-n3">
                                <div class="col-xl-4">
                                    <label class="form-label">Minimum Buy</label>
                                    <input id="minimum_buy" name='minimum_buy' class="form-control form-control-lg mb-3" type="text"
                                        value="<?php echo floatval($presale['minimum_buy']); ?>" required />
                                </div>
                                <div class="col-xl-4">
                                    <label class="form-label">Maximum Buy</label>
                                    <input id="maximum_buy" name="maximum_buy" class="form-control form-control-lg mb-3" type="text"
                                        value="<?php echo floatval($presale['maximum_buy']); ?>" required />
                                </div>
                                
                                <div class="col-xl-4">
                                    <label class="form-label">TGE Unlock (0 to 1)</label>
                                    <input id="vesting_initial_unlock" name="vesting_initial_unlock" class="form-control form-control-lg mb-3" type="text"
                                        value="<?php echo floatval($presale['vesting_initial_unlock']); ?>" required />
                                </div>
                                <div class="col-xl-4">
                                    <label class="form-label">Cliff</label>
                                    <input id="vesting_starts_after" name="vesting_starts_after" class="form-control form-control-lg mb-3" type="text"
                                        value="<?php echo htmlspecialchars($presale['vesting_starts_after']); ?>" required />
                                </div>
                                <div class="col-xl-4">
                                    <label class="form-label">Vesting Period (Months)</label>
                                    <input id="vesting_period" name="vesting_period" class="form-control form-control-lg mb-3" type="text"
                                        value="<?php echo round($presale['vesting_period'] / 2629743); ?>" required />
                                </div>
                                <div class="col-xl-4">
                                    <label class="form-label">Vesting Month Count</label>
                                    <input id="vesting_period_count" name="vesting_period_count" class="form-control form-control-lg mb-3" type="text"
                                        value="<?php echo htmlspecialchars($presale['vesting_period_count']); ?>" required />
                                </div>
                            </div> 

                            <div class="pt-5">
                                <button id="submitPlanButton" type="submit" class="btn btn-outline-theme btn-lg d-block w-100 fw-500">
                                    Update Presale
                                </button>
                            </div>
                        </form>
                    </div>
                    <?php include "card-arrow.php"; ?>
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

    startDateInput.setAttribute('min', formattedDateTime);

    });
</script>

<?php include "footer.php"; ?>
