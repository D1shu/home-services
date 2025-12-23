<?php 
include '../includes/header.php';
checkRole('user');

$user_id = $_SESSION['user_id'];

$query = "SELECT b.*, s.title as service_title, s.price, u.name as provider_name 
          FROM bookings b 
          JOIN services s ON b.service_id = s.id 
          JOIN users u ON b.provider_id = u.id 
          WHERE b.user_id = $user_id 
          ORDER BY b.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<h2><i class="fas fa-calendar-check"></i> My Bookings</h2>

<div class="table-responsive mt-4">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Service</th>
                <th>Provider</th>
                <th>Date & Time</th>
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
                <td><?php echo $booking['provider_name']; ?></td>
                <td><?php echo date('d M Y', strtotime($booking['booking_date'])); ?> at <?php echo date('h:i A', strtotime($booking['booking_time'])); ?></td>
                <td>₹<?php echo number_format($booking['total_amount']); ?></td>
                <td>
                    <?php
                    $status_class = [
                        'pending' => 'warning',
                        'accepted' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger'
                    ];
                    ?>
                    <span class="badge bg-<?php echo $status_class[$booking['status']]; ?>">
                        <?php echo ucfirst($booking['status']); ?>
                    </span>
                </td>
                <td>
                    <?php if ($booking['status'] == 'completed'): ?>
                    <a href="add-review.php?booking_id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-star"></i> Review
                    </a>
                    <?php elseif ($booking['status'] == 'pending'): ?>
                    <a href="cancel-booking.php?id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Cancel this booking?')">
                        Cancel
                    </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>