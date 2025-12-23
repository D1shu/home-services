<?php 
include '../config/config.php';
checkRole('user');

$user_id = $_SESSION['user_id'];

// Get user data
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle profile update
if (isset($_POST['update_profile'])) {
    $name = clean($_POST['name']);
    $phone = clean($_POST['phone']);
    $address = clean($_POST['address']);
    $city = clean($_POST['city']);
    
    // Handle profile image upload
    $profile_image = $user['profile_image'];
    
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "../assets/images/uploads/";
        
        // Create directory if not exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $new_filename = 'user_' . $user_id . '_' . time() . '.' . $file_extension;
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
                     WHERE id = $user_id";
    
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['name'] = $name; // Update session name
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
    
    // Verify current password
    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            if (strlen($new_password) >= 6) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $password_query = "UPDATE users SET password = '$hashed_password' WHERE id = $user_id";
                
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
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-edit"></i> Edit Profile</h5>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?php echo $user['name']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="<?php echo $user['email']; ?>" disabled>
                            <small class="text-muted">Email cannot be changed</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $user['phone']; ?>" placeholder="Enter phone number">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="<?php echo $user['city']; ?>" placeholder="Enter city">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Enter your full address"><?php echo $user['address']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control" accept="image/*">
                        <small class="text-muted">Allowed: JPG, JPEG, PNG, GIF (Max 2MB)</small>
                    </div>
                    <button type="submit" name="update_profile" class="btn btn-primary">
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
                $profile_img = $user['profile_image'];
                $img_path = "../assets/images/uploads/" . $profile_img;
                ?>
                <?php if (!empty($profile_img) && file_exists($img_path)): ?>
                    <img src="<?php echo $img_path; ?>" alt="Profile" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <?php else: ?>
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px; font-size: 60px;">
                        <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
                
                <h4><?php echo $user['name']; ?></h4>
                <p class="text-muted"><i class="fas fa-envelope"></i> <?php echo $user['email']; ?></p>
                
                <?php if (!empty($user['phone'])): ?>
                    <p class="text-muted"><i class="fas fa-phone"></i> <?php echo $user['phone']; ?></p>
                <?php endif; ?>
                
                <?php if (!empty($user['city'])): ?>
                    <p class="text-muted"><i class="fas fa-map-marker-alt"></i> <?php echo $user['city']; ?></p>
                <?php endif; ?>
                
                <hr>
                
                <p class="mb-1"><strong>Account Status:</strong></p>
                <span class="badge bg-<?php echo $user['status'] == 'active' ? 'success' : 'danger'; ?> fs-6">
                    <?php echo ucfirst($user['status']); ?>
                </span>
                
                <hr>
                
                <p class="mb-1"><strong>Member Since:</strong></p>
                <p class="text-muted"><?php echo date('d M Y', strtotime($user['created_at'])); ?></p>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-chart-bar"></i> My Statistics</h6>
            </div>
            <div class="card-body">
                <?php
                $total_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings WHERE user_id = $user_id"))['count'];
                $completed_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM bookings WHERE user_id = $user_id AND status = 'completed'"))['count'];
                $total_reviews = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM reviews WHERE user_id = $user_id"))['count'];
                ?>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total Bookings:</span>
                    <strong><?php echo $total_bookings; ?></strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Completed:</span>
                    <strong class="text-success"><?php echo $completed_bookings; ?></strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Reviews Given:</span>
                    <strong class="text-warning"><?php echo $total_reviews; ?></strong>
                </div>
            </div>
        </div>
    </div>
    
</div>

<?php include '../includes/footer.php'; ?>