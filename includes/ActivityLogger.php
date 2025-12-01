<?php
/**
 * Activity Logger Class
 * Handles logging of all activities in the system
 */

class ActivityLogger {
    private $conn;
    
    public function __construct($connection = null) {
        $this->conn = $connection ?: getDBConnection();
    }
    
    /**
     * Log an activity
     */
    public function log($params) {
        $user_type = $params['user_type']; // 'admin' or 'customer'
        $user_id = $params['user_id'];
        $action_type = $params['action_type'];
        $action_description = $params['action_description'];
        $table_affected = $params['table_affected'] ?? null;
        $record_id = $params['record_id'] ?? null;
        $old_values = isset($params['old_values']) ? json_encode($params['old_values']) : null;
        $new_values = isset($params['new_values']) ? json_encode($params['new_values']) : null;
        
        // Get IP address
        $ip_address = $this->getIpAddress();
        
        // Get user agent
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        if ($user_agent && strlen($user_agent) > 255) {
            $user_agent = substr($user_agent, 0, 255);
        }
        
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO activity_logs 
                (user_type, user_id, action_type, action_description, table_affected, 
                 record_id, old_values, new_values, ip_address, user_agent)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->bind_param(
                "sisssissss",
                $user_type,
                $user_id,
                $action_type,
                $action_description,
                $table_affected,
                $record_id,
                $old_values,
                $new_values,
                $ip_address,
                $user_agent
            );
            
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Activity Log Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Log admin action
     */
    public function logAdmin($admin_id, $action_type, $description, $table = null, $record_id = null, $old_values = null, $new_values = null) {
        return $this->log([
            'user_type' => 'admin',
            'user_id' => $admin_id,
            'action_type' => $action_type,
            'action_description' => $description,
            'table_affected' => $table,
            'record_id' => $record_id,
            'old_values' => $old_values,
            'new_values' => $new_values
        ]);
    }
    
    /**
     * Log customer action
     */
    public function logCustomer($customer_id, $action_type, $description, $table = null, $record_id = null, $old_values = null, $new_values = null) {
        return $this->log([
            'user_type' => 'customer',
            'user_id' => $customer_id,
            'action_type' => $action_type,
            'action_description' => $description,
            'table_affected' => $table,
            'record_id' => $record_id,
            'old_values' => $old_values,
            'new_values' => $new_values
        ]);
    }
    
    /**
     * Get activity logs with filters
     */
    public function getLogs($filters = []) {
        $where = [];
        $params = [];
        $types = '';
        
        if (isset($filters['user_type'])) {
            $where[] = "user_type = ?";
            $params[] = $filters['user_type'];
            $types .= 's';
        }
        
        if (isset($filters['user_id'])) {
            $where[] = "user_id = ?";
            $params[] = $filters['user_id'];
            $types .= 'i';
        }
        
        if (isset($filters['action_type'])) {
            $where[] = "action_type = ?";
            $params[] = $filters['action_type'];
            $types .= 's';
        }
        
        if (isset($filters['table_affected'])) {
            $where[] = "table_affected = ?";
            $params[] = $filters['table_affected'];
            $types .= 's';
        }
        
        if (isset($filters['date_from'])) {
            $where[] = "created_at >= ?";
            $params[] = $filters['date_from'];
            $types .= 's';
        }
        
        if (isset($filters['date_to'])) {
            $where[] = "created_at <= ?";
            $params[] = $filters['date_to'] . ' 23:59:59';
            $types .= 's';
        }
        
        if (isset($filters['search'])) {
            $where[] = "(action_description LIKE ? OR ip_address LIKE ?)";
            $search = '%' . $filters['search'] . '%';
            $params[] = $search;
            $params[] = $search;
            $types .= 'ss';
        }
        
        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
        
        $limit = $filters['limit'] ?? 50;
        $offset = $filters['offset'] ?? 0;
        
        $query = "
            SELECT al.*, 
                   CASE 
                       WHEN al.user_type = 'admin' THEN au.full_name
                       WHEN al.user_type = 'customer' THEN CONCAT(c.first_name, ' ', c.last_name)
                   END as user_name,
                   CASE 
                       WHEN al.user_type = 'admin' THEN au.email
                       WHEN al.user_type = 'customer' THEN c.email
                   END as user_email
            FROM activity_logs al
            LEFT JOIN admin_users au ON al.user_type = 'admin' AND al.user_id = au.admin_id
            LEFT JOIN customers c ON al.user_type = 'customer' AND al.user_id = c.customer_id
            $whereClause
            ORDER BY al.created_at DESC
            LIMIT ? OFFSET ?
        ";
        
        $stmt = $this->conn->prepare($query);
        
        if (!empty($params)) {
            $types .= 'ii';
            $params[] = $limit;
            $params[] = $offset;
            $stmt->bind_param($types, ...$params);
        } else {
            $stmt->bind_param('ii', $limit, $offset);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get total count of logs
     */
    public function getLogCount($filters = []) {
        $where = [];
        $params = [];
        $types = '';
        
        if (isset($filters['user_type'])) {
            $where[] = "user_type = ?";
            $params[] = $filters['user_type'];
            $types .= 's';
        }
        
        if (isset($filters['user_id'])) {
            $where[] = "user_id = ?";
            $params[] = $filters['user_id'];
            $types .= 'i';
        }
        
        if (isset($filters['action_type'])) {
            $where[] = "action_type = ?";
            $params[] = $filters['action_type'];
            $types .= 's';
        }
        
        if (isset($filters['date_from'])) {
            $where[] = "created_at >= ?";
            $params[] = $filters['date_from'];
            $types .= 's';
        }
        
        if (isset($filters['date_to'])) {
            $where[] = "created_at <= ?";
            $params[] = $filters['date_to'] . ' 23:59:59';
            $types .= 's';
        }
        
        if (isset($filters['search'])) {
            $where[] = "(action_description LIKE ? OR ip_address LIKE ?)";
            $search = '%' . $filters['search'] . '%';
            $params[] = $search;
            $params[] = $search;
            $types .= 'ss';
        }
        
        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
        
        $query = "SELECT COUNT(*) as total FROM activity_logs $whereClause";
        $stmt = $this->conn->prepare($query);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'];
    }
    
    /**
     * Get activity statistics
     */
    public function getStatistics($days = 7) {
        $date = date('Y-m-d', strtotime("-$days days"));
        
        $query = "
            SELECT 
                action_type,
                COUNT(*) as count,
                DATE(created_at) as date
            FROM activity_logs
            WHERE created_at >= ?
            GROUP BY action_type, DATE(created_at)
            ORDER BY date DESC, count DESC
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $date);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Get user's IP address
     */
    private function getIpAddress() {
        $ip_keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 
                    'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
        
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER)) {
                $ip = $_SERVER[$key];
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    }
    
    /**
     * Clean old logs (for maintenance)
     */
    public function cleanOldLogs($days = 90) {
        $date = date('Y-m-d', strtotime("-$days days"));
        
        $stmt = $this->conn->prepare("DELETE FROM activity_logs WHERE created_at < ?");
        $stmt->bind_param('s', $date);
        return $stmt->execute();
    }
}

// Helper function to get logger instance
function getActivityLogger() {
    static $logger = null;
    if ($logger === null) {
        $logger = new ActivityLogger();
    }
    return $logger;
}

// Quick logging functions
function logAdminActivity($admin_id, $action_type, $description, $table = null, $record_id = null, $old_values = null, $new_values = null) {
    return getActivityLogger()->logAdmin($admin_id, $action_type, $description, $table, $record_id, $old_values, $new_values);
}

function logCustomerActivity($customer_id, $action_type, $description, $table = null, $record_id = null, $old_values = null, $new_values = null) {
    return getActivityLogger()->logCustomer($customer_id, $action_type, $description, $table, $record_id, $old_values, $new_values);
}
?>