<?php 
include '../includes/header.php';
checkRole('provider');

$provider_id = $_SESSION['user_id'];

// Get provider stats
$services_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM services WHERE provider_id = $provider_id");
$services_count = mysqli_fetch_assoc($services_query)['total'];

$bookings_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings WHERE provider_id = $provider_id");
$bookings_count = mysqli_fetch_assoc($bookings_query)['total'];

$pending_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings WHERE provider_id = $provider_id AND status = 'pending'");
$pending_count = mysqli_fetch_assoc($pending_query)['total'];

$earnings_query = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM bookings WHERE provider_id = $provider_id AND status = 'completed'");
$earnings = mysqli_fetch_assoc($earnings_query)['total'] ?? 0;
?>

<h2><i class="fas fa-tachometer-alt"></i> Provider Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['name']; ?>!</p>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3><?php echo $services_count; ?></h3>
                <p>My Services</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3><?php echo $bookings_count; ?></h3>
                <p>Total Bookings</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3><?php echo $pending_count; ?></h3>
                <p>Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3>₹<?php echo number_format($earnings); ?></h3>
                <p>Earnings</p>
            </div>
        </div>
    </div>
</div>



<?php include '../includes/footer.php'; ?>