<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Your Trusted Partner for <span>Home Services</span></h1>
            <p>Book professional plumbers, electricians, cleaners and more — all vetted, reliable, and just a tap away.</p>

            <div class="hero-actions">
                <a href="services.php" class="btn btn-primary btn-lg">
                    <i data-lucide="search" style="width:20px;height:20px"></i>
                    Find Services
                </a>
                <a href="how-it-works.php" class="btn btn-secondary btn-lg">
                    <i data-lucide="play-circle" style="width:20px;height:20px"></i>
                    How It Works
                </a>
            </div>

            <div class="hero-stats">
                <div class="stat">
                    <h3>50K+</h3>
                    <p>Happy Customers</p>
                </div>
                <div class="stat">
                    <h3>2K+</h3>
                    <p>Verified Pros</p>
                </div>
                <div class="stat">
                    <h3>4.9</h3>
                    <p>Average Rating</p>
                </div>
            </div>
        </div>

        <div class="hero-image">
            <div class="hero-card">
                <div class="hero-card-header">
                    <h3 class="hero-card-title">Upcoming Service</h3>
                    <span class="status-badge">
                        <i data-lucide="check-circle" style="width:14px;height:14px"></i>
                        Confirmed
                    </span>
                </div>

                <div class="service-preview">
                    <div class="service-preview-item">
                        <div class="service-preview-icon">
                            <i data-lucide="wrench" style="width:24px;height:24px"></i>
                        </div>
                        <div class="service-preview-info">
                            <h4>Plumbing Repair</h4>
                            <p>Today, 2:00 PM — John D.</p>
                        </div>
                    </div>

                    <div class="service-preview-item">
                        <div class="service-preview-icon" style="background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); color: var(--accent-600);">
                            <i data-lucide="zap" style="width:24px;height:24px"></i>
                        </div>
                        <div class="service-preview-info">
                            <h4>Electrical Check</h4>
                            <p>Tomorrow, 10:00 AM — Sarah M.</p>
                        </div>
                    </div>

                    <div class="service-preview-item">
                        <div class="service-preview-icon" style="background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%); color: #059669;">
                            <i data-lucide="sparkles" style="width:24px;height:24px"></i>
                        </div>
                        <div class="service-preview-info">
                            <h4>Deep Cleaning</h4>
                            <p>Friday, 9:00 AM — Maria L.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section style="background: white;">
    <div class="container">
        <h2 class="section-title text-center">Our Service Categories</h2>
        <p class="section-subtitle text-center">Choose from our wide range of professional home services</p>

        <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
            <?php
            $query = "SELECT * FROM categories WHERE status = 'active' LIMIT 6";
            $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) > 0):
                while ($category = mysqli_fetch_assoc($result)):
            ?>
            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--primary-100) 0%, var(--primary-200) 100%);">
                    <i data-lucide="wrench" style="width:32px;height:32px"></i>
                </div>
                <h3><?php echo $category['name']; ?></h3>
                <p><?php echo $category['description']; ?></p>
                <a href="services.php?category=<?php echo $category['id']; ?>" class="btn btn-primary" style="margin-top: 16px;">
                    <i data-lucide="arrow-right" style="width:18px;height:18px"></i>
                    View Services
                </a>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px;">
                <div style="background: white; padding: 40px; border-radius: var(--radius-2xl); box-shadow: var(--shadow-md);">
                    <i data-lucide="folder-x" style="width:48px;height:48px;color:var(--secondary-400);margin-bottom:16px;"></i>
                    <h3 style="color: var(--secondary-600); margin-bottom: 8px;">No categories found</h3>
                    <p style="color: var(--secondary-500);">Categories will be available soon.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section style="background: white;">
    <div class="container">
        <h2 class="section-title text-center">How It Works</h2>
        <p class="section-subtitle text-center">Get professional home services in three simple steps</p>

        <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--primary-100) 0%, var(--primary-200) 100%);">
                    <i data-lucide="search" style="width:28px;height:28px"></i>
                </div>
                <h3>1. Search Service</h3>
                <p>Browse through our wide range of home services and find the perfect match for your needs.</p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--accent-300) 0%, var(--accent-400) 100%); color: var(--accent-600);">
                    <i data-lucide="calendar" style="width:28px;height:28px"></i>
                </div>
                <h3>2. Book Appointment</h3>
                <p>Select your preferred date and time, and book with our verified professionals.</p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--success-100) 0%, #A7F3D0 100%); color: #059669;">
                    <i data-lucide="check-circle" style="width:28px;height:28px"></i>
                </div>
                <h3>3. Get Service Done</h3>
                <p>Relax while our verified professional arrives at your doorstep and completes the job.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- Initialize Lucide Icons -->
<script>
    lucide.createIcons();
</script>
