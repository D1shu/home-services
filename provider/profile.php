<?php 
include '../config/config.php';
checkRole('provider');

$provider_id = $_SESSION['user_id'];

// Get provider data
$query = "SELECT * FROM users WHERE id = $provider_id";
$result = mysqli_query($conn, $query);
$provider = mysqli_fetch_assoc($result);

// Handle profile update
if (isset($_POST['update_profile'])) {
    $name = clean($_POST['name']);
    $phone = clean($_POST['phone']);
    $address = clean($_POST['address']);
    $city = clean($_POST['city']);
    
    // Handle profile image upload
    $profile_image = $provider['profile_image'];
    
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "../assets/images/uploads/";
        
        // Create directory if not exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $new_filename = 'provider_' . $provider_id . '_' . time() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        // Check if image file
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($file_extension), $allowed_types)) {
            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
                $profile_image = $new_filename;
            }
        }
    }
    
    $update_query = "UPDATE users SET 
                     name = '$name', 
                     phone = '$phone', 
                     address = '$address', 
                     city = '$city',
                     profile_image = '$profile_image'
                     WHERE id = $provider_id";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['name'] = $name;
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update profile.";
    }
}

// Handle password change
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if (password_verify($current_password, $provider['password'])) {
        if ($new_password === $confirm_password) {
            if (strlen($new_password) >= 6) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $password_query = "UPDATE users SET password = '$hashed_password' WHERE id = $provider_id";
                
                if (mysqli_query($conn, $password_query)) {
                    $_SESSION['success'] = "Password changed successfully!";
                    header("Location: profile.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Failed to change password.";
                }
            } else {
                $_SESSION['error'] = "Password must be at least 6 characters.";
            }
        } else {
            $_SESSION['error'] = "New passwords do not match.";
        }
    } else {
        $_SESSION['error'] = "Current password is incorrect.";
    }
}

include '../includes/header.php';
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-circle"></i> My Profile</h2>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="row">
    
    <!-- Profile Information -->
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-user-edit"></i> Edit Profile</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?php echo $provider['name']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="<?php echo $provider['email']; ?>" disabled>
                            <small class="text-muted">Email cannot be changed</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $provider['phone']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" value="<?php echo $provider['city']; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Business Address <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" rows="3" required><?php echo $provider['address']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control" accept="image/*">
                        <small class="text-muted">Allowed: JPG, JPEG, PNG, GIF (Max 2MB)</small>
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-success">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Change Password -->
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="fas fa-key"></i> Change Password</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" name="new_password" class="form-control" minlength="6" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" name="confirm_password" class="form-control" minlength="6" required>
                        </div>
                    </div>
                    <button type="submit" name="change_password" class="btn btn-warning">
                        <i class="fas fa-lock"></i> Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <?php 
                $profile_img = $provider['profile_image'];
                $img_path = "../assets/images/uploads/" . $profile_img;
                ?>
                <?php if (!empty($profile_img) && file_exists($img_path)): ?>
                    <img src="<?php echo $img_path; ?>" alt="Profile" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <?php else: ?>
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px; font-size: 60px;">
                        <?php echo strtoupper(substr($provider['name'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
                
                <h4><?php echo $provider['name']; ?></h4>
                <span class="badge bg-success mb-2">Service Provider</span>
                <p class="text-muted"><i class="fas fa-envelope"></i> <?php echo $provider['email']; ?></p>
                
                <?php if (!empty($provider['phone'])): ?>
                    <p class="text-muted"><i class="fas fa-phone"></i> <?php echo $provider['phone']; ?></p>
                <?php endif; ?>
                
                <?php if (!empty($provider['city'])): ?>
                    <p class="text-muted"><i class="fas fa-map-marker-alt"></i> <?php echo $provider['city']; ?></p>
                <?php endif; ?>
                
                <hr>
                
                <p class="mb-1"><strong>Account Status:</strong></p>
                <span class="badge bg-<?php echo $provider['status'] == 'active' ? 'success' : ($provider['status'] == 'pending' ? 'warning' : 'danger'); ?> fs-6">
                    <?php echo ucfirst($provider['status']); ?>
                </span>
                
                <?php if ($provider['status'] == 'pending'): ?>
                    <p class="text-warning mt-2"><small><i class="fas fa-info-circle"></i> Waiting for admin approval</small></p>
                <?php endif; ?>
                
                <hr>
                
                <p class="mb-1"><strong>Member Since:</strong></p>
                <p class="text-muted"><?php echo date('d M Y', strtotime($provider['created_at'])); ?></p>
            </div>
        </div>
        
        <!-- Provider Stats -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-chart-bar"></i> My Statistics</h6>
            </div>
            <div class="card-body">
                <?php
                $total_services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM services WHERE provider_id = $provider_id"))['count'];
                $total_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings WHERE provider_id = $provider_id"))['count'];
                $completed_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings WHERE provider_id = $provider_id AND status = 'completed'"))['count'];
                $total_earnings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total_amount), 0) as total FROM bookings WHERE provider_id = $provider_id AND status = 'completed'"))['total'];
                $avg_rating = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(AVG(rating), 0) as avg FROM reviews WHERE provider_id = $provider_id"))['avg'];
                $total_reviews = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM reviews WHERE provider_id = $provider_id"))['count'];
                ?>
                <div class="d-flex justify-content-between mb-2">
                    <span>My Services:</span>
                    <strong><?php echo $total_services; ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Bookings:</span>
                    <strong><?php echo $total_bookings; ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Completed Jobs:</span>
                    <strong class="text-success"><?php echo $completed_bookings; ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Earnings:</span>
                    <strong class="text-success">₹<?php echo number_format($total_earnings); ?></strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Average Rating:</span>
                    <strong class="text-warning">
                        <i class="fas fa-star"></i> <?php echo number_format($avg_rating, 1); ?>/5
                    </strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Total Reviews:</span>
                    <strong><?php echo $total_reviews; ?></strong>
                </div>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0"><i class="fas fa-link"></i> Quick Links</h6>
            </div>
            <div class="card-body">
                <a href="services.php" class="btn btn-outline-primary w-100 mb-2">
                    <i class="fas fa-concierge-bell"></i> My Services
                </a>
                <a href="add-service.php" class="btn btn-outline-success w-100 mb-2">
                    <i class="fas fa-plus"></i> Add New Service
                </a>
                <a href="bookings.php" class="btn btn-outline-info w-100 mb-2">
                    <i class="fas fa-calendar"></i> Booking Requests
                </a>
                <a href="earnings.php" class="btn btn-outline-warning w-100">
                    <i class="fas fa-wallet"></i> My Earnings
                </a>
            </div>
        </div>
    </div>
    
</div>

<?php include '../includes/footer.php'; ?>