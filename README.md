# E-Commerce Platform Documentation

## 📋 Table of Contents

1. [Overview](#overview)
2. [System Architecture](#system-architecture)
3. [File Structure](#file-structure)
4. [Database Schema](#database-schema)
5. [Core Features](#core-features)
6. [Configuration](#configuration)
7. [User Flows](#user-flows)
8. [Security Features](#security-features)
9. [Email System](#email-system)
10. [Maintenance Mode](#maintenance-mode)
11. [Troubleshooting](#troubleshooting)

---

## Overview

**JRD Malls** is a full-featured PHP-based e-commerce platform with comprehensive shopping cart functionality, user management, order processing, and payment integration.

### Key Technologies
- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Session Management**: PHP Sessions
- **Email**: Gmail SMTP
- **Timezone**: Asia/Manila (Philippine Standard Time)


## System Architecture

### Core Components

1. **Configuration Layer** (`config.php`)
   - Database connection management
   - Site-wide settings and constants
   - Maintenance mode control
   - Session management
   - Helper functions

2. **Authentication System**
   - Customer login/registration
   - Password hashing (bcrypt)
   - Session-based authentication
   - Activity logging

3. **Shopping System**
   - Product catalog
   - Shopping cart
   - Wishlist
   - Order processing
   - Payment integration

4. **User Management**
   - Profile management
   - Address management
   - Order history
   - Notifications

5. **Admin Panel**
   - Dashboard analytics
   - Product management
   - Order processing
   - Inventory tracking
   - Customer management
   - Coupon system
   - Activity logging
   - Report generation

---

## File Structure

```
project-root/
│
├── config.php                 # Core configuration file
├── index.php                  # Homepage
├── shop.php                   # Product listing page
├── product.php                # Product detail page
├── cart.php                   # Shopping cart
├── checkout.php               # Checkout process
├── payment.php                # Payment processing
├── order_success.php          # Order confirmation
├── orders.php                 # Order history
├── profile.php                # User profile
├── login.php                  # Login page
├── register.php               # Registration page
├── logout.php                 # Logout handler
├── notifications.php          # User notifications
├── maintenance.php            # Maintenance mode page
│
├── css/
│   └── style.css             # Main stylesheet
│
├── includes/
│   ├── header.php            # Site header
│   ├── footer.php            # Site footer
│   ├── ActivityLogger.php    # Activity logging
│   ├── RoleManager.php       # Role-based access control
│   ├── email.php             # Email functions
│   └── notifications.php     # Notification functions
│
├── logo/
│   ├── favicon.png           # Site favicon
│   └── icon.png              # Site icon
│
├── admin/                     # Admin panel (separate section)
│
└── malls.sql                  # Database schema
```

---

## Database Schema

### Customer & User Tables

#### **customers**
```sql
- customer_id (PK, AUTO_INCREMENT)
- email (UNIQUE)
- password_hash (bcrypt)
- first_name
- last_name
- phone (optional)
- date_of_birth (optional)
- is_active (1 = active, 0 = inactive)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
- last_login (TIMESTAMP, nullable)
```

#### **admin_users**
```sql
- admin_id (PK, AUTO_INCREMENT)
- username (UNIQUE, 50 chars)
- email (UNIQUE)
- password_hash (bcrypt)
- full_name
- role (super_admin, admin, moderator)
- is_active (1 = active, 0 = inactive)
- last_login (TIMESTAMP, nullable)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### **addresses**
```sql
- address_id (PK, AUTO_INCREMENT)
- customer_id (FK → customers.customer_id, CASCADE)
- address_type (billing, shipping)
- is_default (1 = default, 0 = not default)
- street_address
- city
- state_province
- postal_code
- country
- created_at (TIMESTAMP)
```

---

### Product Tables

#### **categories**
```sql
- category_id (PK, AUTO_INCREMENT)
- category_name
- parent_category_id (FK, nullable - for subcategories)
- description (optional)
- image_url (optional)
- is_active (1 = visible, 0 = hidden)
- created_at (TIMESTAMP)
```

#### **products**
```sql
- product_id (PK, AUTO_INCREMENT)
- category_id (FK → categories.category_id)
- product_name
- description (TEXT)
- price (DECIMAL 10,2)
- sale_price (DECIMAL 10,2, nullable)
- sku (UNIQUE)
- brand (optional)
- weight (DECIMAL 8,2, optional)
- dimensions (optional)
- is_active (1 = published, 0 = draft/hidden)
- featured (1 = featured, 0 = not featured)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### **product_images**
```sql
- image_id (PK, AUTO_INCREMENT)
- product_id (FK → products.product_id, CASCADE)
- image_url
- is_primary (1 = main image, 0 = gallery image)
- display_order (sort order for gallery)
- created_at (TIMESTAMP)
```

#### **inventory**
```sql
- inventory_id (PK, AUTO_INCREMENT)
- product_id (FK → products.product_id, CASCADE)
- quantity (current available stock)
- reserved_quantity (reserved for pending orders)
- reorder_level (low stock threshold)
- last_restocked (TIMESTAMP, nullable)
- updated_at (TIMESTAMP)
```

---

### Order Tables

#### **orders**
```sql
- order_id (PK, AUTO_INCREMENT)
- customer_id (FK → customers.customer_id)
- order_number (UNIQUE, format: ORD-YYYYMMDD-HASH)
- order_status (pending, processing, shipped, delivered, cancelled, refunded)
- subtotal (DECIMAL 10,2)
- tax_amount (DECIMAL 10,2)
- shipping_cost (DECIMAL 10,2)
- total_amount (DECIMAL 10,2)
- shipping_address_id (FK → addresses.address_id)
- billing_address_id (FK → addresses.address_id)
- payment_method (Credit Card, Debit Card, PayPal, GCash, Cash on Delivery)
- payment_status (pending, completed, failed, refunded)
- notes (TEXT, optional)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### **order_items**
```sql
- order_item_id (PK, AUTO_INCREMENT)
- order_id (FK → orders.order_id, CASCADE)
- product_id (FK → products.product_id)
- quantity
- unit_price (price at time of purchase)
- subtotal (quantity * unit_price)
```

#### **order_coupons**
```sql
- order_coupon_id (PK, AUTO_INCREMENT)
- order_id (FK → orders.order_id, CASCADE)
- coupon_id (FK → coupons.coupon_id)
- discount_applied (DECIMAL 10,2)
```

#### **order_notes**
```sql
- note_id (PK, AUTO_INCREMENT)
- order_id (FK → orders.order_id)
- admin_id (FK → admin_users.admin_id, nullable)
- note_text (TEXT)
- created_at (TIMESTAMP)
```

---

### Payment & Shipping

#### **payments**
```sql
- payment_id (PK, AUTO_INCREMENT)
- order_id (FK → orders.order_id, CASCADE)
- payment_method (Credit Card, Debit Card, PayPal, GCash, Cash on Delivery)
- transaction_id (UNIQUE, nullable)
- amount (DECIMAL 10,2)
- payment_status (pending, completed, failed, refunded)
- payment_date (TIMESTAMP, nullable)
- created_at (TIMESTAMP)
```

#### **shipping**
```sql
- shipping_id (PK, AUTO_INCREMENT)
- order_id (FK → orders.order_id, CASCADE)
- carrier (optional, e.g., DHL, FedEx)
- tracking_number (optional)
- shipping_method (Standard, Express, etc.)
- shipped_date (TIMESTAMP, nullable)
- estimated_delivery_date (DATE, nullable)
- actual_delivery_date (TIMESTAMP, nullable)
- status (preparing, shipped, in_transit, delivered, failed)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

---

### Customer Interaction Tables

#### **shopping_cart**
```sql
- cart_id (PK, AUTO_INCREMENT)
- customer_id (FK → customers.customer_id, CASCADE)
- product_id (FK → products.product_id, CASCADE)
- quantity (default 1)
- added_at (TIMESTAMP)
- updated_at (TIMESTAMP)
- UNIQUE: (customer_id, product_id)
```

#### **wishlist**
```sql
- wishlist_id (PK, AUTO_INCREMENT)
- customer_id (FK → customers.customer_id, CASCADE)
- product_id (FK → products.product_id, CASCADE)
- added_at (TIMESTAMP)
- UNIQUE: (customer_id, product_id)
```

#### **reviews**
```sql
- review_id (PK, AUTO_INCREMENT)
- product_id (FK → products.product_id, CASCADE)
- customer_id (FK → customers.customer_id, CASCADE)
- order_id (FK → orders.order_id, nullable)
- rating (1-5, CHECK rating >= 1 AND rating <= 5)
- title (100 chars, optional)
- comment (TEXT)
- is_verified_purchase (1 = verified, 0 = not verified)
- is_approved (1 = approved by admin, 0 = pending)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

#### **notifications**
```sql
- notification_id (PK, AUTO_INCREMENT)
- customer_id (FK → customers.customer_id, CASCADE)
- order_id (FK → orders.order_id, nullable)
- type (order_status, payment, shipping, system)
- title (255 chars)
- message (TEXT)
- is_read (1 = read, 0 = unread)
- created_at (TIMESTAMP)
```

---

### Promotion Tables

#### **coupons**
```sql
- coupon_id (PK, AUTO_INCREMENT)
- coupon_code (UNIQUE, 50 chars)
- description (255 chars, optional)
- discount_type (percentage, fixed_amount)
- discount_value (DECIMAL 10,2)
- min_purchase_amount (DECIMAL 10,2, optional)
- max_discount_amount (DECIMAL 10,2, optional)
- usage_limit (optional, null = unlimited)
- usage_count (tracks current usage)
- start_date (DATE)
- end_date (DATE)
- is_active (1 = active, 0 = inactive)
- created_at (TIMESTAMP)
```

---

### System Tables

#### **activity_logs**
```sql
- log_id (PK, AUTO_INCREMENT)
- user_type (admin, customer)
- user_id
- action_type (login, logout, order_create, product_update, etc.)
- action_description (TEXT)
- table_affected (50 chars, nullable)
- record_id (nullable)
- old_values (TEXT/JSON, nullable)
- new_values (TEXT/JSON, nullable)
- ip_address (45 chars, nullable)
- user_agent (255 chars, nullable)
- created_at (TIMESTAMP)
```

#### **site_settings**
```sql
- setting_key (PK, 100 chars)
- setting_value (TEXT)
- setting_type (text, number, checkbox, email, password)
- description (TEXT, optional)
- updated_at (TIMESTAMP)

# Available settings:
- site_name
- site_email
- site_phone
- currency_symbol
- tax_rate (%)
- shipping_cost
- free_shipping_threshold
- items_per_page
- maintenance_mode
- enable_reviews
- enable_email_notifications
- enable_order_emails
- enable_payment_emails
- enable_shipping_emails
- require_email_verification
- gmail_sender_email
- gmail_sender_password
- gmail_sender_name
```

---

### Key Relationships & Constraints

- **Foreign Key Relationships**: All foreign keys have proper CASCADE/SET NULL rules
- **Indexes**: Query optimization indexes on frequently searched columns (customer_id, category_id, order_date, etc.)
- **Character Set**: UTF-8 (utf8mb4_general_ci) for international support
- **Timestamps**: All tables use TIMESTAMP for automatic creation/update tracking

---

## Core Features

### 1. **Product Management**

#### Product Display (`shop.php`)
```php
// Features:
- Category filtering
- Grid/List view toggle
- Price range filter
- Sort options (newest, price, popularity)
- Pagination
- Product cards with:
  - Primary image
  - Price (with sale price)
  - Rating display
  - Quick actions
```

#### Product Details (`product.php`)
```php
// Features:
- Image gallery with thumbnails
- Product specifications
- Stock availability
- Add to cart
- Add to wishlist
- Customer reviews
- Related products
- Tabbed interface (Description, Specs, Reviews)
```

### 2. **Shopping Cart System**

#### Cart Operations (`cart.php`)
```php
// Functions:
- Add to cart
- Update quantity
- Remove items
- Clear cart
- Calculate totals (subtotal, tax, shipping)
- Free shipping threshold
- Proceed to checkout
```

#### Cart Validation
```php
// Checks:
- Product availability
- Stock levels
- Price validity
- Customer authentication
```

### 3. **Checkout Process**

#### Checkout Flow (`checkout.php`)
```php
1. Validate cart (not empty)
2. Select/Add shipping address
3. Select/Add billing address
4. Choose payment method
5. Add order notes (optional)
6. Review order summary
7. Place order
```

#### Payment Methods Supported
- Credit Card
- Debit Card
- PayPal
- GCash
- Cash on Delivery

#### Payment Processing (`payment.php`)
```php
// Features:
- Payment form validation
- Card number formatting
- Expiry date validation
- CVV validation
- Transaction ID generation
- Payment status tracking
- Order confirmation
```

### 4. **Order Management**

#### Order Processing Flow
```php
1. Order Creation
   - Generate order number (ORD-YYYYMMDD-HASH)
   - Insert order record
   - Insert order items
   - Create payment record
   - Create shipping record
   
2. Payment Processing
   - Validate payment details
   - Update payment status
   - Update order status
   - Clear shopping cart
   
3. Order Confirmation
   - Send confirmation email
   - Display order details
   - Track order status
```

#### Order Status Workflow
```
pending → processing → shipped → delivered
                    ↓
                 cancelled
```

### 5. **User Profile Management**

#### Profile Features (`profile.php`)
```php
// Tabs:
1. Account Info
   - Update personal details
   - View account status
   
2. Change Password
   - Verify current password
   - Set new password
   - Password strength requirements
   
3. Addresses
   - Add new addresses
   - Set default addresses
   - Delete addresses
```

### 6. **Review System**

#### Review Features (`product.php`)
```php
// Functionality:
- Star rating (1-5)
- Review title
- Review comment
- Verified purchase badge
- Review approval system
- User validation (must be logged in)
- Duplicate review prevention
```

### 7. **Notification System**

#### Notification Types (`notifications.php`)
```php
- order_status: Order status changes
- payment: Payment confirmations
- shipping: Shipping updates
- system: System announcements
```

#### Notification Features
- Unread badge count
- Mark as read
- Mark all as read
- Order linking
- Timestamp formatting

---

## Configuration

### Site Settings (`config.php`)

#### Database Configuration
```php
define('DB_HOST', 'sql100.infinityfree.com');
define('DB_USER', 'if0_40532602');
define('DB_PASS', 'NblOpzQzps');
define('DB_NAME', 'if0_40532602_malls');
```

#### Site Constants
```php
SITE_NAME             // Site name
SITE_EMAIL            // Contact email
SITE_PHONE            // Contact phone
TAX_RATE              // Tax percentage (decimal)
SHIPPING_COST         // Standard shipping cost
FREE_SHIPPING_THRESHOLD // Free shipping minimum
CURRENCY_SYMBOL       // ₱ for PHP
ITEMS_PER_PAGE        // Pagination limit
ENABLE_REVIEWS        // Enable/disable reviews
```

#### Email Configuration
```php
GMAIL_SMTP_HOST       // smtp.gmail.com
GMAIL_SMTP_PORT       // 587
GMAIL_SENDER_EMAIL    // Sender email
GMAIL_SENDER_PASSWORD // App password
GMAIL_SENDER_NAME     // Sender name
ENABLE_EMAIL_NOTIFICATIONS
ENABLE_ORDER_EMAILS
ENABLE_SHIPPING_EMAILS
ENABLE_PAYMENT_EMAILS
```

### Helper Functions

#### `formatCurrency($amount)`
```php
// Formats amount as currency
// Returns: ₱1,234.56
```

#### `calculateTax($subtotal)`
```php
// Calculates tax amount
// Returns: $subtotal * TAX_RATE
```

#### `calculateShipping($subtotal)`
```php
// Calculates shipping cost
// Returns: 0 if >= FREE_SHIPPING_THRESHOLD, else SHIPPING_COST
```

#### `isLoggedIn()`
```php
// Checks if customer is authenticated
// Returns: boolean
```

#### `getCurrentUser()`
```php
// Gets current logged-in customer data
// Returns: array or null
```

---

## Admin Panel

### Overview

The admin panel is a comprehensive management interface accessible at `/admin/` that allows administrators to manage all aspects of the e-commerce platform. Three role levels provide different permission levels.

### Admin Roles & Permission System

The platform implements a hierarchical role-based access control (RBAC) system managed through the **RoleManager** class (`includes/RoleManager.php`).

#### **Super Admin** (`super_admin`)
**Permissions:**
- Full system access to all features
- **Admin Management**: Create, edit, delete admins and moderators
- **Product Management**: Full CRUD operations on all products and categories
- **Order Management**: View and manage all orders
- **Inventory Management**: Full inventory control
- **Customer Management**: Full customer access and control
- **Coupon Management**: Create and manage all coupons
- **Review Management**: Approve/reject all reviews
- **Rider Management**: Full control of rider accounts
- **Delivery Management**: Manage all deliveries
- **Reports**: Access to all reports
- **Activity Logs**: View all system activity
- **Settings**: Modify all system settings

#### **Admin** (`admin`)
**Permissions:**
- **Moderator Management**: Can create and manage moderators only
- **Product Management**: Full CRUD operations on all products and categories
- **Order Management**: View and manage all orders and order details
- **Inventory Management**: Full inventory control
- **Customer Management**: Full customer access and control
- **Coupon Management**: Create and manage all coupons
- **Review Management**: Approve/reject all reviews
- **Rider Management**: Full control of rider accounts
- **Delivery Management**: Manage all deliveries
- **Reports**: Access to all reports
- **Activity Logs**: View all system activity
- **Restrictions**: 
  - Cannot create other admins or super admins
  - Cannot access settings page
  - Cannot manage other admin accounts

#### **Moderator** (`moderator`)
**Permissions:**
- **Order Management**: View and manage orders
- **Customer Management**: View and manage customer information
- **Review Management**: View and manage product reviews
- **Activity Logs**: View activity logs
- **Dashboard**: Access to dashboard view
- **Restrictions**:
  - No access to product management
  - No access to inventory management
  - No access to coupon creation
  - No access to rider management
  - No access to delivery management
  - No access to reports
  - No access to settings
  - No access to admin user management

### Permission Management System

#### Permission Constants (`includes/RoleManager.php`)
```php
// Available permissions
PERMISSION_VIEW_DASHBOARD
PERMISSION_MANAGE_USERS
PERMISSION_MANAGE_ADMINS        // Only Super Admin
PERMISSION_MANAGE_MODERATORS    // Super Admin & Admin
PERMISSION_MANAGE_PRODUCTS
PERMISSION_MANAGE_ORDERS
PERMISSION_MANAGE_CUSTOMERS
PERMISSION_MANAGE_CATEGORIES
PERMISSION_MANAGE_COUPONS
PERMISSION_MANAGE_INVENTORY
PERMISSION_MANAGE_REVIEWS
PERMISSION_MANAGE_RIDERS
PERMISSION_MANAGE_DELIVERIES
PERMISSION_VIEW_REPORTS
PERMISSION_MANAGE_SETTINGS      // Only Super Admin
PERMISSION_VIEW_ACTIVITY_LOGS
```

#### Helper Functions (`config.php`)
```php
// Get current admin's role
getAdminRole() -> string

// Check if current admin has specific permission
hasAdminPermission($permission) -> boolean

// Check if current admin can create a role
canCreateAdminRole($targetRole) -> boolean
```

#### Implementation Pattern
Every protected admin page follows this pattern:
```php
<?php
require_once '../config.php';

// Check login
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Check permission
if (!hasAdminPermission(RoleManager::PERMISSION_MANAGE_PRODUCTS)) {
    header('Location: index.php');
    exit;
}
```

#### Navigation Filtering
The sidebar (`admin/sidebar.php`) automatically filters menu items based on the current user's role using permission checks. Users only see menu items they have access to.

### Admin Features

#### 1. **Dashboard** (`admin/index.php`)

**Real-time Statistics:**
- Total revenue (from completed payments)
- Total orders (all statuses)
- Active customers
- Active products
- Pending orders count
- Low stock items count

**Visualizations:**
- Monthly revenue chart (6-month trend)
- Recent orders table (last 10)
- Order status breakdown pie chart
- Best-selling products
- Recent activity feed

#### 2. **Product Management** (`admin/products.php`)

**Features:**
- Create new products with:
  - Product name, description
  - Price and sale price
  - SKU (unique identifier)
  - Brand, weight, dimensions
  - Category assignment
  - Featured status
- Edit existing products
- Bulk product operations
- Search and filter by category
- Image upload and gallery management
- Publish/unpublish products
- Pagination (configurable items per page)

**Related Functionality:**
- Product images: Primary and gallery images
- SKU validation (must be unique)
- Price validation
- Inventory sync

#### 3. **Inventory Management** (`admin/inventory.php`)

**Features:**
- Stock level tracking
- Reserved quantity management (for pending orders)
- Reorder level configuration
- Low stock alerts
- Stock history tracking
- Bulk stock updates
- Last restocked timestamp
- Search by product name or SKU

**Alerts:**
- Products below reorder level highlighted in red
- Out of stock alerts
- Reserved quantity warnings

#### 4. **Order Management** (`admin/orders.php` & `admin/order_details.php`)

**Order List View:**
- All orders with status
- Filter by status (pending, processing, shipped, delivered, cancelled, refunded)
- Filter by date range
- Filter by customer
- Search by order number
- Sort by date, amount, status
- Quick action buttons

**Order Details View:**
- Order number and timestamps
- Customer information
- Billing/shipping addresses
- Order items with quantities and prices
- Payment details and status
- Shipping information and tracking
- Applied coupons and discounts
- Admin notes section
- Status update buttons
- Quick actions

**Order Actions:**
- Update order status
- Update payment status
- Add admin notes
- View complete order history
- Send notifications
- Print order details
- Cancel/refund orders

#### 5. **Customer Management** (`admin/customers.php`)

**Features:**
- View all customers
- Search by name or email
- Filter by active/inactive status
- View customer:
  - Registration date
  - Last login
  - Total orders
  - Total spent
  - Contact information
- Activate/deactivate customer accounts
- View customer order history
- View customer addresses
- Export customer data

#### 6. **Coupon Management** (`admin/coupons.php`)

**Features:**
- Create coupons with:
  - Coupon code (unique)
  - Discount type (percentage or fixed amount)
  - Discount value
  - Minimum purchase requirement
  - Maximum discount cap
  - Usage limit and count
  - Valid date range
- Edit existing coupons
- Enable/disable coupons
- View usage statistics
- Search and filter
- Bulk coupon operations

**Coupon Types:**
```
Percentage:   10% off (discount_value = 10)
Fixed Amount: ₱500 off (discount_value = 500)
```

#### 7. **Review Management** (`admin/reviews.php`)

**Features:**
- View all product reviews
- Filter by:
  - Product
  - Rating (1-5 stars)
  - Approval status (pending/approved)
  - Verified purchase status
- Approve/reject reviews
- Delete inappropriate reviews
- View review details:
  - Customer name
  - Product reviewed
  - Rating and comment
  - Order verification
  - Timestamp

#### 8. **Activity Logging** (`admin/activity_logs.php`)

**Features:**
- Complete audit trail of all system changes
- Filter by:
  - User type (admin/customer)
  - Action type
  - Date range
  - Affected table
  - IP address
- View detailed change log showing:
  - Old values
  - New values
  - Changed by (admin/customer)
  - IP address and user agent
  - Exact timestamp

**Tracked Actions:**
- User login/logout
- Product changes (create, update, delete)
- Order status changes
- Payment updates
- Inventory adjustments
- Admin actions
- System changes

#### 9. **Reports** (`admin/reports.php`)

**Available Reports:**
- **Sales Report**:
  - Total revenue
  - Average order value
  - Orders by status
  - Revenue by date range
- **Product Report**:
  - Best sellers by quantity
  - Best sellers by revenue
  - Low stock products
  - Inactive products
- **Customer Report**:
  - Total customers
  - New customers
  - Active customers
  - Customer spending breakdown
- **Payment Report**:
  - Payment methods used
  - Payment status breakdown
  - Completed vs pending payments

**Export Options:**
- Generate PDF reports
- Export to CSV

#### 10. **Settings & Configuration** (`admin/settings.php`)

**Site Settings:**
- Site name and contact info
- Currency symbol
- Tax rate (%)
- Shipping cost
- Free shipping threshold
- Items per page (pagination)
- Maintenance mode toggle

**Email Settings:**
- Enable/disable email notifications
- Gmail SMTP configuration
- Email sender details
- Toggle per email type:
  - Order confirmation emails
  - Payment confirmation emails
  - Shipping notification emails

**System Settings:**
- Enable/disable reviews
- Require email verification
- Review management

**Maintenance Mode:**
- Toggle maintenance mode
- Creates/removes `maintenance.flag`
- Auto-blocks customer access
- Admin access maintained

#### 11. **Admin Management** (`admin/super_admin.php`)

**Access Level:** Super Admin only (automatic menu filtering based on role)

**Features:**
- **View All Admins:**
  - Total admin count
  - Super Admin count
  - Regular Admin count
  - Moderator count
  - Active/Inactive status breakdown
  
- **Create New Admin/Moderator:**
  - Role-restricted creation (Super Admin can create Admins & Moderators, Admin can create Moderators only)
  - Username and email validation
  - Password strength requirements (min 6 characters)
  - Full name entry
  - Role assignment with restricted options based on current role

- **Admin Account Management:**
  - Edit admin details (name, email)
  - Update admin role
  - Activate/deactivate accounts
  - View admin activity (total actions performed)
  - View last activity timestamp
  - Delete admin accounts (prevents self-deletion)

- **Admin Statistics:**
  - Last login tracking
  - Activity metrics per admin
  - Account creation timestamp

**Role-Based Creation Restrictions:**
- Super Admin: Can create Admins and Moderators
- Admin: Can create Moderators only
- Moderator: Cannot create any users

#### 12. **Rider Management** (`admin/riders.php`)

**Access Level:** Admin+ (Admin, Super Admin)

**Features:**
- View all riders with status
- Create new rider accounts
- Edit rider information
- Activate/deactivate riders
- View rider ratings and performance
- Track rider delivery statistics
- Update rider vehicle information

### Admin Authentication

#### Login Process (`admin/login.php`)
```
1. Enter username/email
2. Enter password
3. Verify credentials against admin_users table
4. Create session: $_SESSION['admin_id']
5. Log activity (login)
6. Redirect to dashboard
```

#### Session Management
- `$_SESSION['admin_id']` - Current admin ID
- `$_SESSION['admin_role']` - Admin role (super_admin, admin, moderator)
- Session timeout: 1 hour
- Automatic logout on browser close

#### Role-Based Access Control
```php
// Session stores role on login
$_SESSION['admin_role'] = $admin['role'];

// Permission checks on protected pages
if (!hasAdminPermission(RoleManager::PERMISSION_MANAGE_PRODUCTS)) {
    header('Location: index.php');
    exit;
}

// Dynamic menu filtering in sidebar
if (hasAdminPermission(RoleManager::PERMISSION_MANAGE_PRODUCTS)) {
    // Show menu item
}
```

#### Security Features
- Password hashing (bcrypt)
- Session-based authentication
- Admin-only routes protection
- **Role-based access control (RBAC)** with granular permissions
- Permission enforcement on all protected pages
- Automatic sidebar menu filtering by role
- Hierarchical role system (Super Admin → Admin → Moderator)
- Restricted role creation (cannot create above current role)
- Activity logging for all actions
- IP address logging
- User agent tracking
- Failed login attempts logged

### File Structure

```
admin/
├── index.php              # Dashboard & statistics
├── login.php              # Admin login page
├── logout.php             # Session termination
├── products.php           # Product management
├── categories.php         # Category management
├── inventory.php          # Inventory tracking
├── orders.php             # Order list
├── order_details.php      # Order details & updates
├── customers.php          # Customer management
├── coupons.php            # Coupon management
├── reviews.php            # Review moderation
├── activity_logs.php      # Audit trail
├── reports.php            # Analytics & reports
├── settings.php           # Site configuration
├── super_admin.php        # Admin user management
├── reset_password.php     # Password management
├── sidebar.php            # Navigation sidebar
├── admin-styles.css       # Admin panel styling
└── [other utility files]
```

### Typical Admin Workflows

#### Processing a New Order
1. **Dashboard**: See pending order notification
2. **Orders**: Click on order from pending list
3. **Order Details**: 
   - Review customer & shipping details
   - Verify payment status
   - Confirm all items in stock
4. **Update Status**: Change from `pending` → `processing`
5. **Notify**: System sends confirmation to customer
6. **Prepare**: Mark as ready to ship

#### Managing Low Stock
1. **Dashboard**: See low stock alert
2. **Inventory**: Click on low stock product
3. **Current Stock**: Review reorder level
4. **Update**: Enter new quantity received
5. **Notes**: Optional restocking notes
6. **Alerts**: System updates reorder level if needed

#### Creating a Promotional Coupon
1. **Coupons**: Click "New Coupon"
2. **Details**: Enter coupon code (e.g., "SUMMER25")
3. **Discount**: Choose type (percentage or fixed)
4. **Constraints**: Set minimum purchase, max discount
5. **Dates**: Set active date range
6. **Limit**: Set usage limit (or leave unlimited)
7. **Save**: Coupon available immediately

---

## User Flows

### 1. **Customer Registration Flow**

```
register.php
  ↓
[Validate Input]
  ├─ First/Last Name (letters only)
  ├─ Email (valid format, unique)
  ├─ Phone (numbers only, optional)
  ├─ Password (8+ chars, strength check)
  └─ Confirm Password (match)
  ↓
[Hash Password]
  ↓
[Insert Customer]
  ↓
[Log Activity]
  ↓
[Send Welcome Email]
  ↓
Redirect to login.php?registered=1
```

### 2. **Shopping Flow**

```
shop.php (Browse Products)
  ↓
product.php (View Details)
  ↓
[Add to Cart]
  ↓
cart.php (Review Cart)
  ↓
checkout.php (Enter Details)
  ↓
payment.php (Process Payment)
  ↓
order_success.php (Confirmation)
```

### 3. **Order Processing Flow**

```
[Place Order]
  ↓
Start Transaction
  ├─ Create Order
  ├─ Insert Order Items
  ├─ Create Payment Record
  └─ Create Shipping Record
  ↓
Commit Transaction
  ↓
Redirect to Payment
  ↓
[Process Payment]
  ↓
Update Payment Status
  ↓
Update Order Status
  ↓
Clear Shopping Cart
  ↓
Send Confirmation Email
  ↓
Display Success Page
```

---

## Security Features

### 1. **Authentication Security**

```php
// Password Hashing
password_hash($password, PASSWORD_DEFAULT)
password_verify($input, $hash)

// Session Management
session_start()
$_SESSION['customer_id']
$_SESSION['first_name']

// Login Protection
- Account active check
- Failed login logging
- Last login timestamp
```

### 2. **Input Validation**

#### Client-Side (JavaScript)
```javascript
// Name validation: letters only
const namePattern = /^[a-zA-Z\s'-]+$/;

// Email validation
const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

// Phone validation: numbers only
const phonePattern = /^[0-9+\-\s()]+$/;

// Real-time feedback
- Input restrictions (keypress)
- Blur validation
- Error/success indicators
```

#### Server-Side (PHP)
```php
// SQL Injection Prevention
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);

// XSS Prevention
htmlspecialchars($output, ENT_QUOTES, 'UTF-8')

// Input Sanitization
trim($_POST['input'])
intval($_POST['number'])
filter_var($email, FILTER_VALIDATE_EMAIL)
```

### 3. **SQL Injection Protection**

```php
// ALWAYS use prepared statements
$stmt = $conn->prepare("INSERT INTO table (col) VALUES (?)");
$stmt->bind_param("s", $value);
$stmt->execute();

// NEVER concatenate user input
// BAD: "SELECT * FROM users WHERE id = " . $_GET['id']
// GOOD: prepared statement with bind_param
```

### 4. **CSRF Protection**

```php
// Session-based authentication
// Only authenticated users can:
- Place orders
- Modify cart
- Update profile
- Leave reviews
```

### 5. **Activity Logging**

```php
logCustomerActivity(
    $customer_id,
    $action_type,      // 'login', 'order_create', 'cart_add', etc.
    $description,      // Human-readable description
    $table_affected,   // Database table
    $record_id,        // Record ID
    $old_values,       // Previous data (JSON)
    $new_values        // New data (JSON)
);

// Logs include:
- IP address
- User agent
- Timestamp
- Complete audit trail
```

---

## Email System

### Email Functions (`includes/email.php`)

#### 1. **Welcome Email**
```php
sendWelcomeEmail($to_email, $customer_name)
```
Sent when new customer registers.

#### 2. **Order Confirmation**
```php
sendOrderConfirmationEmail(
    $order_id,
    $to_email,
    $customer_name,
    $order_number,
    $total_amount
)
```
Sent after order is placed.

#### 3. **Payment Confirmation**
```php
sendPaymentConfirmationEmail(
    $order_id,
    $to_email,
    $customer_name,
    $order_number,
    $amount,
    $transaction_id
)
```
Sent after payment is processed.

#### 4. **Shipping Notification**
```php
sendShippingNotificationEmail(
    $order_id,
    $to_email,
    $customer_name,
    $order_number,
    $tracking_number
)
```
Sent when order is shipped.

### Email Configuration

```php
// Gmail SMTP Settings
GMAIL_SMTP_HOST = 'smtp.gmail.com'
GMAIL_SMTP_PORT = 587
GMAIL_SENDER_EMAIL = 'jrd.malls@gmail.com'
GMAIL_SENDER_PASSWORD = 'app-password' // Not regular password
GMAIL_SENDER_NAME = 'JRD Malls'
```

### Email Features

- HTML email templates
- Professional branding
- Order details included
- Responsive design
- Error logging
- Enable/disable per email type

---

## Maintenance Mode

### Overview

The system has a robust maintenance mode with dual-check system:
1. File flag (`maintenance.flag`)
2. Database setting (`site_settings.maintenance_mode`)

### How It Works

#### Primary Check (`config.php`)
```php
// File flag check (fastest)
if (file_exists(__DIR__ . '/maintenance.flag')) {
    // Only redirect non-admins
    if (!isset($_SESSION['admin_id'])) {
        header('Location: /maintenance.php');
        exit;
    }
}

// Database check (secondary)
// Checks site_settings table
```

### Maintenance Page Features (`maintenance.php`)

- Auto-refresh every 30 seconds
- Animated maintenance icon
- Progress bar animation
- Information boxes:
  - What's happening
  - Admin access link
  - Contact information
- Professional design
- Responsive layout

### Admin Access

Admins can access the site during maintenance:
- Check: `$_SESSION['admin_id']`
- Admin login: `/admin/login.php`
- Full site access maintained

### Enabling/Disabling

#### Via Admin Panel
1. Login to admin panel
2. Settings → Site Settings
3. Toggle "Maintenance Mode"
4. Creates/removes `maintenance.flag`
5. Updates database setting

#### Manual Method
```php
// Enable: Create file
touch('maintenance.flag');

// Disable: Delete file
unlink('maintenance.flag');
```

---

## Troubleshooting

### Common Issues

#### 1. **Database Connection Failed**

**Symptoms:**
- White screen
- "Database connection failed" error

**Solutions:**
```php
// Check config.php credentials
define('DB_HOST', 'correct-host');
define('DB_USER', 'correct-user');
define('DB_PASS', 'correct-password');
define('DB_NAME', 'correct-database');

// Test connection
$conn = getDBConnection();
if (!$conn) {
    error_log("Connection error: " . mysqli_connect_error());
}
```

#### 2. **Session Issues**

**Symptoms:**
- Can't login
- Cart items disappear
- "Not logged in" errors

**Solutions:**
```php
// Check session_start() in config.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check session data
var_dump($_SESSION);

// Clear sessions
session_destroy();
```

#### 3. **Cart Not Updating**

**Symptoms:**
- Items not added
- Quantities not changing

**Solutions:**
```sql
-- Check shopping_cart table
SELECT * FROM shopping_cart WHERE customer_id = ?;

-- Check inventory
SELECT * FROM inventory WHERE product_id = ?;

-- Verify UNIQUE constraint
SHOW CREATE TABLE shopping_cart;
```

#### 4. **Email Not Sending**

**Symptoms:**
- No confirmation emails
- Error in logs

**Solutions:**
```php
// Check Gmail settings
- Use App Password (not regular password)
- Enable "Less secure app access"
- Check SMTP settings

// Test email function
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check email settings
var_dump(ENABLE_EMAIL_NOTIFICATIONS);
var_dump(GMAIL_SENDER_EMAIL);
```

#### 5. **Payment Processing Failed**

**Symptoms:**
- Order created but payment failed
- Transaction not recorded

**Solutions:**
```php
// Check transaction
try {
    $conn->begin_transaction();
    // ... operations
    $conn->commit();
} catch (Exception $e) {
    $conn->rollback();
    error_log($e->getMessage());
}

// Verify payment record
SELECT * FROM payments WHERE order_id = ?;

// Check order status
SELECT * FROM orders WHERE order_number = ?;
```

### Debug Mode

Enable detailed error reporting:

```php
// In config.php (development only)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log');

// In production
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
```

### Logging

Check activity logs for issues:

```sql
-- Recent errors
SELECT * FROM activity_logs 
WHERE action_type LIKE '%error%' 
ORDER BY created_at DESC 
LIMIT 50;

-- User activity
SELECT * FROM activity_logs 
WHERE user_id = ? 
ORDER BY created_at DESC;
```

---

## Performance Optimization

### 1. **Database Optimization**

```sql
-- Add indexes for frequently queried columns
CREATE INDEX idx_customer_email ON customers(email);
CREATE INDEX idx_product_category ON products(category_id);
CREATE INDEX idx_order_customer ON orders(customer_id);
CREATE INDEX idx_order_date ON orders(created_at);

-- Optimize queries
EXPLAIN SELECT * FROM products WHERE category_id = ?;
```

### 2. **Caching**

```php
// Settings cache in config.php
$GLOBALS['site_settings_cache'] = null;

function getSiteSettings() {
    if ($GLOBALS['site_settings_cache'] !== null) {
        return $GLOBALS['site_settings_cache'];
    }
    // ... fetch from database
    $GLOBALS['site_settings_cache'] = $settings;
    return $settings;
}
```

### 3. **Image Optimization**

- Use appropriate image sizes
- Lazy loading: `loading="lazy"`
- WebP format for better compression
- CDN for static assets

### 4. **Session Optimization**

```php
// Set session cookie parameters
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Lax'
]);
```

---

## Security Best Practices

### 1. **Production Checklist**

- [ ] Disable error display
- [ ] Enable error logging
- [ ] Use HTTPS (SSL certificate)
- [ ] Set secure session cookies
- [ ] Update database credentials
- [ ] Remove debug code
- [ ] Set proper file permissions
- [ ] Enable CSRF protection
- [ ] Implement rate limiting
- [ ] Regular security audits

### 2. **Password Policy**

```php
// Minimum requirements
- Length: 8+ characters
- Uppercase: 1+ letter
- Lowercase: 1+ letter
- Number: 1+ digit
- Special char: 1+ (!@#$%^&*)
```

### 3. **SQL Security**

```php
// ALWAYS use prepared statements
// NEVER trust user input
// ALWAYS validate and sanitize
// Use least privilege database users
```

### 4. **File Upload Security**

```php
// If implementing file uploads:
- Validate file type
- Check file size
- Sanitize filename
- Store outside web root
- Use unique filenames
- Check for malicious content
```

---

## API Reference

### Helper Functions

#### `getDBConnection()`
```php
/**
 * Get database connection
 * @return mysqli|null Connection object or null on failure
 */
```

#### `isLoggedIn()`
```php
/**
 * Check if customer is logged in
 * @return bool
 */
```

#### `getCurrentUser()`
```php
/**
 * Get current logged-in customer data
 * @return array|null Customer data or null
 */
```

#### `formatCurrency($amount)`
```php
/**
 * Format amount as currency
 * @param float $amount Amount to format
 * @return string Formatted currency (₱1,234.56)
 */
```

#### `calculateTax($subtotal)`
```php
/**
 * Calculate tax amount
 * @param float $subtotal Subtotal amount
 * @return float Tax amount
 */
```

#### `calculateShipping($subtotal)`
```php
/**
 * Calculate shipping cost
 * @param float $subtotal Subtotal amount
 * @return float Shipping cost (0 if free shipping applies)
 */
```

#### `logCustomerActivity(...)`
```php
/**
 * Log customer activity
 * @param int $customer_id Customer ID
 * @param string $action_type Action type
 * @param string $description Description
 * @param string $table_affected Table name
 * @param int $record_id Record ID
 * @param array $old_values Old values
 * @param array $new_values New values
 * @return bool Success
 */
```

---

## Deployment Guide

### 1. **Pre-Deployment**

```bash
# Test locally
- All features working
- No PHP errors
- No JavaScript errors
- All forms validate
- Email sending works
- Payment processing works
```

### 2. **Server Setup**

```bash
# Requirements
- PHP 7.4+
- MySQL 5.7+
- SSL certificate
- cPanel or equivalent

# File permissions
chmod 755 /public_html
chmod 644 *.php
chmod 755 /admin
```

### 3. **Database Setup**

```sql
-- Import database
mysql -u username -p database_name < malls.sql

-- Update config.php with production credentials
define('DB_HOST', 'production-host');
define('DB_USER', 'production-user');
define('DB_PASS', 'production-password');
define('DB_NAME', 'production-database');
```

### 4. **Configuration Updates**

```php
// config.php
error_reporting(0);
ini_set('display_errors', 0);

// Update site URLs
define('SITE_URL', 'https://yourdomain.com');

// Update email settings
define('GMAIL_SENDER_EMAIL', 'your-email@gmail.com');
define('GMAIL_SENDER_PASSWORD', 'your-app-password');
```

### 5. **Security Hardening**

```apache
# .htaccess
# Prevent directory browsing
Options -Indexes

# Protect sensitive files
<FilesMatch "^(config\.php|\.sql|\.log)$">
    Order allow,deny
    Deny from all
</FilesMatch>

# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 6. **Post-Deployment**

```bash
# Test checklist
- [ ] Homepage loads
- [ ] Login works
- [ ] Registration works
- [ ] Products display
- [ ] Cart functions
- [ ] Checkout works
- [ ] Payment processes
- [ ] Emails send
- [ ] Admin panel accessible
- [ ] SSL certificate valid
```

---

## Maintenance Tasks

### Daily
- Check error logs
- Monitor order processing
- Verify email delivery

### Weekly
- Review activity logs
- Check inventory levels
- Backup database
- Update product images

### Monthly
- Security audit
- Performance review
- Update dependencies
- Review customer feedback
- Analyze sales data

---

## Support & Contact

For technical support or questions about this documentation:

- **Email**: jrd.malls@gmail.com
- **Phone**: +63 992 607 2695
- **Documentation Updates**: Check Git repository

---

## License

Copyright © 2025 JRD Malls. All rights reserved.

---

**Last Updated**: December 2025  
**Version**: 1.0  
**Author**: Development Team