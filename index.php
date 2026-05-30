<?php
/**
 * Point d'entrée principal de l'application (Front Controller)
 * 
 * Pourquoi : En utilisant un point d'entrée unique (index.php), on centralise
 * la logique de routage. Cela permet d'appliquer des configurations globales
 * (comme la gestion des sessions ou la connexion à la base de données) à un
 * seul endroit avant de distribuer la requête au bon contrôleur.
 * 
 * Comment : Toutes les requêtes passent par ici, et le paramètre '?action=...' 
 * définit la page à charger.
 */

// ── Configuration Production ──
// Désactive l'affichage direct des erreurs pour éviter de fuiter des informations sensibles.
error_reporting(0);
ini_set('display_errors', 0);

// Initialisation de la session
// Nécessaire pour conserver l'état de connexion de l'utilisateur (étudiant ou admin) entre les pages.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Chargement automatique des configurations (déclenche la création/seeding automatique si besoin)
// On s'assure que la base de données est prête avant même de charger les contrôleurs.
require_once __DIR__ . '/config/database.php';
try {
    Database::getConnection();
} catch (Exception $e) {
    die("Échec du démarrage de l'application : " . $e->getMessage());
}

// Inclusion des contrôleurs (Ils contiennent la logique métier pour chaque section)
require_once __DIR__ . '/controller/AuthController.php';         // Connexion Admin
require_once __DIR__ . '/controller/StudentController.php';      // Gestion des étudiants (CRUD Admin)
require_once __DIR__ . '/controller/StudentAuthController.php';  // Connexion & Portail Étudiant
require_once __DIR__ . '/controller/PublicController.php';       // Pages vitrines (Accueil, Contact...)

// Routage basé sur le paramètre 'action' (par défaut on charge 'home')
$action = $_GET['action'] ?? 'home';

// ─── Pages publiques (accessibles sans authentification) ─────────────────────
$publicRoutes = ['home', 'formations', 'contact'];

// ─── Pages espace étudiant ────────────────────────────────────────────────────
$studentRoutes = ['student_login', 'student_register', 'student_portal', 'student_logout', 'ajax_update_student_pwd'];

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
        case 'ajax_update_student_pwd': $studentAuth->ajaxUpdatePassword(); break;
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
