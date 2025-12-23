<?php include 'includes/header.php'; ?>

<!-- Services Section -->
<section style="background: var(--secondary-50);">
    <div class="container">
        <h2 class="section-title">🛠️ Our Services</h2>
        <p class="section-subtitle">Find the perfect service for your home needs</p>

        <!-- Search & Filter -->
        <div style="background: white; padding: 24px; border-radius: var(--radius-2xl); box-shadow: var(--shadow-md); margin-bottom: 32px;">
            <form action="" method="GET" style="display: flex; gap: 16px; align-items: center; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 200px;">
                    <div class="form-input-icon">
                        <i data-lucide="search"></i>
                        <input type="text" name="search" class="form-input" placeholder="Search services..." value="<?php echo $_GET['search'] ?? ''; ?>">
                    </div>
                </div>
                <div style="min-width: 200px;">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <?php
                        $categories = mysqli_query($conn, "SELECT * FROM categories WHERE status = 'active'");
                        while ($cat = mysqli_fetch_assoc($categories)):
                        ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : ''; ?>>
                            <?php echo $cat['name']; ?>
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="search" style="width:18px;height:18px"></i>
                    Search
                </button>
            </form>
        </div>

        <!-- Services List -->
        <div class="services-grid">
            <?php
            $where = "WHERE s.status = 'active'";

            if (!empty($_GET['search'])) {
                $search = clean($_GET['search']);
                $where .= " AND (s.title LIKE '%$search%' OR s.description LIKE '%$search%')";
            }

            if (!empty($_GET['category'])) {
                $category = clean($_GET['category']);
                $where .= " AND s.category_id = $category";
            }

            $query = "SELECT s.*, c.name as category_name, u.name as provider_name
                      FROM services s
                      JOIN categories c ON s.category_id = c.id
                      JOIN users u ON s.provider_id = u.id
                      $where
                      ORDER BY s.created_at DESC";

            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0):
                while ($service = mysqli_fetch_assoc($result)):
            ?>
            <div class="service-card">
                <div class="service-icon">
                    <i data-lucide="wrench" style="width:28px;height:28px"></i>
                </div>
                <span class="badge badge-primary" style="align-self: flex-start;"><?php echo $service['category_name']; ?></span>
                <h3><?php echo $service['title']; ?></h3>
                <p><?php echo substr($service['description'], 0, 100); ?>...</p>
                <div class="service-rating">
                    <div class="stars">
                        <i data-lucide="star" style="width:16px;height:16px;fill:currentColor"></i>
                        <i data-lucide="star" style="width:16px;height:16px;fill:currentColor"></i>
                        <i data-lucide="star" style="width:16px;height:16px;fill:currentColor"></i>
                        <i data-lucide="star" style="width:16px;height:16px;fill:currentColor"></i>
                        <i data-lucide="star" style="width:16px;height:16px;fill:currentColor"></i>
                    </div>
                    4.9 (2.3k reviews)
                </div>
                <div class="service-price">
                    <span class="price-label">By <?php echo $service['provider_name']; ?></span>
                    <span class="price-value">₹<?php echo number_format($service['price']); ?> <span>/service</span></span>
                </div>
                <a href="service-details.php?id=<?php echo $service['id']; ?>" class="btn btn-primary" style="width: 100%; margin-top: 16px;">
                    <i data-lucide="eye" style="width:18px;height:18px"></i>
                    View Details
                </a>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px;">
                <div style="background: white; padding: 40px; border-radius: var(--radius-2xl); box-shadow: var(--shadow-md);">
                    <i data-lucide="search-x" style="width:48px;height:48px;color:var(--secondary-400);margin-bottom:16px;"></i>
                    <h3 style="color: var(--secondary-600); margin-bottom: 8px;">No services found</h3>
                    <p style="color: var(--secondary-500);">Try adjusting your search criteria or browse all services.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
