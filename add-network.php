<?php include "header.php";

// Initialize variables for form inputs
$chainId = '';
$networkName = '';

// Handle form submission for adding or editing a network
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addNetwork'])) {
        $chainId = mysqli_real_escape_string($link, $_POST['chain_id']);
        $networkName = mysqli_real_escape_string($link, $_POST['network_name']);

        if (!empty($chainId) && !empty($networkName)) {
            // Check if the chainId already exists
            $checkSql = "SELECT * FROM chains WHERE id = '$chainId'";
            $checkResult = mysqli_query($link, $checkSql);
            
            if (mysqli_num_rows($checkResult) > 0) {
                echo "<script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Network already exists',
                        showConfirmButton: true,
                    });
                </script>";
            } else {
                // Insert into the database
                $sql = "INSERT INTO chains (name, id) VALUES ('$networkName', '$chainId')";
                $insert = mysqli_query($link, $sql);
                
                if ($insert) {
                    echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Chain added successfully',
                            showConfirmButton: true,
                        }).then(() => {
                            window.location.href = './add-network.php'; // Redirect to clear the form
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error adding network',
                            showConfirmButton: true,
                        });
                    </script>";
                }
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Please fill in all fields',
                    showConfirmButton: true,
                });
            </script>";
        }
    }

    // Handle update functionality
    if (isset($_POST['updateNetwork'])) {
        $id = intval($_POST['network_id']);
        $chainId = mysqli_real_escape_string($link, $_POST['chain_id']);
        $networkName = mysqli_real_escape_string($link, $_POST['network_name']);

        if (!empty($chainId) && !empty($networkName)) {
            
            // Update the network in the database
            $sql = "UPDATE chains SET id = '$chainId', name = '$networkName' WHERE id = $id";
            $update = mysqli_query($link, $sql);

            if ($update) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Chain updated successfully',
                        showConfirmButton: true,
                    }).then(() => {
                        window.location.href = './add-network.php'; // Redirect to clear the form
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error updating network',
                        showConfirmButton: true,
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Please fill in all fields',
                    showConfirmButton: true,
                });
            </script>";
        }
    }
}

// Handle edit functionality
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM chains WHERE id = $id";
    $result = mysqli_query($link, $sql);
    $network = mysqli_fetch_assoc($result);

    // Pre-fill the form with the network data if editing
    if ($network) {
        $chainId = $network['id'];
        $networkName = $network['name'];
    }
}
?>

<div id="content" class="app-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Add Chain</li>
                </ul>
                <h1 class="page-header">
                    <?php echo isset($_GET['id']) ? 'Edit Chain' : 'Add Chain'; ?>
                    <small>page header description goes here...</small>
                </h1>
                <hr class="mb-4" />
            </div>

            <div class="col-xl-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <form method="post">
                            <input type="hidden" name="network_id" value="<?php echo isset($network['id']) ? $network['id'] : ''; ?>" />
                            <div class="row mb-n3">
                                <div class="col-xl-6">
                                    <div class="">
                                        <label class="form-label">Chain Id</label>
                                        <input name="chain_id" class="form-control form-control-lg mb-3" type="text" placeholder="" value="<?php echo htmlspecialchars($chainId); ?>" required />
                                    </div> 
                                </div> 
                                <div class="col-xl-6">
                                    <div class="">
                                        <label class="form-label">Chain Name</label>
                                        <input name="network_name" class="form-control form-control-lg mb-3" type="text" placeholder="" value="<?php echo htmlspecialchars($networkName); ?>" required />
                                    </div> 
                                </div> 
                            </div>
                            <div class="pt-5">
                                <button name="<?php echo isset($network['id']) ? 'updateNetwork' : 'addNetwork'; ?>" type="submit" class="btn btn-outline-theme btn-lg d-block w-100 fw-500">
                                    <?php echo isset($network['id']) ? 'Update Now' : 'Submit Now'; ?>
                                </button>
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
                                        <th style="text-align: justify;">id</th> 
                                        <th style="text-align: justify;">Chain Id</th>
                                        <th>Chain Name</th>
                                        <th>Add Date</th>
                                        <th>Last Update</th> 
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    $sql = "SELECT * FROM chains";
                                    $network = mysqli_query($link, $sql);
                                    foreach($network as $networks){
                                        echo '<tr>
                                            <td style="text-align: justify;">'.$i++.'</td>
                                            <td style="text-align: justify;">'.$networks['id'].'</td>
                                            <td>'.$networks['name'].'</td> 
                                            <td>'.$networks['created_at'].'</td>
                                            <td>'.$networks['updated_at'].'</td> 
                                            <td>
                                                <div class="">
                                                    <a href="./add-network.php?id='.$networks['id'].'" class="btn btn-outline-theme btn-sm">Update</a>
                                                </div>
                                            </td>
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
    </div>
</div>


<?php include "footer.php"; ?>
