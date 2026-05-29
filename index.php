<?php
// Point d'entrée principal / Front Controller

// Initialisation de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Chargement automatique des configurations (déclenche la création/seeding automatique si besoin)
require_once __DIR__ . '/config/database.php';
try {
    Database::getConnection();
} catch (Exception $e) {
    die("Échec du démarrage de l'application : " . $e->getMessage());
}

// Inclusion des contrôleurs
require_once __DIR__ . '/controller/AuthController.php';
require_once __DIR__ . '/controller/StudentController.php';

// Routage simple basé sur le paramètre 'action'
$action = $_GET['action'] ?? '';

// Si l'utilisateur n'est pas connecté et n'essaie pas de se connecter, on le force vers la page de login
if (!isset($_SESSION['admin_id']) && $action !== 'login' && $action !== 'logout') {
    $action = 'login';
}

// Si connecté et aucune action ou action login, on redirige vers le tableau de bord
if (isset($_SESSION['admin_id']) && (empty($action) || $action === 'login')) {
    $action = 'dashboard';
}

switch ($action) {
    case 'login':
        $authController = new AuthController();
        $authController->login();
        break;

    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;

    case 'dashboard':
        $studentController = new StudentController();
        $studentController->dashboard();
        break;

    case 'ajax_list':
        $studentController = new StudentController();
        $studentController->ajaxList();
        break;

    case 'ajax_add':
        $studentController = new StudentController();
        $studentController->ajaxAdd();
        break;

    case 'ajax_get':
        $studentController = new StudentController();
        $studentController->ajaxGet();
        break;

    case 'ajax_update':
        $studentController = new StudentController();
        $studentController->ajaxUpdate();
        break;

    case 'ajax_delete':
        $studentController = new StudentController();
        $studentController->ajaxDelete();
        break;

    default:
        // Redirection par défaut
        header('Location: index.php?action=dashboard');
        exit;
}
