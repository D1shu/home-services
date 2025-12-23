<?php 
include '../includes/header.php';
checkRole('admin');

// Get stats
$users_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'user'");
$users_count = mysqli_fetch_assoc($users_query)['total'];

$providers_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'provider'");
$providers_count = mysqli_fetch_assoc($providers_query)['total'];

$services_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM services");
$services_count = mysqli_fetch_assoc($services_query)['total'];

$bookings_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM bookings");
$bookings_count = mysqli_fetch_assoc($bookings_query)['total'];

$revenue_query = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM bookings WHERE status = 'completed'");
$revenue = mysqli_fetch_assoc($revenue_query)['total'] ?? 0;

$pending_providers = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'provider' AND status = 'pending'");
$pending_count = mysqli_fetch_assoc($pending_providers)['total'];
?>

<h2><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3><?php echo $users_count; ?></h3>
                <p>Total Users</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3><?php echo $providers_count; ?></h3>
                <p>Total Providers</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3><?php echo $services_count; ?></h3>
                <p>Total Services</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3><?php echo $bookings_count; ?></h3>
                <p>Total Bookings</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h3><?php echo $pending_count; ?></h3>
                <p>Pending Approvals</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-dark text-white">
            <div class="card-body text-center">
                <h3>₹<?php echo number_format($revenue); ?></h3>
                <p>Total Revenue</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <h4>Quick Actions</h4>
    <a href="users.php" class="btn btn-primary">Manage Users</a>
    <a href="providers.php" class="btn btn-success">Manage Providers</a>
    <a href="categories.php" class="btn btn-info">Categories</a>
    <a href="bookings.php" class="btn btn-warning">Bookings</a>
</div>

<?php include '../includes/footer.php'; ?>