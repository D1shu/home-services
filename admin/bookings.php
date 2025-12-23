<?php 
include '../config/config.php';
checkRole('admin');

// Handle Status Update
if (isset($_POST['update_status'])) {
    $booking_id = (int)$_POST['booking_id'];
    $status = clean($_POST['status']);
    
    $query = "UPDATE bookings SET status = '$status' WHERE id = $booking_id";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Booking status updated!";
    } else {
        $_SESSION['error'] = "Failed to update status.";
    }
    header("Location: bookings.php");
    exit();
}

// Handle Delete
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $booking_id = (int)$_GET['id'];
    
    // Delete related reviews first
    mysqli_query($conn, "DELETE FROM reviews WHERE booking_id = $booking_id");
    
    // Delete booking
    if (mysqli_query($conn, "DELETE FROM bookings WHERE id = $booking_id")) {
        $_SESSION['success'] = "Booking deleted!";
    } else {
        $_SESSION['error'] = "Failed to delete booking.";
    }
    header("Location: bookings.php");
    exit();
}

// Filter options
$status_filter = isset($_GET['status']) ? clean($_GET['status']) : '';
$date_filter = isset($_GET['date']) ? clean($_GET['date']) : '';
$search = isset($_GET['search']) ? clean($_GET['search']) : '';

// Build query
$where = "WHERE 1=1";
if (!empty($status_filter)) {
    $where .= " AND b.status = '$status_filter'";
}
if (!empty($date_filter)) {
    $where .= " AND b.booking_date = '$date_filter'";
}
if (!empty($search)) {
    $where .= " AND (u.name LIKE '%$search%' OR p.name LIKE '%$search%' OR s.title LIKE '%$search%')";
}

$query = "SELECT b.*, 
          u.name as user_name, u.email as user_email, u.phone as user_phone,
          p.name as provider_name, p.email as provider_email, p.phone as provider_phone,
          s.title as service_title, s.price as service_price
          FROM bookings b
          JOIN users u ON b.user_id = u.id
          JOIN users p ON b.provider_id = p.id
          JOIN services s ON b.service_id = s.id
          $where
          ORDER BY b.created_at DESC";

$bookings = mysqli_query($conn, $query);

include '../includes/header.php';
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-calendar-alt"></i> Manage Bookings</h2>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <?php
    $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings"))['count'];
    $pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings WHERE status = 'pending'"))['count'];
    $accepted = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings WHERE status = 'accepted'"))['count'];
    $completed = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings WHERE status = 'completed'"))['count'];
    $cancelled = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings WHERE status = 'cancelled'"))['count'];
    $revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total_amount), 0) as total FROM bookings WHERE status = 'completed'"))['total'];
    ?>
    <div class="col-md-2">
        <div class="card bg-primary text-white">
            <div class="card-body text-center py-3">
                <h4 class="mb-0"><?php echo $total; ?></h4>
                <small>Total</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-warning text-dark">
            <div class="card-body text-center py-3">
                <h4 class="mb-0"><?php echo $pending; ?></h4>
                <small>Pending</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-info text-white">
            <div class="card-body text-center py-3">
                <h4 class="mb-0"><?php echo $accepted; ?></h4>
                <small>Accepted</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-success text-white">
            <div class="card-body text-center py-3">
                <h4 class="mb-0"><?php echo $completed; ?></h4>
                <small>Completed</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-danger text-white">
            <div class="card-body text-center py-3">
                <h4 class="mb-0"><?php echo $cancelled; ?></h4>
                <small>Cancelled</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card bg-dark text-white">
            <div class="card-body text-center py-3">
                <h4 class="mb-0">₹<?php echo number_format($revenue); ?></h4>
                <small>Revenue</small>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control" placeholder="User, Provider or Service" value="<?php echo $search; ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="accepted" <?php echo $status_filter == 'accepted' ? 'selected' : ''; ?>>Accepted</option>
                    <option value="completed" <?php echo $status_filter == 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?php echo $status_filter == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Booking Date</label>
                <input type="date" name="date" class="form-control" value="<?php echo $date_filter; ?>">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="bookings.php" class="btn btn-secondary">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Bookings Table -->
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-list"></i> All Bookings</h5>
        <span class="badge bg-primary"><?php echo mysqli_num_rows($bookings); ?> records found</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Customer</th>
                        <th>Provider</th>
                        <th>Date & Time</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Booked On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $count = 1;
                    if (mysqli_num_rows($bookings) > 0):
                        while ($booking = mysqli_fetch_assoc($bookings)): 
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td>
                            <strong><?php echo $booking['service_title']; ?></strong>
                        </td>
                        <td>
                            <strong><?php echo $booking['user_name']; ?></strong><br>
                            <small class="text-muted">
                                <i class="fas fa-phone"></i> <?php echo $booking['user_phone']; ?>
                            </small>
                        </td>
                        <td>
                            <strong><?php echo $booking['provider_name']; ?></strong><br>
                            <small class="text-muted">
                                <i class="fas fa-phone"></i> <?php echo $booking['provider_phone']; ?>
                            </small>
                        </td>
                        <td>
                            <i class="fas fa-calendar text-primary"></i> <?php echo date('d M Y', strtotime($booking['booking_date'])); ?><br>
                            <i class="fas fa-clock text-info"></i> <?php echo date('h:i A', strtotime($booking['booking_time'])); ?>
                        </td>
                        <td>
                            <strong class="text-success">₹<?php echo number_format($booking['total_amount']); ?></strong>
                        </td>
                        <td>
                            <?php
                            $status_colors = [
                                'pending' => 'warning',
                                'accepted' => 'info',
                                'completed' => 'success',
                                'cancelled' => 'danger'
                            ];
                            $color = $status_colors[$booking['status']] ?? 'secondary';
                            ?>
                            <span class="badge bg-<?php echo $color; ?>">
                                <?php echo ucfirst($booking['status']); ?>
                            </span>
                        </td>
                        <td>
                            <?php echo date('d M Y', strtotime($booking['created_at'])); ?><br>
                            <small class="text-muted"><?php echo date('h:i A', strtotime($booking['created_at'])); ?></small>
                        </td>
                        <td>
                            <!-- View Details -->
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $booking['id']; ?>">
                                <i class="fas fa-eye"></i>
                            </button>
                            
                            <!-- Update Status -->
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#statusModal<?php echo $booking['id']; ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <!-- Delete -->
                            <a href="?action=delete&id=<?php echo $booking['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this booking? This cannot be undone.')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    
                    <!-- View Details Modal -->
                    <div class="modal fade" id="viewModal<?php echo $booking['id']; ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title"><i class="fas fa-eye"></i> Booking Details #<?php echo $booking['id']; ?></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-primary"><i class="fas fa-concierge-bell"></i> Service Information</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>Service:</th>
                                                    <td><?php echo $booking['service_title']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Amount:</th>
                                                    <td><strong class="text-success">₹<?php echo number_format($booking['total_amount']); ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <th>Date:</th>
                                                    <td><?php echo date('d M Y', strtotime($booking['booking_date'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Time:</th>
                                                    <td><?php echo date('h:i A', strtotime($booking['booking_time'])); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status:</th>
                                                    <td><span class="badge bg-<?php echo $color; ?>"><?php echo ucfirst($booking['status']); ?></span></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-primary"><i class="fas fa-user"></i> Customer Information</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>Name:</th>
                                                    <td><?php echo $booking['user_name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Email:</th>
                                                    <td><?php echo $booking['user_email']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Phone:</th>
                                                    <td><?php echo $booking['user_phone']; ?></td>
                                                </tr>
                                            </table>
                                            
                                            <h6 class="text-primary mt-3"><i class="fas fa-user-tie"></i> Provider Information</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>Name:</th>
                                                    <td><?php echo $booking['provider_name']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Email:</th>
                                                    <td><?php echo $booking['provider_email']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Phone:</th>
                                                    <td><?php echo $booking['provider_phone']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <h6 class="text-primary mt-3"><i class="fas fa-map-marker-alt"></i> Service Address</h6>
                                    <p class="bg-light p-3 rounded"><?php echo $booking['address']; ?></p>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Booked On:</strong> <?php echo date('d M Y h:i A', strtotime($booking['created_at'])); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Update Status Modal -->
                    <div class="modal fade" id="statusModal<?php echo $booking['id']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title"><i class="fas fa-edit"></i> Update Booking Status</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="" method="POST">
                                    <div class="modal-body">
                                        <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                        
                                        <p><strong>Service:</strong> <?php echo $booking['service_title']; ?></p>
                                        <p><strong>Customer:</strong> <?php echo $booking['user_name']; ?></p>
                                        <p><strong>Current Status:</strong> 
                                            <span class="badge bg-<?php echo $color; ?>"><?php echo ucfirst($booking['status']); ?></span>
                                        </p>
                                        
                                        <hr>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Change Status To:</label>
                                            <select name="status" class="form-select" required>
                                                <option value="pending" <?php echo $booking['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="accepted" <?php echo $booking['status'] == 'accepted' ? 'selected' : ''; ?>>Accepted</option>
                                                <option value="completed" <?php echo $booking['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                                <option value="cancelled" <?php echo $booking['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="update_status" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Status
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <?php 
                        endwhile;
                    else:
                    ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                            <p>No bookings found.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>