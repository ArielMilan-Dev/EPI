<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/AdminModel.php';

class AuthController extends Controller {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

    // Afficher le formulaire de connexion ou traiter la connexion
    public function login() {
        // Si déjà connecté, rediriger vers le tableau de bord
        if (isset($_SESSION['admin_id'])) {
            $this->redirect('index.php?action=dashboard');
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $error = "Veuillez remplir tous les champs.";
            } else {
                $admin = $this->adminModel->authenticate($username, $password);
                if ($admin) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_name'] = $admin['name'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $this->redirect('index.php?action=dashboard');
                } else {
                    $error = "Identifiants incorrects.";
                }
            }
        }

        $this->render('auth/login', ['error' => $error]);
    }

    // Mise à jour du profil administrateur via AJAX
    public function ajaxUpdateAdmin() {
        if (!isset($_SESSION['admin_id'])) {
            $this->json(['success' => false, 'message' => 'Non autorisé.']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['admin_id'];
            $username = trim($_POST['username'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($name)) {
                $this->json(['success' => false, 'message' => 'Le nom et l\'identifiant sont obligatoires.']);
                return;
            }

            // Vérifier que le nouveau username n'est pas déjà pris par un autre admin
            $existing = $this->adminModel->getByUsername($username);
            if ($existing && $existing['id'] != $id) {
                $this->json(['success' => false, 'message' => 'Cet identifiant est déjà utilisé.']);
                return;
            }

            if ($this->adminModel->updateCredentials($id, $username, $name, $password ?: null)) {
                // Mettre à jour la session
                $_SESSION['admin_name'] = $name;
                $_SESSION['admin_username'] = $username;
                
                $this->json(['success' => true, 'message' => 'Profil mis à jour avec succès.']);
            } else {
                $this->json(['success' => false, 'message' => 'Erreur lors de la mise à jour.']);
            }
        }
    }

    // Déconnexion
    public function logout() {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        $this->redirect('index.php?action=login');
    }
}
