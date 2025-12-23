<?php 
include '../config/config.php';
checkRole('admin');

// Handle Add Category
if (isset($_POST['add_category'])) {
    $name = clean($_POST['name']);
    $description = clean($_POST['description']);
    
    // Handle image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../assets/images/icons/";
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_filename = strtolower(str_replace(' ', '_', $name)) . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($file_extension), $allowed_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image = $new_filename;
            }
        }
    }
    
    $query = "INSERT INTO categories (name, description, image, status) VALUES ('$name', '$description', '$image', 'active')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Category added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add category.";
    }
    header("Location: categories.php");
    exit();
}

// Handle Edit Category
if (isset($_POST['edit_category'])) {
    $id = (int)$_POST['category_id'];
    $name = clean($_POST['name']);
    $description = clean($_POST['description']);
    
    // Get current image
    $current = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM categories WHERE id = $id"));
    $image = $current['image'];
    
    // Handle new image upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../assets/images/icons/";
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_filename = strtolower(str_replace(' ', '_', $name)) . '_' . time() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array(strtolower($file_extension), $allowed_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image = $new_filename;
            }
        }
    }
    
    $query = "UPDATE categories SET name = '$name', description = '$description', image = '$image' WHERE id = $id";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Category updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update category.";
    }
    header("Location: categories.php");
    exit();
}

// Handle Status Change
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'activate') {
        mysqli_query($conn, "UPDATE categories SET status = 'active' WHERE id = $id");
        $_SESSION['success'] = "Category activated!";
    } elseif ($action == 'deactivate') {
        mysqli_query($conn, "UPDATE categories SET status = 'inactive' WHERE id = $id");
        $_SESSION['success'] = "Category deactivated!";
    } elseif ($action == 'delete') {
        // Check if category has services
        $check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM services WHERE category_id = $id"));
        if ($check['count'] > 0) {
            $_SESSION['error'] = "Cannot delete! This category has " . $check['count'] . " services.";
        } else {
            mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
            $_SESSION['success'] = "Category deleted!";
        }
    }
    header("Location: categories.php");
    exit();
}

// Get all categories
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY created_at DESC");

include '../includes/header.php';
?>

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-th-large"></i> Manage Categories</h2>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fas fa-plus"></i> Add Category
        </button>
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <?php
    $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM categories"))['count'];
    $active = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM categories WHERE status = 'active'"))['count'];
    $inactive = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM categories WHERE status = 'inactive'"))['count'];
    ?>
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3><?php echo $total; ?></h3>
                <p class="mb-0">Total Categories</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3><?php echo $active; ?></h3>
                <p class="mb-0">Active</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h3><?php echo $inactive; ?></h3>
                <p class="mb-0">Inactive</p>
            </div>
        </div>
    </div>
</div>

<!-- Categories Table -->
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="fas fa-list"></i> All Categories</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Services</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $count = 1;
                    if (mysqli_num_rows($categories) > 0):
                        while ($category = mysqli_fetch_assoc($categories)): 
                            // Count services in this category
                            $services_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM services WHERE category_id = " . $category['id']))['count'];
                    ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td>
                            <?php if (!empty($category['image'])): ?>
                                <img src="../assets/images/icons/<?php echo $category['image']; ?>" alt="" style="width: 50px; height: 50px; object-fit: contain;">
                            <?php else: ?>
                                <i class="fas fa-image fa-2x text-muted"></i>
                            <?php endif; ?>
                        </td>
                        <td><strong><?php echo $category['name']; ?></strong></td>
                        <td><?php echo substr($category['description'], 0, 50); ?>...</td>
                        <td>
                            <span class="badge bg-info"><?php echo $services_count; ?> services</span>
                        </td>
                        <td>
                            <?php if ($category['status'] == 'active'): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('d M Y', strtotime($category['created_at'])); ?></td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal<?php echo $category['id']; ?>">
                                <i class="fas fa-edit"></i>
                            </button>
                            
                            <!-- Status Toggle -->
                            <?php if ($category['status'] == 'active'): ?>
                                <a href="?action=deactivate&id=<?php echo $category['id']; ?>" class="btn btn-sm btn-warning" onclick="return confirm('Deactivate this category?')">
                                    <i class="fas fa-ban"></i>
                                </a>
                            <?php else: ?>
                                <a href="?action=activate&id=<?php echo $category['id']; ?>" class="btn btn-sm btn-success">
                                    <i class="fas fa-check"></i>
                                </a>
                            <?php endif; ?>
                            
                            <!-- Delete Button -->
                            <a href="?action=delete&id=<?php echo $category['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category? This cannot be undone.')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    
                    <!-- Edit Category Modal -->
                    <div class="modal fade" id="editCategoryModal<?php echo $category['id']; ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title"><i class="fas fa-edit"></i> Edit Category</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" value="<?php echo $category['name']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" rows="3"><?php echo $category['description']; ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Category Icon/Image</label>
                                            <?php if (!empty($category['image'])): ?>
                                                <div class="mb-2">
                                                    <img src="../assets/images/icons/<?php echo $category['image']; ?>" alt="" style="width: 60px; height: 60px; object-fit: contain;">
                                                    <small class="text-muted d-block">Current Image</small>
                                                </div>
                                            <?php endif; ?>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                            <small class="text-muted">Leave empty to keep current image</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="edit_category" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Category
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
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open fa-3x mb-3"></i>
                            <p>No categories found. Add your first category!</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Add New Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., Plumbing, Electrical" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Brief description of this category"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category Icon/Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Recommended: PNG with transparent background (100x100 px)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_category" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>