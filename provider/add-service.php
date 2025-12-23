<?php 
include '../includes/header.php';
checkRole('provider');

$categories = mysqli_query($conn, "SELECT * FROM categories WHERE status = 'active'");
?>

<h2><i class="fas fa-plus"></i> Add New Service</h2>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Service Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>
                            <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Price (₹)</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Service Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <button type="submit" name="add_service" class="btn btn-primary">Add Service</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['add_service'])) {
    $provider_id = $_SESSION['user_id'];
    $title = clean($_POST['title']);
    $category_id = clean($_POST['category_id']);
    $description = clean($_POST['description']);
    $price = clean($_POST['price']);
    
    // Handle image upload
    $image = 'default.jpg';
    if ($_FILES['image']['name']) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/services/' . $image);
    }
    
    $query = "INSERT INTO services (provider_id, category_id, title, description, price, image, status) 
              VALUES ($provider_id, $category_id, '$title', '$description', $price, '$image', 'active')";
    
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Service added successfully!";
        redirect('provider/services.php');
    } else {
        $_SESSION['error'] = "Failed to add service.";
    }
}
?>

<?php include '../includes/footer.php'; ?>