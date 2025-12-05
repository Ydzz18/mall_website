<?php
// Get product average rating and review count
function getProductRating($product_id) {
    $conn = getDBConnection();
    $result = $conn->query("
        SELECT 
            AVG(rating) as average_rating,
            COUNT(*) as review_count
        FROM reviews 
        WHERE product_id = $product_id AND is_approved = 1
    ");
    
    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return [
            'average' => round($data['average_rating'] ?? 0, 1),
            'count' => $data['review_count'] ?? 0
        ];
    }
    
    return ['average' => 0, 'count' => 0];
}

// Generate star display HTML
function getStarDisplay($rating, $count = null) {
    $full_stars = floor($rating);
    $partial = $rating - $full_stars;
    $empty_stars = 5 - $full_stars - ($partial > 0 ? 1 : 0);
    
    $stars = '';
    
    // Full stars
    for ($i = 0; $i < $full_stars; $i++) {
        $stars .= '⭐';
    }
    
    // Partial star
    if ($partial > 0) {
        if ($partial >= 0.75) {
            $stars .= '⭐';
        } else if ($partial >= 0.25) {
            $stars .= '⚡'; // Half star emoji alternative
        }
    }
    
    // Empty stars
    for ($i = 0; $i < $empty_stars; $i++) {
        $stars .= '☆';
    }
    
    $html = "<span class='product-rating'>$stars</span>";
    
    if ($count !== null) {
        $html .= " <span class='rating-count'>($count)</span>";
    }
    
    return $html;
}
?>
