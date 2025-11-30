<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .about-hero {
            background: var(--gradient-hero);
            color: white;
            padding: 120px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .about-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
        }

        .about-hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .about-hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .about-hero p {
            font-size: 1.3rem;
            opacity: 0.95;
            line-height: 1.8;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px;
        }

        .about-section {
            margin-bottom: 80px;
        }

        .about-section h2 {
            font-size: 2.5rem;
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 30px;
            text-align: center;
        }

        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .about-content.reverse {
            grid-template-columns: 1fr 1fr;
        }

        .about-content.reverse .about-text {
            order: 2;
        }

        .about-content.reverse .about-image {
            order: 1;
        }

        .about-text {
            color: var(--text);
            line-height: 1.8;
        }

        .about-text p {
            margin-bottom: 20px;
            font-size: 1.05rem;
        }

        .about-text ul {
            margin: 20px 0;
            padding-left: 25px;
        }

        .about-text li {
            margin-bottom: 12px;
            font-size: 1.05rem;
        }

        .about-image {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 214, 160, 0.1) 100%);
            border-radius: 20px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .value-card {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .value-card:hover {
            border-color: var(--primary);
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(124, 58, 237, 0.2);
        }

        .value-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .value-card h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .value-card p {
            color: var(--text-light);
            line-height: 1.7;
        }

        .stats-section {
            background: var(--gradient-primary);
            color: white;
            padding: 80px 20px;
            margin: 80px 0;
            border-radius: 30px;
            box-shadow: 0 20px 60px rgba(124, 58, 237, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 10px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .stat-label {
            font-size: 1.2rem;
            opacity: 0.95;
            font-weight: 600;
        }

        .team-section {
            text-align: center;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 40px;
            margin-top: 50px;
        }

        .team-member {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(124, 58, 237, 0.2);
        }

        .team-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.3);
        }

        .team-member h3 {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .team-role {
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 15px;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }

        .team-bio {
            color: var(--text-light);
            line-height: 1.7;
            font-size: 0.95rem;
        }

        .timeline-section {
            position: relative;
            padding: 50px 0;
        }

        .timeline {
            position: relative;
            max-width: 800px;
            margin: 0 auto;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 4px;
            background: var(--gradient-primary);
            transform: translateX(-50%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 50px;
            display: flex;
            align-items: center;
        }

        .timeline-item:nth-child(odd) {
            flex-direction: row;
        }

        .timeline-item:nth-child(even) {
            flex-direction: row-reverse;
        }

        .timeline-content {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 45%;
            position: relative;
        }

        .timeline-year {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gradient-primary);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.4);
        }

        .timeline-content h3 {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .timeline-content p {
            color: var(--text-light);
            line-height: 1.7;
        }

        @media (max-width: 968px) {
            .about-content {
                grid-template-columns: 1fr;
            }

            .about-content.reverse .about-text,
            .about-content.reverse .about-image {
                order: 0;
            }

            .timeline::before {
                left: 30px;
            }

            .timeline-item {
                flex-direction: column !important;
                align-items: flex-start;
                padding-left: 60px;
            }

            .timeline-content {
                width: 100%;
            }

            .timeline-year {
                left: 30px;
                transform: translateX(-50%);
            }
        }

        @media (max-width: 768px) {
            .about-hero h1 {
                font-size: 2.5rem;
            }

            .about-hero p {
                font-size: 1.1rem;
            }

            .about-section h2 {
                font-size: 2rem;
            }

            .stat-number {
                font-size: 3rem;
            }

            .stats-section {
                padding: 60px 20px;
            }
        }

        @media (max-width: 480px) {
            .about-hero {
                padding: 80px 20px;
            }

            .about-hero h1 {
                font-size: 2rem;
            }

            .values-grid,
            .team-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="about-hero">
        <div class="about-hero-content">
            <h1>About <?php echo SITE_NAME; ?></h1>
            <p>We're on a mission to revolutionize online shopping by providing quality products, exceptional service, and an unforgettable customer experience.</p>
        </div>
    </div>

    <div class="about-container">
        <div class="about-section">
            <h2>Our Story</h2>
            <div class="about-content">
                <div class="about-text">
                    <p>Founded in 2020, <?php echo SITE_NAME; ?> began with a simple vision: to create an online shopping destination that combines quality, affordability, and convenience. What started as a small venture has grown into a trusted e-commerce platform serving thousands of satisfied customers across the Philippines.</p>
                    <p>We believe that shopping online should be more than just a transaction – it should be an experience. That's why we've built our platform around the needs of our customers, offering carefully curated products, transparent pricing, and customer service that truly cares.</p>
                    <p>Today, we're proud to offer an extensive catalog of products ranging from electronics and fashion to home goods and beauty products, all backed by our commitment to quality and customer satisfaction.</p>
                </div>
                <div class="about-image">
                    🏢
                </div>
            </div>
        </div>

        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Products Available</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99%</div>
                    <div class="stat-label">Customer Satisfaction</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.8★</div>
                    <div class="stat-label">Average Rating</div>
                </div>
            </div>
        </div>

        <div class="about-section">
            <h2>Our Mission & Vision</h2>
            <div class="about-content reverse">
                <div class="about-text">
                    <h3 style="color: var(--primary); font-size: 1.5rem; margin-bottom: 15px;">Mission</h3>
                    <p>To provide our customers with a seamless online shopping experience by offering high-quality products at competitive prices, backed by exceptional customer service and fast, reliable delivery.</p>
                    
                    <h3 style="color: var(--primary); font-size: 1.5rem; margin: 25px 0 15px;">Vision</h3>
                    <p>To become the most trusted and customer-centric e-commerce platform in the Philippines, setting new standards for quality, innovation, and customer satisfaction in online retail.</p>
                </div>
                <div class="about-image">
                    🎯
                </div>
            </div>
        </div>

        <div class="about-section">
            <h2>Our Core Values</h2>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">💎</div>
                    <h3>Quality First</h3>
                    <p>We carefully select every product in our catalog to ensure it meets our high standards for quality and durability.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🤝</div>
                    <h3>Customer Focus</h3>
                    <p>Our customers are at the heart of everything we do. Your satisfaction is our top priority.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">⚡</div>
                    <h3>Innovation</h3>
                    <p>We continuously improve our platform and services to provide the best possible shopping experience.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🔒</div>
                    <h3>Trust & Transparency</h3>
                    <p>We believe in honest communication, transparent pricing, and building long-term relationships with our customers.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🚀</div>
                    <h3>Fast Delivery</h3>
                    <p>We partner with reliable couriers to ensure your orders arrive quickly and safely.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🌱</div>
                    <h3>Sustainability</h3>
                    <p>We're committed to environmentally responsible practices in our operations and packaging.</p>
                </div>
            </div>
        </div>

        <div class="about-section timeline-section">
            <h2>Our Journey</h2>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-year">2020</div>
                    <div class="timeline-content">
                        <h3>The Beginning</h3>
                        <p><?php echo SITE_NAME; ?> was founded with a vision to transform online shopping in the Philippines. We launched with 500 products and a small but passionate team.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-year">2021</div>
                    <div class="timeline-content">
                        <h3>Rapid Growth</h3>
                        <p>Reached 10,000 customers and expanded our product catalog to over 3,000 items. Introduced same-day delivery in Metro Manila.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-year">2022</div>
                    <div class="timeline-content">
                        <h3>Expansion</h3>
                        <p>Opened our first fulfillment center and expanded shipping to all major cities in the Philippines. Launched our mobile app.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-year">2023</div>
                    <div class="timeline-content">
                        <h3>Innovation</h3>
                        <p>Introduced AI-powered product recommendations and 24/7 customer support. Reached 50,000 happy customers milestone.</p>
                    </div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-year">2024</div>
                    <div class="timeline-content">
                        <h3>Today & Beyond</h3>
                        <p>Now offering 10,000+ products with plans for international expansion. Committed to continuous innovation and exceptional service.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-section team-section">
            <h2>Meet Our Team</h2>
            <p style="color: var(--text-light); font-size: 1.1rem; max-width: 700px; margin: 0 auto 50px;">
                Behind <?php echo SITE_NAME; ?> is a dedicated team of professionals passionate about delivering the best online shopping experience.
            </p>
            <div class="team-grid">
                <div class="team-member">
                    <div class="team-photo">👨‍💼</div>
                    <h3>John Rivera</h3>
                    <div class="team-role">Chief Executive Officer</div>
                    <p class="team-bio">Visionary leader with 15+ years of e-commerce experience, driving innovation and growth at <?php echo SITE_NAME; ?>.</p>
                </div>
                <div class="team-member">
                    <div class="team-photo">👩‍💼</div>
                    <h3>Maria Santos</h3>
                    <div class="team-role">Chief Operating Officer</div>
                    <p class="team-bio">Operations expert ensuring seamless logistics and exceptional customer experiences across all touchpoints.</p>
                </div>
                <div class="team-member">
                    <div class="team-photo">👨‍💻</div>
                    <h3>David Chen</h3>
                    <div class="team-role">Chief Technology Officer</div>
                    <p class="team-bio">Tech innovator building cutting-edge solutions to enhance platform performance and user experience.</p>
                </div>
                <div class="team-member">
                    <div class="team-photo">👩‍🎨</div>
                    <h3>Sofia Reyes</h3>
                    <div class="team-role">Head of Customer Experience</div>
                    <p class="team-bio">Customer advocate dedicated to ensuring every interaction with <?php echo SITE_NAME; ?> exceeds expectations.</p>
                </div>
            </div>
        </div>

        <div class="about-section">
            <h2>Why Choose Us?</h2>
            <div class="about-content">
                <div class="about-text">
                    <h3 style="color: var(--dark); font-size: 1.5rem; margin-bottom: 15px;">What Sets Us Apart</h3>
                    <ul>
                        <li><strong>Curated Selection:</strong> Every product is hand-picked to ensure quality and value</li>
                        <li><strong>Competitive Pricing:</strong> Best prices guaranteed with frequent promotions and discounts</li>
                        <li><strong>Fast Shipping:</strong> Multiple delivery options including same-day delivery in Metro Manila</li>
                        <li><strong>Secure Shopping:</strong> Advanced encryption and secure payment processing</li>
                        <li><strong>Easy Returns:</strong> Hassle-free 30-day return policy on most items</li>
                        <li><strong>24/7 Support:</strong> Always available to help with any questions or concerns</li>
                        <li><strong>Loyalty Rewards:</strong> Earn points with every purchase for exclusive benefits</li>
                    </ul>
                </div>
                <div class="about-image">
                    ⭐
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
</body>
</html>