<?php
// includes/auth.php - Authentication helper functions

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Require user to be logged in, redirect to home with login modal if not
 */
function requireLogin() {
    if (!isLoggedIn()) {
        // Redirect to homepage with flag to open login modal
        header('Location: ' . BASE_URL . 'index.php?login=required');
        exit();
    }
}

/**
 * Login user (demo version - replace with actual database authentication)
 * @param string $email
 * @param string $password
 * @return bool
 */
function login($email, $password) {
    // Demo authentication - replace with actual database check
    // For now, accept any email/password combination
    if (!empty($email) && !empty($password)) {
        // Set session variables
        $_SESSION['user_id'] = 1;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = 'John Doe';
        $_SESSION['user_phone'] = '9876543210';
        $_SESSION['business_name'] = 'Fashion Boutique';
        $_SESSION['business_type'] = 'boutique';
        $_SESSION['member_since'] = 'January 15, 2024';
        
        return true;
    }
    
    return false;
}

/**
 * Register new user (demo version - replace with actual database registration)
 * @param string $name
 * @param string $email
 * @param string $password
 * @param string $phone
 * @return bool
 */
function register($name, $email, $password, $phone = '') {
    // Demo registration - replace with actual database insert
    if (!empty($name) && !empty($email) && !empty($password)) {
        // Set session variables
        $_SESSION['user_id'] = 1;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_phone'] = $phone;
        $_SESSION['business_name'] = '';
        $_SESSION['business_type'] = '';
        $_SESSION['member_since'] = date('F j, Y');
        
        return true;
    }
    
    return false;
}

/**
 * Logout user
 */
function logout() {
    // Unset all session variables
    $_SESSION = array();
    
    // Destroy the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    
    // Destroy the session
    session_destroy();
    
    // Redirect to homepage
    header('Location: ' . BASE_URL . 'index.php');
    exit();
}

/**
 * Get current user data
 * @return array|null
 */
function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'email' => $_SESSION['user_email'] ?? '',
        'name' => $_SESSION['user_name'] ?? '',
        'phone' => $_SESSION['user_phone'] ?? '',
        'business_name' => $_SESSION['business_name'] ?? '',
        'business_type' => $_SESSION['business_type'] ?? '',
        'member_since' => $_SESSION['member_since'] ?? ''
    ];
}
?>
