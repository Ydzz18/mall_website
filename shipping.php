<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Information - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .shipping-container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .shipping-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .shipping-header h1 {
            font-size: 3rem;
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .shipping-header p {
            color: var(--text-light);
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .shipping-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .shipping-option {
            background: white;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
            border: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .shipping-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .shipping-option:hover {
            border-color: var(--primary);
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(124, 58, 237, 0.2);
        }

        .shipping-option:hover::before {
            transform: scaleX(1);
        }

        .shipping-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .shipping-option h3 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .shipping-price {
            font-size: 2rem;
            font-weight: 900;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .shipping-time {
            display: inline-block;
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 214, 160, 0.1) 100%);
            padding: 8px 16px;
            border-radius: 50px;
            color: var(--primary);
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .shipping-option ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .shipping-option li {
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .shipping-option li:last-child {
            border-bottom: none;
        }

        .shipping-option li::before {
            content: '✓';
            color: var(--success);
            font-weight: 900;
            font-size: 1.2rem;
        }

        .info-section {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        .info-section h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--primary);
        }

        .info-section h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary);
            margin: 30px 0 15px;
        }

        .info-section p {
            color: var(--text);
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .info-section ul {
            margin: 20px 0;
            padding-left: 30px;
        }

        .info-section li {
            margin-bottom: 12px;
            color: var(--text);
            line-height: 1.8;
        }

        .info-box {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.05) 100%);
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid var(--info);
            margin: 25px 0;
        }

        .warning-box {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(245, 158, 11, 0.05) 100%);
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid var(--warning);
            margin: 25px 0;
        }

        .success-box {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%);
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid var(--success);
            margin: 25px 0;
        }

        .coverage-map {
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.1) 0%, rgba(6, 214, 160, 0.1) 100%);
            padding: 40px;
            border-radius: 16px;
            margin: 30px 0;
        }

        .coverage-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 25px;
        }

        .coverage-area {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .coverage-area h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .coverage-area ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .coverage-area li {
            padding: 5px 0;
            color: var(--text);
            font-size: 0.95rem;
        }

        .tracking-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }

        .tracking-step {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: var(--gradient-primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 900;
            margin: 0 auto 20px;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.4);
        }

        .tracking-step h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .tracking-step p {
            color: var(--text-light);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .faq-shipping {
            margin-top: 60px;
        }

        .faq-item {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            transition: var(--transition);
        }

        .faq-item:hover {
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.15);
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            color: var(--dark);
            font-size: 1.1rem;
        }

        .faq-toggle {
            font-size: 1.5rem;
            color: var(--primary);
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-toggle {
            transform: rotate(45deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
        }

        .faq-item.active .faq-answer {
            max-height: 300px;
        }

        .faq-answer-content {
            padding-top: 15px;
            color: var(--text);
            line-height: 1.8;
        }

        @media (max-width: 768px) {
            .shipping-header h1 {
                font-size: 2.2rem;
            }

            .info-section {
                padding: 30px 25px;
            }

            .shipping-options {
                grid-template-columns: 1fr;
            }

            .tracking-steps {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .shipping-header h1 {
                font-size: 1.8rem;
            }

            .info-section {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="shipping-container">
        <div class="shipping-header">
            <h1>Shipping Information</h1>
            <p>Fast, reliable, and affordable shipping options to get your orders delivered safely and on time.</p>
        </div>

        <div class="shipping-options">
            <div class="shipping-option">
                <div class="shipping-icon">🚚</div>
                <h3>Standard Shipping</h3>
                <div class="shipping-price">₱100</div>
                <div class="shipping-time">5-7 Business Days</div>
                <ul>
                    <li>Most economical option</li>
                    <li>Nationwide coverage</li>
                    <li>Package tracking included</li>
                    <li>Secure and insured</li>
                    <li>Perfect for non-urgent orders</li>
                </ul>
            </div>

            <div class="shipping-option">
                <div class="shipping-icon">⚡</div>
                <h3>Express Shipping</h3>
                <div class="shipping-price">₱200</div>
                <div class="shipping-time">2-3 Business Days</div>
                <ul>
                    <li>Faster delivery</li>
                    <li>Priority handling</li>
                    <li>Real-time tracking</li>
                    <li>Signature on delivery</li>
                    <li>Ideal for urgent orders</li>
                </ul>
            </div>

            <div class="shipping-option">
                <div class="shipping-icon">🎁</div>
                <h3>Free Shipping</h3>
                <div class="shipping-price">FREE</div>
                <div class="shipping-time">5-7 Business Days</div>
                <ul>
                    <li>Orders over ₱2,000</li>
                    <li>Standard delivery time</li>
                    <li>All Metro Manila areas</li>
                    <li>Tracking provided</li>
                    <li>Save on shipping costs</li>
                </ul>
            </div>
        </div>

        <div class="info-section">
            <h2>📦 How Shipping Works</h2>
            
            <div class="tracking-steps">
                <div class="tracking-step">
                    <div class="step-number">1</div>
                    <h4>Order Placed</h4>
                    <p>You complete your purchase and receive order confirmation</p>
                </div>
                <div class="tracking-step">
                    <div class="step-number">2</div>
                    <h4>Processing</h4>
                    <p>We prepare and pack your order carefully</p>
                </div>
                <div class="tracking-step">
                    <div class="step-number">3</div>
                    <h4>Shipped</h4>
                    <p>Your order is handed to courier with tracking number</p>
                </div>
                <div class="tracking-step">
                    <div class="step-number">4</div>
                    <h4>In Transit</h4>
                    <p>Package is on its way to your delivery address</p>
                </div>
                <div class="tracking-step">
                    <div class="step-number">5</div>
                    <h4>Delivered</h4>
                    <p>Package arrives safely at your doorstep</p>
                </div>
            </div>

            <h3>Order Processing Time</h3>
            <p>Orders are typically processed within 1-2 business days after payment confirmation. Processing time may be longer during peak seasons or promotional periods.</p>

            <div class="info-box">
                <p><strong>💡 Pro Tip:</strong> Orders placed before 2:00 PM on weekdays are usually processed the same day and shipped the next business day.</p>
            </div>

            <h3>Tracking Your Order</h3>
            <p>Once your order ships, you'll receive:</p>
            <ul>
                <li>Email notification with tracking number</li>
                <li>SMS updates on delivery status</li>
                <li>Real-time tracking in your account dashboard</li>
                <li>Estimated delivery date</li>
            </ul>

            <p>You can track your order anytime by:</p>
            <ul>
                <li>Logging into your account and viewing "My Orders"</li>
                <li>Using the tracking number on the courier's website</li>
                <li>Contacting our customer support team</li>
            </ul>
        </div>

        <div class="info-section">
            <h2>🗺️ Delivery Coverage</h2>
            <p>We currently ship to all major cities and provinces across the Philippines.</p>

            <div class="coverage-map">
                <h3 style="color: var(--dark); font-size: 1.4rem; margin-bottom: 20px;">Delivery Areas</h3>
                <div class="coverage-grid">
                    <div class="coverage-area">
                        <h4>Metro Manila</h4>
                        <ul>
                            <li>• Quezon City</li>
                            <li>• Manila</li>
                            <li>• Makati</li>
                            <li>• Pasig</li>
                            <li>• Taguig</li>
                            <li>• All NCR cities</li>
                        </ul>
                    </div>
                    <div class="coverage-area">
                        <h4>Luzon</h4>
                        <ul>
                            <li>• Cavite</li>
                            <li>• Laguna</li>
                            <li>• Bulacan</li>
                            <li>• Rizal</li>
                            <li>• Pampanga</li>
                            <li>• Other Luzon areas</li>
                        </ul>
                    </div>
                    <div class="coverage-area">
                        <h4>Visayas</h4>
                        <ul>
                            <li>• Cebu</li>
                            <li>• Iloilo</li>
                            <li>• Bacolod</li>
                            <li>• Bohol</li>
                            <li>• Tacloban</li>
                            <li>• Other Visayas areas</li>
                        </ul>
                    </div>
                    <div class="coverage-area">
                        <h4>Mindanao</h4>
                        <ul>
                            <li>• Davao</li>
                            <li>• Cagayan de Oro</li>
                            <li>• General Santos</li>
                            <li>• Zamboanga</li>
                            <li>• Butuan</li>
                            <li>• Other Mindanao areas</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="warning-box">
                <p><strong>⚠️ Remote Area Surcharge:</strong> Some remote islands and mountainous areas may incur additional shipping fees and extended delivery times. Contact us for specific rates.</p>
            </div>
        </div>

        <div class="info-section">
            <h2>📋 Shipping Policies</h2>
            
            <h3>Delivery Address</h3>
            <ul>
                <li>Please ensure your delivery address is complete and accurate</li>
                <li>Include contact number for delivery coordination</li>
                <li>Specify landmarks if address is hard to locate</li>
                <li>Address changes must be requested within 1 hour of order placement</li>
            </ul>

            <h3>Recipient Requirements</h3>
            <ul>
                <li>Someone must be available to receive the package</li>
                <li>Valid ID may be required for verification</li>
                <li>Signature required for high-value items</li>
                <li>If no one is available, courier will leave a delivery notice</li>
            </ul>

            <h3>Package Security</h3>
            <ul>
                <li>All packages are carefully packed to prevent damage</li>
                <li>Fragile items receive extra protective packaging</li>
                <li>Insurance included on all shipments over ₱1,000</li>
                <li>Tamper-evident seals for security</li>
            </ul>

            <div class="success-box">
                <p><strong>✓ Quality Guarantee:</strong> If your package arrives damaged, contact us within 48 hours with photos. We'll arrange a replacement or full refund immediately.</p>
            </div>

            <h3>Failed Delivery Attempts</h3>
            <p>If delivery fails due to:</p>
            <ul>
                <li><strong>Recipient unavailable:</strong> Courier will attempt redelivery the next business day</li>
                <li><strong>Incorrect address:</strong> You'll be contacted to confirm correct address</li>
                <li><strong>Refused delivery:</strong> Order will be returned, and shipping fees apply</li>
                <li><strong>After 3 failed attempts:</strong> Package returned to warehouse, refund minus shipping</li>
            </ul>

            <h3>Customs and Import</h3>
            <p>For international items (if applicable):</p>
            <ul>
                <li>Customs duties and taxes are buyer's responsibility</li>
                <li>Clearance may delay delivery by 3-7 days</li>
                <li>We'll provide all necessary documentation</li>
                <li>Contact us for specific import requirements</li>
            </ul>
        </div>

        <div class="info-section faq-shipping">
            <h2>❓ Shipping FAQs</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <span>Can I change my delivery address after ordering?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Address changes must be requested within 1 hour of placing your order. Contact customer service immediately at <strong>support@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</strong>. Once the order is shipped, we cannot change the delivery address.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>What if I'm not home when my package arrives?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        The courier will leave a delivery notice with instructions. They'll attempt redelivery the next business day. You can also contact the courier directly to arrange a convenient delivery time or pick up from their depot.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Do you ship on weekends and holidays?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        We process orders Monday to Friday. Deliveries may occur on Saturdays depending on the courier. No processing or delivery on Sundays and public holidays. Orders placed on weekends will be processed on the next business day.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>What happens if my package is lost or stolen?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        If your package is confirmed lost or stolen, contact us immediately. We'll work with the courier to investigate. All shipments over ₱1,000 are insured. We'll provide a full refund or replacement once the claim is verified.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Can I request a specific delivery date or time?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        While we can't guarantee specific delivery times, you can add delivery notes during checkout with your preferred time. Our courier partners will do their best to accommodate your request. For urgent deliveries, consider choosing Express Shipping.
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <span>Is same-day delivery available?</span>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Same-day delivery is available for orders placed before 11:00 AM in select Metro Manila areas, subject to availability. Additional fees apply. Contact customer support to check if your area qualifies for same-day delivery.
                    </div>
                </div>
            </div>
        </div>

        <div class="info-section" style="text-align: center; background: var(--gradient-primary); color: white;">
            <h2 style="color: white; border-bottom: 3px solid white;">Need More Information?</h2>
            <p style="font-size: 1.1rem; margin-bottom: 25px;">Our customer support team is here to help with any shipping questions or concerns.</p>
            <a href="contact.php" class="btn" style="background: white; color: var(--primary); display: inline-block; padding: 14px 32px; border-radius: 50px; text-decoration: none; font-weight: 700;">Contact Support</a>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                
                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');
                    
                    // Close all items
                    faqItems.forEach(otherItem => {
                        otherItem.classList.remove('active');
                    });
                    
                    // Toggle current item
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>