<?php
// public/index.php - Front controller
require_once __DIR__ . '/../config/database.php'; // load DB config (for any global use)

// Simple autoloader for controllers
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../app/Controllers/' . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

$route = $_GET['route'] ?? 'home';
switch ($route) {
    case 'dashboard':
        (new DashboardController())->showDashboard();
        break;
    case 'booking':
        (new BookingController())->listBookings();
        break;
    case 'booking_form':
        (new BookingController())->showForm();
        break;
    case 'login':
        (new AuthController())->showLogin();
        break;
    case 'register':
        (new AuthController())->showRegister();
        break;
    case 'layanan':
        (new LayananController())->listLayanan();
        break;
    case 'home':
        (new HomeController())->showHome();
        break;
    case 'logout':
        // Destroy session and redirect to login page
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: index.php?route=login');
        exit;
    case 'login_process':
        (new AuthController())->processLogin();
        break;
    case 'register_process':
        (new AuthController())->processRegister();
        break;
    case 'booking_process':
        (new BookingController())->processBooking();
        break;
    default:
        // fallback to home page (could be redirected to dashboard or public home)
        header('Location: index.php?route=dashboard');
        break;
}
?>
