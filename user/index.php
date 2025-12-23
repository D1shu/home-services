<?php 
include '../includes/header.php';
checkRole('user');

$user_id = $_SESSION['user_id'];

// Get user stats
$bookings_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings WHERE user_id = $user_id");
$bookings_count = mysqli_fetch_assoc($bookings_query)['total'];

$pending_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings WHERE user_id = $user_id AND status = 'pending'");
$pending_count = mysqli_fetch_assoc($pending_query)['total'];

$completed_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings WHERE user_id = $user_id AND status = 'completed'");
$completed_count = mysqli_fetch_assoc($completed_query)['total'];
?>

<h2><i class="fas fa-tachometer-alt"></i> User Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['name']; ?>!</p>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3><?php echo $bookings_count; ?></h3>
                <p>Total Bookings</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3><?php echo $pending_count; ?></h3>
                <p>Pending Bookings</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3><?php echo $completed_count; ?></h3>
                <p>Completed</p>
            </div>
        </div>
    </div>
</div>



<?php include '../includes/footer.php'; ?>