<?php

class RoleManager {
    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';
    
    const PERMISSION_VIEW_DASHBOARD = 'view_dashboard';
    const PERMISSION_MANAGE_USERS = 'manage_users';
    const PERMISSION_MANAGE_ADMINS = 'manage_admins';
    const PERMISSION_MANAGE_MODERATORS = 'manage_moderators';
    const PERMISSION_MANAGE_PRODUCTS = 'manage_products';
    const PERMISSION_MANAGE_ORDERS = 'manage_orders';
    const PERMISSION_MANAGE_CUSTOMERS = 'manage_customers';
    const PERMISSION_MANAGE_CATEGORIES = 'manage_categories';
    const PERMISSION_MANAGE_COUPONS = 'manage_coupons';
    const PERMISSION_MANAGE_INVENTORY = 'manage_inventory';
    const PERMISSION_MANAGE_REVIEWS = 'manage_reviews';
    const PERMISSION_MANAGE_RIDERS = 'manage_riders';
    const PERMISSION_MANAGE_DELIVERIES = 'manage_deliveries';
    const PERMISSION_VIEW_REPORTS = 'view_reports';
    const PERMISSION_MANAGE_SETTINGS = 'manage_settings';
    const PERMISSION_VIEW_ACTIVITY_LOGS = 'view_activity_logs';
    
    private static $rolePermissions = [
        self::ROLE_SUPER_ADMIN => [
            self::PERMISSION_VIEW_DASHBOARD,
            self::PERMISSION_MANAGE_USERS,
            self::PERMISSION_MANAGE_ADMINS,
            self::PERMISSION_MANAGE_MODERATORS,
            self::PERMISSION_MANAGE_PRODUCTS,
            self::PERMISSION_MANAGE_ORDERS,
            self::PERMISSION_MANAGE_CUSTOMERS,
            self::PERMISSION_MANAGE_CATEGORIES,
            self::PERMISSION_MANAGE_COUPONS,
            self::PERMISSION_MANAGE_INVENTORY,
            self::PERMISSION_MANAGE_REVIEWS,
            self::PERMISSION_MANAGE_RIDERS,
            self::PERMISSION_MANAGE_DELIVERIES,
            self::PERMISSION_VIEW_REPORTS,
            self::PERMISSION_MANAGE_SETTINGS,
            self::PERMISSION_VIEW_ACTIVITY_LOGS,
        ],
        self::ROLE_ADMIN => [
            self::PERMISSION_VIEW_DASHBOARD,
            self::PERMISSION_MANAGE_MODERATORS,
            self::PERMISSION_MANAGE_PRODUCTS,
            self::PERMISSION_MANAGE_ORDERS,
            self::PERMISSION_MANAGE_CUSTOMERS,
            self::PERMISSION_MANAGE_CATEGORIES,
            self::PERMISSION_MANAGE_COUPONS,
            self::PERMISSION_MANAGE_INVENTORY,
            self::PERMISSION_MANAGE_REVIEWS,
            self::PERMISSION_MANAGE_RIDERS,
            self::PERMISSION_MANAGE_DELIVERIES,
            self::PERMISSION_VIEW_REPORTS,
            self::PERMISSION_VIEW_ACTIVITY_LOGS,
        ],
        self::ROLE_MODERATOR => [
            self::PERMISSION_VIEW_DASHBOARD,
            self::PERMISSION_MANAGE_ORDERS,
            self::PERMISSION_MANAGE_CUSTOMERS,
            self::PERMISSION_MANAGE_REVIEWS,
            self::PERMISSION_VIEW_ACTIVITY_LOGS,
        ],
    ];
    
    public static function hasPermission($role, $permission) {
        if (!isset(self::$rolePermissions[$role])) {
            return false;
        }
        return in_array($permission, self::$rolePermissions[$role]);
    }
    
    public static function getPermissions($role) {
        return self::$rolePermissions[$role] ?? [];
    }
    
    public static function canCreateRole($currentRole, $targetRole) {
        if ($currentRole === self::ROLE_SUPER_ADMIN) {
            return in_array($targetRole, [self::ROLE_ADMIN, self::ROLE_MODERATOR]);
        }
        if ($currentRole === self::ROLE_ADMIN) {
            return $targetRole === self::ROLE_MODERATOR;
        }
        return false;
    }
    
    public static function getRoleDisplayName($role) {
        $names = [
            self::ROLE_SUPER_ADMIN => 'Super Admin',
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_MODERATOR => 'Moderator',
        ];
        return $names[$role] ?? 'Unknown';
    }
    
    public static function getRoleColor($role) {
        $colors = [
            self::ROLE_SUPER_ADMIN => '#667eea',
            self::ROLE_ADMIN => '#3498db',
            self::ROLE_MODERATOR => '#27ae60',
        ];
        return $colors[$role] ?? '#7f8c8d';
    }
}
?>
