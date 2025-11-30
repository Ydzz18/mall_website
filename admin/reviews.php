<?php
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$conn = getDBConnection();
$message = '';

// Handle review approval/rejection
if (isset($_GET['action'])) {
    $review_id = intval($_GET['id']);
    
    if ($_GET['action'] === 'approve') {
        $conn->query("UPDATE reviews SET is_approved = 1 WHERE review_id = $review_id");
        $message = 'Review approved successfully!';
    } elseif ($_GET['action'] === 'reject') {
        $conn->query("UPDATE reviews SET is_approved = 0 WHERE review_id = $review_id");
        $message = 'Review rejected successfully!';
    } elseif ($_GET['action'] === 'delete') {
        $conn->query("DELETE FROM reviews WHERE review_id = $review_id");
        $message = 'Review deleted successfully!';
    }
}

// Filter reviews
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$where = "1=1";

if ($filter === 'pending') {
    $where = "r.is_approved = 0";
} elseif ($filter === 'approved') {
    $where = "r.is_approved = 1";
}

// Get reviews
$reviews = $conn->query("
    SELECT r.*, 
           p.product_name,
           c.first_name, c.last_name, c.email
    FROM reviews r
    JOIN products p ON r.product_id = p.product_id
    JOIN customers c ON r.customer_id = c.customer_id
    WHERE $where
    ORDER BY r.created_at DESC
")->fetch_all(MYSQLI_ASSOC);

// Get statistics
$stats = $conn->query("
    SELECT 
        COUNT(*) as total_reviews,
        SUM(CASE WHEN is_approved = 0 THEN 1 ELSE 0 END) as pending_reviews,
        SUM(CASE WHEN is_approved = 1 THEN 1 ELSE 0 END) as approved_reviews,
        AVG(rating) as average_rating
    FROM reviews
")->fetch_assoc();

$conn->close();

function renderStars($rating) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $stars .= '<span style="color: #f39c12;">★</span>';
        } else {
            $stars .= '<span style="color: #ddd;">★</span>';
        }
    }
    return $stars;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews Management - Admin</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/png" href="../logo/icon.png">
    <style>
        <?php include 'admin-styles.css'; ?>
        
        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .filter-tab {
            padding: 10px 20px;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            text-decoration: none;
            color: #2c3e50;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .filter-tab:hover {
            border-color: #3498db;
            background: #e3f2fd;
        }
        
        .filter-tab.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }
        
        .review-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 4px solid #e0e0e0;
        }
        
        .review-card.pending {
            border-left-color: #f39c12;
        }
        
        .review-card.approved {
            border-left-color: #27ae60;
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }
        
        .review-info {
            flex: 1;
        }
        
        .review-product {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .review-customer {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .review-rating {
            font-size: 1.2rem;
        }
        
        .review-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .review-title {
            font-weight: bold;
            margin-bottom: 8px;
            color: #2c3e50;
        }
        
        .review-text {
            color: #555;
            line-height: 1.6;
        }
        
        .review-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }
        
        .review-date {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .review-actions {
            display: flex;
            gap: 5px;
        }
        
        .verified-badge {
            background: #d4edda;
            color: #155724;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <?php include 'sidebar.php'; ?>
        
        <main class="admin-main">
            <header class="admin-header">
                <h1>Reviews Management</h1>
            </header>
            
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            
            <!-- Statistics -->
            <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                <div class="stat-card blue">
                    <div class="stat-title">Total Reviews</div>
                    <div class="stat-value"><?php echo number_format($stats['total_reviews']); ?></div>
                </div>
                <div class="stat-card orange">
                    <div class="stat-title">Pending Approval</div>
                    <div class="stat-value"><?php echo number_format($stats['pending_reviews']); ?></div>
                </div>
                <div class="stat-card green">
                    <div class="stat-title">Approved</div>
                    <div class="stat-value"><?php echo number_format($stats['approved_reviews']); ?></div>
                </div>
                <div class="stat-card purple">
                    <div class="stat-title">Average Rating</div>
                    <div class="stat-value"><?php echo number_format($stats['average_rating'], 1); ?> ★</div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="filter-tabs">
                <a href="?filter=all" class="filter-tab <?php echo $filter === 'all' ? 'active' : ''; ?>">
                    All Reviews
                </a>
                <a href="?filter=pending" class="filter-tab <?php echo $filter === 'pending' ? 'active' : ''; ?>">
                    Pending (<?php echo $stats['pending_reviews']; ?>)
                </a>
                <a href="?filter=approved" class="filter-tab <?php echo $filter === 'approved' ? 'active' : ''; ?>">
                    Approved (<?php echo $stats['approved_reviews']; ?>)
                </a>
            </div>
            
            <!-- Reviews List -->
            <div>
                <?php foreach ($reviews as $review): ?>
                    <div class="review-card <?php echo $review['is_approved'] ? 'approved' : 'pending'; ?>">
                        <div class="review-header">
                            <div class="review-info">
                                <div class="review-product">
                                    <?php echo htmlspecialchars($review['product_name']); ?>
                                    <?php if ($review['is_verified_purchase']): ?>
                                        <span class="verified-badge">✓ Verified Purchase</span>
                                    <?php endif; ?>
                                </div>
                                <div class="review-customer">
                                    By <?php echo htmlspecialchars($review['first_name'] . ' ' . $review['last_name']); ?>
                                    (<?php echo htmlspecialchars($review['email']); ?>)
                                </div>
                            </div>
                            <div class="review-rating">
                                <?php echo renderStars($review['rating']); ?>
                            </div>
                        </div>
                        
                        <div class="review-content">
                            <?php if ($review['title']): ?>
                                <div class="review-title"><?php echo htmlspecialchars($review['title']); ?></div>
                            <?php endif; ?>
                            <div class="review-text"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></div>
                        </div>
                        
                        <div class="review-footer">
                            <div class="review-date">
                                <?php echo date('M d, Y h:i A', strtotime($review['created_at'])); ?>
                            </div>
                            <div class="review-actions">
                                <?php if (!$review['is_approved']): ?>
                                    <a href="?action=approve&id=<?php echo $review['review_id']; ?>&filter=<?php echo $filter; ?>" 
                                       class="btn-admin btn-success">Approve</a>
                                <?php else: ?>
                                    <a href="?action=reject&id=<?php echo $review['review_id']; ?>&filter=<?php echo $filter; ?>" 
                                       class="btn-admin btn-danger">Reject</a>
                                <?php endif; ?>
                                <a href="?action=delete&id=<?php echo $review['review_id']; ?>&filter=<?php echo $filter; ?>" 
                                   class="btn-admin btn-danger"
                                   onclick="return confirm('Delete this review?')">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <?php if (count($reviews) === 0): ?>
                    <div class="content-card" style="text-align: center; padding: 60px;">
                        <h2 style="color: #7f8c8d;">No reviews found</h2>
                        <p style="color: #95a5a6;">Reviews will appear here once customers start rating products.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>