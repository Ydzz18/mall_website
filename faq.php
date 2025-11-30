<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="logo/favicon.png">
    <style>
        .faq-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .faq-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .faq-header h1 {
            font-size: 3rem;
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
        }

        .faq-header p {
            color: var(--text-light);
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .faq-search {
            max-width: 600px;
            margin: 0 auto 50px;
        }

        .search-box {
            position: relative;
            width: 100%;
        }

        .search-box input {
            width: 100%;
            padding: 16px 50px 16px 20px;
            border: 2px solid var(--border);
            border-radius: 50px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.3rem;
            color: var(--text-light);
        }

        .faq-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }

        .category-card {
            background: white;
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
        }

        .category-card:hover {
            border-color: var(--primary);
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(124, 58, 237, 0.15);
        }

        .category-card.active {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(124, 58, 237, 0.05) 0%, rgba(6, 214, 160, 0.05) 100%);
        }

        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .category-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
        }

        .faq-section {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .faq-section h2 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--primary);
        }

        .faq-item {
            border-bottom: 1px solid var(--border);
            padding: 20px 0;
            transition: var(--transition);
        }

        .faq-item:last-child {
            border-bottom: none;
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            padding: 10px 0;
            gap: 20px;
        }

        .faq-question h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
            transition: var(--transition);
        }

        .faq-question:hover h3 {
            color: var(--primary);
        }

        .faq-toggle {
            font-size: 1.5rem;
            color: var(--primary);
            transition: transform 0.3s ease;
            flex-shrink: 0;
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
            max-height: 500px;
        }

        .faq-answer-content {
            padding: 20px 0 10px;
            color: var(--text);
            line-height: 1.8;
        }

        .faq-answer-content ul {
            margin: 15px 0;
            padding-left: 25px;
        }

        .faq-answer-content li {
            margin-bottom: 8px;
        }

        .faq-answer-content strong {
            color: var(--dark);
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .no-results-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .contact-cta {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            margin-top: 50px;
        }

        .contact-cta h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .contact-cta p {
            font-size: 1.1rem;
            margin-bottom: 25px;
            opacity: 0.95;
        }

        .contact-cta .btn {
            background: white;
            color: var(--primary);
            padding: 14px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            display: inline-block;
            transition: var(--transition);
        }

        .contact-cta .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .faq-header h1 {
                font-size: 2.2rem;
            }

            .faq-section {
                padding: 25px 20px;
            }

            .faq-question h3 {
                font-size: 1.05rem;
            }

            .faq-categories {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .faq-header h1 {
                font-size: 1.8rem;
            }

            .faq-section h2 {
                font-size: 1.6rem;
            }

            .contact-cta {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <div class="faq-container">
        <div class="faq-header">
            <h1>Frequently Asked Questions</h1>
            <p>Find answers to common questions about our products, shipping, returns, and more.</p>
        </div>

        <div class="faq-search">
            <div class="search-box">
                <input type="text" id="faqSearch" placeholder="Search for answers...">
                <span class="search-icon">🔍</span>
            </div>
        </div>

        <div class="faq-categories">
            <div class="category-card active" data-category="all">
                <div class="category-icon">📋</div>
                <div class="category-name">All Questions</div>
            </div>
            <div class="category-card" data-category="orders">
                <div class="category-icon">🛒</div>
                <div class="category-name">Orders</div>
            </div>
            <div class="category-card" data-category="shipping">
                <div class="category-icon">📦</div>
                <div class="category-name">Shipping</div>
            </div>
            <div class="category-card" data-category="returns">
                <div class="category-icon">↩️</div>
                <div class="category-name">Returns</div>
            </div>
            <div class="category-card" data-category="payment">
                <div class="category-icon">💳</div>
                <div class="category-name">Payment</div>
            </div>
            <div class="category-card" data-category="account">
                <div class="category-icon">👤</div>
                <div class="category-name">Account</div>
            </div>
        </div>

        <div class="faq-section" data-category="orders">
            <h2>🛒 Orders & Shopping</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>How do I place an order?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Placing an order is easy:</p>
                        <ul>
                            <li>Browse our products and add items to your cart</li>
                            <li>Click the cart icon and review your items</li>
                            <li>Proceed to checkout and enter your shipping information</li>
                            <li>Choose your payment method and complete the purchase</li>
                            <li>You'll receive an order confirmation email</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I modify or cancel my order?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Orders can be modified or cancelled within 1 hour of placement. After that, the order is processed and cannot be changed. Contact our customer service immediately at <strong>support@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</strong> if you need to make changes.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>How can I track my order?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Once your order ships, you'll receive a tracking number via email. You can also track your order by:</p>
                        <ul>
                            <li>Logging into your account and viewing "My Orders"</li>
                            <li>Using the tracking number on the courier's website</li>
                            <li>Checking your email for shipping updates</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>Do you offer gift wrapping?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Yes! We offer gift wrapping for ₱50 per item. You can add this option during checkout. We'll include a gift message if you provide one.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-section" data-category="shipping">
            <h2>📦 Shipping & Delivery</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>What are the shipping costs and delivery times?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>We offer several shipping options:</p>
                        <ul>
                            <li><strong>Standard Shipping (5-7 business days):</strong> ₱100</li>
                            <li><strong>Express Shipping (2-3 business days):</strong> ₱200</li>
                            <li><strong>Free Shipping:</strong> On orders over ₱2,000</li>
                        </ul>
                        <p>Delivery times may vary based on your location and product availability.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>Do you ship internationally?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Currently, we only ship within the Philippines. We're working on expanding to international shipping soon. Subscribe to our newsletter to be notified when international shipping becomes available.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>What if my package is lost or damaged?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>If your package is lost or arrives damaged, please contact us within 48 hours of the expected delivery date. We'll work with the courier to resolve the issue and either resend your order or provide a full refund.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I change my delivery address after ordering?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Address changes must be requested within 1 hour of placing your order. Contact customer service immediately. Once the order is shipped, we cannot change the delivery address.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-section" data-category="returns">
            <h2>↩️ Returns & Refunds</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>What is your return policy?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>We offer a 30-day return policy for most products. To be eligible for a return:</p>
                        <ul>
                            <li>Item must be unused and in original condition</li>
                            <li>Item must be in original packaging</li>
                            <li>Proof of purchase is required</li>
                            <li>Return must be initiated within 30 days of delivery</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>How do I initiate a return?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>To start a return:</p>
                        <ul>
                            <li>Log into your account and go to "My Orders"</li>
                            <li>Select the order and click "Return Item"</li>
                            <li>Choose your reason for return</li>
                            <li>Print the return label provided</li>
                            <li>Ship the item back to us</li>
                        </ul>
                        <p>You can also contact customer service for assistance.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>When will I receive my refund?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Once we receive and inspect your return, we'll process your refund within 7-10 business days. The refund will be issued to your original payment method. Depending on your bank, it may take an additional 3-5 business days to appear in your account.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>Are there any items that cannot be returned?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Yes, the following items are non-returnable:</p>
                        <ul>
                            <li>Personalized or custom-made products</li>
                            <li>Perishable goods</li>
                            <li>Intimate or sanitary products</li>
                            <li>Digital products and downloads</li>
                            <li>Items marked as "Final Sale"</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-section" data-category="payment">
            <h2>💳 Payment & Pricing</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>What payment methods do you accept?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>We accept the following payment methods:</p>
                        <ul>
                            <li>Credit/Debit Cards (Visa, Mastercard, American Express)</li>
                            <li>PayPal</li>
                            <li>GCash</li>
                            <li>Cash on Delivery (COD) - available for orders under ₱5,000</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>Is it safe to use my credit card on your website?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Absolutely! We use industry-standard SSL encryption to protect your payment information. All transactions are processed through secure, PCI-DSS compliant payment gateways. We never store your complete credit card information on our servers.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>Do you offer price matching?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>We strive to offer competitive prices. While we don't have a formal price-matching policy, if you find a lower price on an identical item from a verified retailer, contact us and we'll do our best to match or beat it.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>Can I use multiple payment methods for one order?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Currently, we only accept one payment method per order. If you'd like to split payment, consider placing separate orders or contact customer service for assistance.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="faq-section" data-category="account">
            <h2>👤 Account & Security</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Do I need an account to make a purchase?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>No, you can checkout as a guest. However, creating an account allows you to track orders, save addresses, view order history, and enjoy a faster checkout experience for future purchases.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>How do I reset my password?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>To reset your password:</p>
                        <ul>
                            <li>Go to the login page</li>
                            <li>Click "Forgot Password?"</li>
                            <li>Enter your email address</li>
                            <li>Check your email for reset instructions</li>
                            <li>Follow the link to create a new password</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>How do I update my account information?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>Log into your account and navigate to "Account Settings" or "Profile." From there, you can update your personal information, email address, password, and saved addresses.</p>
                    </div>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h3>How do I delete my account?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        <p>If you wish to delete your account, please contact customer service at <strong>support@<?php echo strtolower(str_replace(' ', '', SITE_NAME)); ?>.com</strong>. We'll process your request within 5 business days. Note that this action is permanent and cannot be undone.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="no-results" id="noResults" style="display: none;">
            <div class="no-results-icon">🔍</div>
            <h2>No Results Found</h2>
            <p>We couldn't find any questions matching your search. Try different keywords or contact our support team.</p>
        </div>

        <div class="contact-cta">
            <h2>Still Have Questions?</h2>
            <p>Can't find the answer you're looking for? Our customer support team is here to help!</p>
            <a href="contact.php" class="btn">Contact Support</a>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle FAQ items
            const faqItems = document.querySelectorAll('.faq-item');
            
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                
                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');
                    
                    // Close all other items
                    faqItems.forEach(otherItem => {
                        otherItem.classList.remove('active');
                    });
                    
                    // Toggle current item
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            });

            // Category filtering
            const categoryCards = document.querySelectorAll('.category-card');
            const faqSections = document.querySelectorAll('.faq-section');
            
            categoryCards.forEach(card => {
                card.addEventListener('click', () => {
                    const category = card.dataset.category;
                    
                    // Update active category
                    categoryCards.forEach(c => c.classList.remove('active'));
                    card.classList.add('active');
                    
                    // Filter sections
                    if (category === 'all') {
                        faqSections.forEach(section => section.style.display = 'block');
                    } else {
                        faqSections.forEach(section => {
                            if (section.dataset.category === category) {
                                section.style.display = 'block';
                            } else {
                                section.style.display = 'none';
                            }
                        });
                    }
                    
                    document.getElementById('noResults').style.display = 'none';
                });
            });

            // Search functionality
            const searchInput = document.getElementById('faqSearch');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let hasResults = false;
                
                if (searchTerm === '') {
                    // Show all sections
                    faqSections.forEach(section => section.style.display = 'block');
                    faqItems.forEach(item => item.style.display = 'block');
                    document.getElementById('noResults').style.display = 'none';
                    
                    // Reset category to "all"
                    categoryCards.forEach(c => c.classList.remove('active'));
                    categoryCards[0].classList.add('active');
                    return;
                }
                
                // Search through all FAQ items
                faqSections.forEach(section => {
                    section.style.display = 'block';
                    const items = section.querySelectorAll('.faq-item');
                    let sectionHasResults = false;
                    
                    items.forEach(item => {
                        const question = item.querySelector('.faq-question h3').textContent.toLowerCase();
                        const answer = item.querySelector('.faq-answer-content').textContent.toLowerCase();
                        
                        if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                            item.style.display = 'block';
                            sectionHasResults = true;
                            hasResults = true;
                        } else {
                            item.style.display = 'none';
                        }
                    });
                    
                    if (!sectionHasResults) {
                        section.style.display = 'none';
                    }
                });
                
                // Show/hide no results message
                document.getElementById('noResults').style.display = hasResults ? 'none' : 'block';
                
                // Set category to "all" during search
                categoryCards.forEach(c => c.classList.remove('active'));
                categoryCards[0].classList.add('active');
            });
        });
    </script>
</body>
</html>