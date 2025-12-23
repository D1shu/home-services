<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>How It <span>Works</span></h1>
            <p>Get professional home services in three simple steps — easy, reliable, and hassle-free.</p>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section style="background: white;">
    <div class="container">
        <h2 class="section-title text-center">Our Process</h2>
        <p class="section-subtitle text-center">Follow these three simple steps to get your home services done</p>

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
