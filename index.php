<?php

use App\Database;
use App\Controller\AuthController;

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
        require __DIR__ . '/views/majors.php';
        break;

    case 'doctors':
        require __DIR__ . '/views/doctors/index.php';
        break;

    case 'doctor':
        require __DIR__ . '/views/doctors/doctor.php';
        break;

    case 'add-doctor':
        require __DIR__ . '/views/admin/add-doctor.php';
        break;

    case 'add-major':
        require __DIR__ . '/views/admin/add-major.php';
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
        require __DIR__ . '/views/home.php';
        break;

        case 'admin-dashboard':
    // Admin Dashboard
    break;

case 'doctor-dashboard':
    // Doctor Dashboard
    break;

    default:
        require __DIR__ . '/views/home.php';
        break;
}
