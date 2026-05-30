<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/StudentModel.php';

class StudentController extends Controller {
    private $studentModel;

    public function __construct() {
        $this->studentModel = new StudentModel();
    }

    // Protection des routes
    private function checkAuth() {
        if (!isset($_SESSION['admin_id'])) {
            if ($this->isAjaxRequest()) {
                $this->json(['success' => false, 'message' => 'Session expirée. Veuillez vous reconnecter.']);
            }
            $this->redirect('index.php?action=login');
        }
    }

    // Détecter les requêtes AJAX
    private function isAjaxRequest() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || (isset($_GET['ajax']) && $_GET['ajax'] == '1');
    }

    // Tableau de bord principal
    public function dashboard() {
        $this->checkAuth();

        $stats = $this->studentModel->getStatistics();
        $classes = $this->studentModel->getClasses();

        $this->render('dashboard', [
            'stats' => $stats,
            'classes' => $classes,
            'admin_name' => $_SESSION['admin_name']
        ]);
    }

    // Liste des étudiants (AJAX)
    public function ajaxList() {
        $this->checkAuth();

        $query = trim($_GET['search'] ?? '');
        $classFilter = trim($_GET['class_name'] ?? '');

        $students = $this->studentModel->search($query, $classFilter);
        $stats = $this->studentModel->getStatistics();
        $classes = $this->studentModel->getClasses();

        $this->json([
            'success' => true,
            'students' => $students,
            'stats' => $stats,
            'classes' => $classes
        ]);
    }

    // Ajouter un étudiant (AJAX)
    public function ajaxAdd() {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Méthode non autorisée.']);
        }

        // Nettoyage et validation des données
        $student_id = trim($_POST['student_id'] ?? '');
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $birth_date = trim($_POST['birth_date'] ?? '');
        $class_name = trim($_POST['class_name'] ?? '');

        // Validation des champs requis
        if (empty($student_id) || empty($first_name) || empty($last_name) || empty($email) || empty($birth_date) || empty($class_name)) {
            $this->json(['success' => false, 'message' => 'Veuillez remplir tous les champs obligatoires.']);
        }

        // Validation email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json(['success' => false, 'message' => 'Adresse email invalide.']);
        }

        // Vérification de l'unicité de l'identifiant étudiant
        if ($this->studentModel->getByStudentId($student_id)) {
            $this->json(['success' => false, 'message' => "L'identifiant étudiant '$student_id' existe déjà."]);
        }

        // Vérification de l'unicité de l'email
        if ($this->studentModel->getByEmail($email)) {
            $this->json(['success' => false, 'message' => "L'adresse email '$email' est déjà utilisée."]);
        }

        $data = [
            'student_id' => $student_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'birth_date' => $birth_date,
            'class_name' => $class_name,
            'password' => $student_id // Mot de passe par défaut = ID étudiant
        ];

        if ($this->studentModel->createWithPassword($data)) {
            $this->json(['success' => true, 'message' => 'Étudiant enregistré avec succès. (Mot de passe par défaut : '.$student_id.')']);
        } else {
            $this->json(['success' => false, 'message' => "Une erreur s'est produite lors de l'enregistrement."]);
        }
    }

    // Récupérer un étudiant spécifique pour modification (AJAX)
    public function ajaxGet() {
        $this->checkAuth();

        $id = intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            $this->json(['success' => false, 'message' => 'Identifiant de base de données invalide.']);
        }

        $student = $this->studentModel->getById($id);
        if ($student) {
            $this->json(['success' => true, 'student' => $student]);
        } else {
            $this->json(['success' => false, 'message' => 'Étudiant introuvable.']);
        }
    }

    // Modifier un étudiant (AJAX)
    public function ajaxUpdate() {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Méthode non autorisée.']);
        }

        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            $this->json(['success' => false, 'message' => 'Identifiant invalide.']);
        }

        // Vérifier si l'étudiant existe
        $existingStudent = $this->studentModel->getById($id);
        if (!$existingStudent) {
            $this->json(['success' => false, 'message' => 'Étudiant introuvable.']);
        }

        $student_id = trim($_POST['student_id'] ?? '');
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $birth_date = trim($_POST['birth_date'] ?? '');
        $class_name = trim($_POST['class_name'] ?? '');

        if (empty($student_id) || empty($first_name) || empty($last_name) || empty($email) || empty($birth_date) || empty($class_name)) {
            $this->json(['success' => false, 'message' => 'Veuillez remplir tous les champs obligatoires.']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json(['success' => false, 'message' => 'Adresse email invalide.']);
        }

        // Vérifier si le nouvel ID étudiant appartient à un autre étudiant
        $checkId = $this->studentModel->getByStudentId($student_id);
        if ($checkId && intval($checkId['id']) !== $id) {
            $this->json(['success' => false, 'message' => "L'identifiant étudiant '$student_id' est déjà attribué à un autre étudiant."]);
        }

        // Vérifier si le nouvel email appartient à un autre étudiant
        $checkEmail = $this->studentModel->getByEmail($email);
        if ($checkEmail && intval($checkEmail['id']) !== $id) {
            $this->json(['success' => false, 'message' => "L'adresse email '$email' est déjà attribuée à un autre étudiant."]);
        }

        $data = [
            'student_id' => $student_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'birth_date' => $birth_date,
            'class_name' => $class_name
        ];

        if ($this->studentModel->update($id, $data)) {
            $this->json(['success' => true, 'message' => 'Étudiant mis à jour avec succès.']);
        } else {
            $this->json(['success' => false, 'message' => "Une erreur s'est produite lors de la mise à jour."]);
        }
    }

    // Supprimer un étudiant (AJAX)
    public function ajaxDelete() {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Méthode non autorisée.']);
        }

        $id = intval($_POST['id'] ?? 0);
        if ($id <= 0) {
            $this->json(['success' => false, 'message' => 'Identifiant invalide.']);
        }

        $existingStudent = $this->studentModel->getById($id);
        if (!$existingStudent) {
            $this->json(['success' => false, 'message' => 'Étudiant introuvable.']);
        }

        if ($this->studentModel->delete($id)) {
            $this->json(['success' => true, 'message' => 'Étudiant supprimé avec succès.']);
        } else {
            $this->json(['success' => false, 'message' => "Une erreur s'est produite lors de la suppression."]);
        }
    }

    // Afficher et imprimer la fiche étudiant
    public function downloadSheet() {
        $this->checkAuth();

        $id = intval($_GET['id'] ?? 0);
        if ($id <= 0) {
            die('Identifiant invalide.');
        }

        $student = $this->studentModel->getById($id);
        if (!$student) {
            die('Étudiant introuvable.');
        }

        // On inclut directement la vue pour la fiche étudiant
        require_once __DIR__ . '/../view/student_sheet.php';
    }
}
