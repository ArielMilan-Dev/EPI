<?php
// Point d'entrée principal / Front Controller

// ── Configuration Production ──
error_reporting(0);
ini_set('display_errors', 0);

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
require_once __DIR__ . '/controller/StudentAuthController.php';
require_once __DIR__ . '/controller/PublicController.php';

// Routage basé sur le paramètre 'action'
$action = $_GET['action'] ?? 'home';

// ─── Pages publiques (accessibles sans authentification) ─────────────────────
$publicRoutes = ['home', 'formations', 'contact'];

// ─── Pages espace étudiant ────────────────────────────────────────────────────
$studentRoutes = ['student_login', 'student_register', 'student_portal', 'student_logout'];

// ─── Pages admin ──────────────────────────────────────────────────────────────
$adminRoutes = ['login', 'logout', 'dashboard', 'ajax_list', 'ajax_add', 'ajax_get', 'ajax_update', 'ajax_delete', 'download_sheet', 'ajax_update_admin'];

// ─── Routage ──────────────────────────────────────────────────────────────────

// Pages publiques
if (in_array($action, $publicRoutes)) {
    $publicController = new PublicController();
    switch ($action) {
        case 'home':       $publicController->home();       break;
        case 'formations': $publicController->formations(); break;
        case 'contact':    $publicController->contact();    break;
    }
    exit;
}

// Pages espace étudiant
if (in_array($action, $studentRoutes)) {
    $studentAuth = new StudentAuthController();
    switch ($action) {
        case 'student_login':    $studentAuth->login();    break;
        case 'student_register': $studentAuth->register(); break;
        case 'student_portal':   $studentAuth->portal();   break;
        case 'student_logout':   $studentAuth->logout();   break;
    }
    exit;
}

// Pages admin
if (in_array($action, $adminRoutes)) {

    // Si l'utilisateur n'est pas connecté en admin et n'essaie pas de se connecter
    if (!isset($_SESSION['admin_id']) && $action !== 'login' && $action !== 'logout') {
        header('Location: index.php?action=login');
        exit;
    }

    // Si déjà connecté en admin et tente d'accéder au login → rediriger vers dashboard
    if (isset($_SESSION['admin_id']) && $action === 'login') {
        header('Location: index.php?action=dashboard');
        exit;
    }

    $authController    = new AuthController();
    $studentController = new StudentController();

    switch ($action) {
        case 'login':           $authController->login();       break;
        case 'logout':          $authController->logout();      break;
        case 'dashboard':       $studentController->dashboard(); break;
        case 'ajax_list':       $studentController->ajaxList();  break;
        case 'ajax_add':        $studentController->ajaxAdd();   break;
        case 'ajax_get':        $studentController->ajaxGet();   break;
        case 'ajax_update':     $studentController->ajaxUpdate(); break;
        case 'ajax_delete':     $studentController->ajaxDelete(); break;
        case 'download_sheet':  $studentController->downloadSheet(); break;
        case 'ajax_update_admin': $authController->ajaxUpdateAdmin(); break;
    }
    exit;
}

// ─── Fallback : page d'accueil ────────────────────────────────────────────────
header('Location: index.php?action=home');
exit;
