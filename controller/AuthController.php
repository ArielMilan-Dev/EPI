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
