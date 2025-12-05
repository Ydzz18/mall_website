<footer class="main-footer">
    <div class="container">
        <?php
        // Fetch contact information from database
        $contact_info = array(
            'email' => 'support@example.com',
            'phone' => '+1 (555) 123-4567',
            'address' => '123 Commerce St, City, State 12345'
        );
        
        $conn = getDBConnection();
        if ($conn) {
            $result = $conn->query("SELECT setting_key, setting_value FROM site_settings WHERE setting_key IN ('support_email', 'support_phone', 'support_address')");
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['setting_key'] === 'support_email') $contact_info['email'] = $row['setting_value'];
                    if ($row['setting_key'] === 'support_phone') $contact_info['phone'] = $row['setting_value'];
                    if ($row['setting_key'] === 'support_address') $contact_info['address'] = $row['setting_value'];
                }
            }
            $conn->close();
        }
        ?>
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-logo">
                    <h3><?php echo SITE_NAME; ?></h3>
                </div>
                <p class="footer-description">Your premier shopping destination for quality products at great prices.</p>
                <div class="social-links">
                    <a href="#" class="social-link">📘</a>
                    <a href="#" class="social-link">🐦</a>
                    <a href="#" class="social-link">📷</a>
                    <a href="#" class="social-link">💼</a>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Customer Service</h4>
                <ul class="footer-links">
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="shipping.php">Shipping Info</a></li>
                    <li><a href="returns.php">Returns</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Contact Info</h4>
                <div class="contact-info">
                    <div class="contact-item">
                        <span class="contact-icon">📧</span>
                        <span><?php echo htmlspecialchars($contact_info['email']); ?></span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">📞</span>
                        <span><?php echo htmlspecialchars($contact_info['phone']); ?></span>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">📍</span>
                        <span><?php echo htmlspecialchars($contact_info['address']); ?></span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="footer-divider"></div>
            <div class="footer-bottom-content">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                <div class="footer-payments">
                    <span class="payment-icon">💳</span>
                    <span class="payment-icon">🏦</span>
                    <span class="payment-icon">📱</span>
                    <span class="payment-icon">🔒</span>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.main-footer {
    background: #1e293b;
    color: white;
    padding: 3rem 0 1rem;
    margin-top: 4rem;
}

.footer-content {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1.5fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-section h3,
.footer-section h4 {
    color: white;
    margin-bottom: 1rem;
    font-weight: 700;
}

.footer-section h3 {
    font-size: 1.5rem;
    background: linear-gradient(135deg, #3b82f6, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.footer-section h4 {
    font-size: 1.1rem;
    color: #f1f5f9;
}

.footer-description {
    color: #94a3b8;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    font-size: 0.95rem;
}

.social-links {
    display: flex;
    gap: 0.75rem;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: #334155;
    border-radius: 8px;
    text-decoration: none;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: #3b82f6;
    transform: translateY(-2px);
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.75rem;
}

.footer-links a {
    color: #94a3b8;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}

.footer-links a:hover {
    color: white;
    padding-left: 0.5rem;
}

.contact-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    color: #94a3b8;
    font-size: 0.95rem;
}

.contact-icon {
    font-size: 1.1rem;
    flex-shrink: 0;
    margin-top: 0.1rem;
}

.footer-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #334155, transparent);
    margin: 2rem 0 1.5rem;
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.footer-bottom p {
    color: #94a3b8;
    font-size: 0.9rem;
    margin: 0;
}

.footer-payments {
    display: flex;
    gap: 0.5rem;
}

.payment-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: #334155;
    border-radius: 6px;
    font-size: 1rem;
}

/* Mobile Responsive */
@media (max-width: 1024px) {
    .footer-content {
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 2rem;
        text-align: center;
    }
    
    .social-links {
        justify-content: center;
    }
    
    .footer-bottom-content {
        flex-direction: column;
        text-align: center;
    }
    
    .contact-item {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .main-footer {
        padding: 2rem 0 1rem;
    }
    
    .footer-content {
        gap: 1.5rem;
    }
    
    .footer-section {
        text-align: center;
    }
}
</style>