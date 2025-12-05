# Rider Delivery System Setup Guide

## Overview

The rider delivery system is a complete delivery management solution that allows:
- Riders to login and manage their assigned deliveries
- Admins to manage riders and assign deliveries to specific riders
- Customers to track delivery status
- Real-time delivery status updates

## Installation

### Step 1: Access Setup Page

1. Login to the admin panel
2. Go to Admin Menu → Setup Riders (or navigate to `/admin/setup_riders.php`)
3. Click "Run Database Migration"

This will create all necessary database tables:
- `riders` - Stores rider information
- `delivery_assignments` - Links orders to riders
- `delivery_logs` - Tracks delivery status changes

### Step 2: Sample Riders

After migration, two sample riders are automatically created:

**Rider 1:**
- Email: `rider1@example.com`
- Password: `password123`
- Vehicle: Motorcycle

**Rider 2:**
- Email: `rider2@example.com`
- Password: `password123`
- Vehicle: Bicycle

## Features

### Rider Portal Features

#### Dashboard
- View all assigned deliveries
- Filter deliveries by status
- Search orders by order number or customer name
- View real-time delivery statistics (total assigned, in transit, completed, pending)

#### Delivery Management
- Update delivery status (Assigned → Picked Up → In Transit → Delivered)
- Report failed deliveries with reason
- Return items to sender
- Add notes to each delivery step
- View complete delivery timeline

#### Order Details
- Full order information (customer, address, items, amount)
- Customer contact information
- Complete order history
- Delivery timeline and history

### Admin Features

#### Rider Management (`/admin/riders.php`)
- Add new riders
- Edit rider information
- Deactivate/suspend riders
- View rider statistics (deliveries completed, rating)
- Search and filter riders

#### Delivery Assignment (`/admin/deliveries.php`)
- View all orders ready for delivery
- Assign/reassign riders to orders
- Filter deliveries by status
- Search deliveries
- Track rider assignments

## Delivery Status Workflow

```
pending_assignment
    ↓
assigned (admin assigns rider)
    ↓
picked_up (rider picks up order)
    ↓
in_transit (rider is delivering)
    ↓
delivered (order delivered successfully)
    ↗
    ✗ failed (delivery failed - requires reason)
    ✗ returned (item returned - requires reason)
```

## How to Use

### For Admins

#### 1. Add a New Rider

1. Go to Admin → Manage Riders
2. Click "Add Rider"
3. Fill in:
   - First Name
   - Last Name
   - Email
   - Phone
   - Vehicle Type (motorcycle, bicycle, car, truck)
   - Vehicle Plate Number (optional)
   - Password (minimum 6 characters)
   - Status (active, inactive, suspended)
4. Click "Save Rider"

#### 2. Assign Deliveries

1. Go to Admin → Manage Deliveries
2. Find an order with "Pending Assignment" status
3. Click "Assign" button
4. Select a rider from the dropdown
5. Click "Assign Rider"

The order will be assigned to the rider and they'll see it in their dashboard.

#### 3. Monitor Deliveries

1. Go to Admin → Manage Deliveries
2. Use filters and search to find specific deliveries
3. View assigned rider and current delivery status
4. Click "View" to see complete order details

### For Riders

#### 1. Login to Rider Portal

1. Navigate to: `/rider/login.php`
2. Enter email and password
3. Click "Sign In"

#### 2. View Dashboard

After login, riders see:
- Statistics (total assigned, in transit, completed, pending)
- List of assigned deliveries
- Filter options and search

#### 3. Update Delivery Status

1. Click "Update" button on a delivery
2. Select new status from dropdown:
   - **Assigned** - Initial assignment confirmation
   - **Picked Up** - Order picked up from warehouse
   - **In Transit** - On the way to customer
   - **Delivered** - Successfully delivered
   - **Failed Delivery** - Cannot deliver (requires reason)
   - **Returned** - Returning to sender (requires reason)
3. If failed/returned, provide reason in the text field
4. Add any additional notes (optional)
5. Click "Update Status"

#### 4. View Order Details

1. Click "View" button on a delivery
2. See complete order information:
   - Customer contact information
   - Shipping address
   - Items ordered
   - Order total and breakdown
   - Delivery timeline
   - Rider vehicle information

## API Functions

The following functions are available in `config.php`:

```php
// Check if rider is logged in
isRiderLoggedIn();

// Get current logged-in rider's information
getCurrentRider();

// Format currency
formatCurrency($amount);

// Get database connection
getDBConnection();
```

## Database Schema

### riders table
```sql
- rider_id (int, auto-increment, PK)
- first_name (varchar)
- last_name (varchar)
- email (varchar, unique)
- phone (varchar)
- password_hash (varchar)
- vehicle_type (enum: motorcycle, bicycle, car, truck)
- vehicle_plate (varchar)
- status (enum: active, inactive, suspended)
- is_verified (tinyint)
- rating (decimal 3,2)
- total_deliveries (int)
- completed_deliveries (int)
- created_at (timestamp)
- updated_at (timestamp)
```

### delivery_assignments table
```sql
- assignment_id (int, auto-increment, PK)
- order_id (int, FK to orders)
- rider_id (int, FK to riders)
- delivery_status (enum: pending_assignment, assigned, picked_up, in_transit, delivered, failed, returned)
- assigned_at (timestamp)
- picked_up_at (timestamp)
- delivered_at (timestamp)
- failure_reason (text)
- notes (text)
- created_at (timestamp)
- updated_at (timestamp)
```

### delivery_logs table
```sql
- log_id (int, auto-increment, PK)
- assignment_id (int, FK to delivery_assignments)
- rider_id (int, FK to riders)
- status_from (varchar)
- status_to (varchar)
- location (varchar)
- notes (text)
- created_at (timestamp)
```

## File Structure

```
nccc/
├── rider/
│   ├── login.php              (Rider login page)
│   ├── dashboard.php          (Rider dashboard)
│   ├── order_details.php      (Order details view)
│   ├── update_delivery.php    (Update delivery status)
│   ├── logout.php             (Rider logout)
│   └── index.php              (Redirect to login)
├── admin/
│   ├── riders.php             (Manage riders)
│   ├── deliveries.php         (Manage deliveries)
│   └── setup_riders.php       (Setup/migration page)
├── migrations/
│   └── add_rider_system.sql   (Database migration SQL)
└── RIDER_SYSTEM.md            (This file)
```

## URL Reference

| Page | URL | Access |
|------|-----|--------|
| Rider Login | `/rider/login.php` | Public |
| Rider Dashboard | `/rider/dashboard.php` | Rider Only |
| Order Details | `/rider/order_details.php?order_id=X` | Rider Only |
| Manage Riders | `/admin/riders.php` | Admin Only |
| Manage Deliveries | `/admin/deliveries.php` | Admin Only |
| Setup Page | `/admin/setup_riders.php` | Admin Only |

## Security Features

- Password hashing using bcrypt
- Session-based authentication
- SQL prepared statements to prevent injection
- User type validation (rider, admin, customer)
- Activity logging for all rider actions
- Role-based access control

## Troubleshooting

### Migration Not Running
- Ensure you have admin privileges
- Check database connection in `config.php`
- Verify database permissions

### Cannot Login as Rider
- Verify email address is correct
- Reset password by adding a new rider with same email
- Check if rider status is "active"

### Delivery Not Appearing in Dashboard
- Ensure order status is pending/processing/shipped
- Check delivery assignment exists in database
- Verify rider_id matches logged-in rider

### Status Update Not Working
- Ensure all required fields are filled
- For failed/returned deliveries, provide failure reason
- Check if order is already delivered
- Verify database connection

## Support

For issues or questions, contact the development team or check the main README.md file.

## Version

Rider Delivery System v1.0
