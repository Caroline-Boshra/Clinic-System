<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
use App\Database;
use App\Controller\AdminConroller;
use App\Controller\AuthController;
use App\Controller\DoctorController;
use App\Controller\ContactController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/App/core/functions.php';

$config = require_once __DIR__ . '/Config/database.php';

$db = Database::getInstance($config);
$pdo = $db->getConnection();

$page = strtolower((string) ($_GET['page'] ?? 'home'));

switch ($page) {
    case 'contact':
        require __DIR__ . '/views/contact.php';
        break;

    case 'history':
        require __DIR__ . '/views/history.php';
        break;

    case 'majors':
        $majors = (new AdminConroller($pdo))->getMajors();
        require __DIR__ . '/views/majors.php';
        break;

    case 'doctors':
        $doctors = (new AdminConroller($pdo))->getDoctors();
        require __DIR__ . '/views/doctors/index.php';
        break;

    case 'doctor':
        if (empty($_SESSION['user'])) {
            setmessage('Please login first', 'danger');
            header('Location: index.php?page=login');
            exit;
        }

        require __DIR__ . '/views/doctors/doctor.php';
        break;

    case 'add-doctor':
        $majors = (new AdminConroller($pdo))->getMajors();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AdminConroller($pdo))->addDoctor();
            exit;
        }
        require __DIR__ . '/views/admin/add-doctor.php';
        break;

    case 'add-major':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AdminConroller($pdo))->addMajor();
            exit;
        }
        require __DIR__ . '/views/admin/add-major.php';
        break;
    case 'all_messages':
        (new AdminConroller($pdo))->all_messages();
       
    break;
  

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AuthController())->login($pdo);
            exit;
        }

        require __DIR__ . '/views/Auth/login.php';
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new AuthController())->register($pdo);
            exit;
        }
       
        require __DIR__ . '/views/Auth/register.php';
        break;

    case 'logout':
        (new AuthController())->logout();
        exit;

    case 'home':
        $adminController = new AdminConroller($pdo);
        $majors = $adminController->getMajors();
        $doctors = $adminController->getDoctors();
        require __DIR__ . '/views/home.php';
        break;

        case 'admin-dashboard':
    // Admin Dashboard
    break;

    case 'doctor-dashboard':
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'doctor') {
            setmessage('You must be logged in as a doctor.', 'danger');
            header('Location: index.php?page=login');
            exit;
        }
        
        require __DIR__ . '/views/doctors/doctor-dashboard.php';
    break;
 // Doctor Dashboard
    case 'create_shift':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            (new DoctorController())->createShift($pdo);
            exit;
        }
        
        require __DIR__ . '/views/doctor-dashboard/create_shift.php';
    break; 

    case 'shifts':
       (new DoctorController())->listShifts($pdo);

    break;

    case 'edit_shift':
        (new DoctorController())->editShift($pdo);
    break;

    case 'delete_shift':
       (new DoctorController())->deleteShift($pdo);
       
    break;
    case 'doctor_pricing':
        (new DoctorController())->doctorPricing($pdo);
    break;
    case 'bookings':
        (new DoctorController())->listBookings($pdo);
    break;
    /////contact form ///
    case 'contact_us':
        (new ContactController())->contactUs($pdo);
        header('Location: index.php?page=contact');
    exit;
    default:
        require __DIR__ . '/views/home.php';
        break;
}
