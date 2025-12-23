<?php include 'includes/header.php'; 

$service_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT s.*, c.name as category_name, u.name as provider_name, u.phone as provider_phone 
          FROM services s 
          JOIN categories c ON s.category_id = c.id 
          JOIN users u ON s.provider_id = u.id 
          WHERE s.id = $service_id";

$result = mysqli_query($conn, $query);
$service = mysqli_fetch_assoc($result);

if (!$service) {
    $_SESSION['error'] = "Service not found!";
    redirect('services.php');
}
?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <img src="assets/images/services/<?php echo $service['image'] ?? 'default.jpg'; ?>" class="card-img-top" style="max-height: 400px; object-fit: cover;">
            <div class="card-body">
                <span class="badge bg-primary"><?php echo $service['category_name']; ?></span>
                <h2 class="mt-2"><?php echo $service['title']; ?></h2>
                <p class="lead"><?php echo $service['description']; ?></p>
                
                <hr>
                
                <h5>Provider Information</h5>
                <p><i class="fas fa-user"></i> <?php echo $service['provider_name']; ?></p>
                <p><i class="fas fa-phone"></i> <?php echo $service['provider_phone']; ?></p>
            </div>
        </div>
        
        <!-- Reviews Section -->
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-star"></i> Customer Reviews</h5>
            </div>
            <div class="card-body">
                <?php
                $reviews_query = "SELECT r.*, u.name as user_name 
                                  FROM reviews r 
                                  JOIN users u ON r.user_id = u.id 
                                  JOIN bookings b ON r.booking_id = b.id 
                                  WHERE b.service_id = $service_id 
                                  ORDER BY r.created_at DESC LIMIT 5";
                $reviews = mysqli_query($conn, $reviews_query);
                
                if (mysqli_num_rows($reviews) > 0):
                    while ($review = mysqli_fetch_assoc($reviews)):
                ?>
                <div class="border-bottom pb-3 mb-3">
                    <strong><?php echo $review['user_name']; ?></strong>
                    <div class="rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?php echo $i <= $review['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <p><?php echo $review['comment']; ?></p>
                </div>
                <?php 
                    endwhile;
                else:
                ?>
                <p>No reviews yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-calendar"></i> Book This Service</h5>
            </div>
            <div class="card-body">
                <h3 class="text-success">₹<?php echo number_format($service['price']); ?></h3>
                
                <?php if (isLoggedIn() && $_SESSION['role'] == 'user'): ?>
                <form action="service-details.php?id=<?php echo $service_id; ?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Select Date</label>
                        <input type="date" name="booking_date" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Time</label>
                        <input type="time" name="booking_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Service Address</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Additional Notes</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" name="book_service" class="btn btn-success w-100">Book Now</button>
                </form>
                <?php elseif (!isLoggedIn()): ?>
                <p>Please <a href="login.php">login</a> to book this service.</p>
                <?php else: ?>
                <p>Only users can book services.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Handle Booking
if (isset($_POST['book_service'])) {
    $user_id = $_SESSION['user_id'];
    $provider_id = $service['provider_id'];
    $booking_date = clean($_POST['booking_date']);
    $booking_time = clean($_POST['booking_time']);
    $address = clean($_POST['address']);
    $notes = clean($_POST['notes']);
    $total_amount = $service['price'];
    
    $query = "INSERT INTO bookings (user_id, service_id, provider_id, booking_date, booking_time, address, total_amount, status) 
              VALUES ($user_id, $service_id, $provider_id, '$booking_date', '$booking_time', '$address', $total_amount, 'pending')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Booking successful! Provider will confirm shortly.";
        redirect('user/bookings.php');
    } else {
        $_SESSION['error'] = "Booking failed. Try again.";
    }
}
?>

<?php include 'includes/footer.php'; ?>