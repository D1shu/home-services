<?php 
include '../includes/header.php';
checkRole('provider');

$provider_id = $_SESSION['user_id'];

// Handle status update
if (isset($_GET['action']) && isset($_GET['id'])) {
    $booking_id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'accept') {
        mysqli_query($conn, "UPDATE bookings SET status = 'accepted' WHERE id = $booking_id AND provider_id = $provider_id");
        $_SESSION['success'] = "Booking accepted!";
    } elseif ($action == 'complete') {
        mysqli_query($conn, "UPDATE bookings SET status = 'completed' WHERE id = $booking_id AND provider_id = $provider_id");
        $_SESSION['success'] = "Booking marked as completed!";
    } elseif ($action == 'cancel') {
        mysqli_query($conn, "UPDATE bookings SET status = 'cancelled' WHERE id = $booking_id AND provider_id = $provider_id");
        $_SESSION['success'] = "Booking cancelled!";
    }
    redirect('provider/bookings.php');
}

$query = "SELECT b.*, s.title as service_title, u.name as user_name, u.phone as user_phone 
          FROM bookings b 
          JOIN services s ON b.service_id = s.id 
          JOIN users u ON b.user_id = u.id 
          WHERE b.provider_id = $provider_id 
          ORDER BY b.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<h2><i class="fas fa-calendar"></i> Booking Requests</h2>

<div class="table-responsive mt-4">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Service</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Date & Time</th>
                <th>Address</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $count = 1;
            while ($booking = mysqli_fetch_assoc($result)): 
            ?>
            <tr>
                <td><?php echo $count++; ?></td>
                <td><?php echo $booking['service_title']; ?></td>
                <td><?php echo $booking['user_name']; ?></td>
                <td><?php echo $booking['user_phone']; ?></td>
                <td><?php echo date('d M Y', strtotime($booking['booking_date'])); ?><br><?php echo date('h:i A', strtotime($booking['booking_time'])); ?></td>
                <td><?php echo substr($booking['address'], 0, 30); ?>...</td>
                <td>₹<?php echo number_format($booking['total_amount']); ?></td>
                <td>
                    <span class="badge bg-<?php echo $booking['status'] == 'pending' ? 'warning' : ($booking['status'] == 'accepted' ? 'info' : ($booking['status'] == 'completed' ? 'success' : 'danger')); ?>">
                        <?php echo ucfirst($booking['status']); ?>
                    </span>
                </td>
                <td>
                    <?php if ($booking['status'] == 'pending'): ?>
                    <a href="?action=accept&id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-success">Accept</a>
                    <a href="?action=cancel&id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-danger">Reject</a>
                    <?php elseif ($booking['status'] == 'accepted'): ?>
                    <a href="?action=complete&id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-primary">Complete</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>