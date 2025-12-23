<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Your <span>Safety</span> First</h1>
            <p>We prioritize your safety with vetted professionals and strict protocols.</p>
        </div>
    </div>
</section>

<!-- Safety Guidelines Section -->
<section style="background: white;">
    <div class="container">
        <h2 class="section-title text-center">Safety Guidelines</h2>
        <p class="section-subtitle text-center">Our commitment to your safety</p>

        <div class="services-grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--primary-100) 0%, var(--primary-200) 100%);">
                    <i data-lucide="shield" style="width:32px;height:32px"></i>
                </div>
                <h3>Vetted Professionals</h3>
                <p>All our service providers undergo thorough background checks and skill verification.</p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--accent-300) 0%, var(--accent-400) 100%); color: var(--accent-600);">
                    <i data-lucide="check-circle" style="width:32px;height:32px"></i>
                </div>
                <h3>Quality Assurance</h3>
                <p>We maintain high standards through regular performance reviews and customer feedback.</p>
            </div>

            <div class="service-card text-center">
                <div class="service-icon" style="background: linear-gradient(135deg, var(--success-100) 0%, #A7F3D0 100%); color: #059669;">
                    <i data-lucide="lock" style="width:32px;height:32px"></i>
                </div>
                <h3>Secure Platform</h3>
                <p>Your data and transactions are protected with industry-standard security measures.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- Initialize Lucide Icons -->
<script>
    lucide.createIcons();
</script>
