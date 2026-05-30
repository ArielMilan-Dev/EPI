<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../model/StudentModel.php';

class StudentAuthController extends Controller {

    private $studentModel;

    public function __construct() {
        $this->studentModel = new StudentModel();
    }

    // ── Inscription ─────────────────────────────────────────────────────────
    public function register() {
        if (isset($_SESSION['student_id'])) {
            $this->redirect('index.php?action=student_portal');
        }

        $error   = null;
        $old     = [];   // re-fill form on error

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = [
                'first_name' => trim($_POST['first_name'] ?? ''),
                'last_name'  => trim($_POST['last_name']  ?? ''),
                'email'      => trim($_POST['email']      ?? ''),
                'phone'      => trim($_POST['phone']      ?? ''),
                'birth_date' => $_POST['birth_date']      ?? '',
                'class_name' => trim($_POST['class_name'] ?? ''),
            ];
            $password        = $_POST['password']         ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            if (empty($old['first_name']) || empty($old['last_name']) || empty($old['email'])
                || empty($old['birth_date']) || empty($old['class_name']) || empty($password)) {
                $error = "Veuillez remplir tous les champs obligatoires.";

            } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
                $error = "Adresse email invalide.";

            } elseif ($password !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas.";

            } elseif (strlen($password) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères.";

            } elseif ($this->studentModel->getByEmail($old['email'])) {
                $error = "Un compte existe déjà avec cet email.";

            } else {
                // Génération de l'identifiant unique EPI
                $year   = date('Y');
                $suffix = str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
                $studentId = "EPI-{$year}-{$suffix}";

                // S'assurer que l'ID est unique
                while ($this->studentModel->getByStudentId($studentId)) {
                    $suffix    = str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
                    $studentId = "EPI-{$year}-{$suffix}";
                }

                $data = array_merge($old, [
                    'student_id' => $studentId,
                    'password'   => $password,
                ]);

                if ($this->studentModel->createWithPassword($data)) {
                    $student = $this->studentModel->getByEmail($old['email']);
                    $this->setStudentSession($student);
                    $this->redirect('index.php?action=student_portal');
                } else {
                    $error = "Une erreur s'est produite. Veuillez réessayer.";
                }
            }
        }

        $this->render('student/register', [
            'pageTitle' => "Inscription - EPI",
            'error'     => $error,
            'old'       => $old,
        ]);
    }

    // ── Connexion ────────────────────────────────────────────────────────────
    public function login() {
        if (isset($_SESSION['student_id'])) {
            $this->redirect('index.php?action=student_portal');
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email']    ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = "Veuillez remplir tous les champs.";
            } else {
                $student = $this->studentModel->authenticateStudent($email, $password);
                if ($student) {
                    $this->setStudentSession($student);
                    $this->redirect('index.php?action=student_portal');
                } else {
                    $error = "Email ou mot de passe incorrect.";
                }
            }
        }

        $this->render('student/login', [
            'pageTitle' => "Connexion Étudiant - EPI",
            'error'     => $error,
        ]);
    }

    // ── Tableau de bord étudiant ──────────────────────────────────────────────
    public function portal() {
        if (!isset($_SESSION['student_id'])) {
            $this->redirect('index.php?action=student_login');
        }

        $student = $this->studentModel->getById($_SESSION['student_id']);

        if (!$student) {
            // Session invalide
            session_destroy();
            $this->redirect('index.php?action=student_login');
        }

        $this->render('student/portal', [
            'pageTitle' => "Mon Espace - EPI",
            'student'   => $student,
        ]);
    }

    // ── Mise à jour du mot de passe (AJAX) ────────────────────────────────────
    public function ajaxUpdatePassword() {
        if (!isset($_SESSION['student_id'])) {
            $this->json(['success' => false, 'message' => 'Non autorisé.']);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_SESSION['student_id'];
            $oldPassword = $_POST['old_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
                $this->json(['success' => false, 'message' => 'Tous les champs sont obligatoires.']);
                return;
            }

            if ($newPassword !== $confirmPassword) {
                $this->json(['success' => false, 'message' => 'Les nouveaux mots de passe ne correspondent pas.']);
                return;
            }

            if (strlen($newPassword) < 6) {
                $this->json(['success' => false, 'message' => 'Le nouveau mot de passe doit contenir au moins 6 caractères.']);
                return;
            }

            $student = $this->studentModel->getById($id);
            if (!$student || !password_verify($oldPassword, $student['password'])) {
                $this->json(['success' => false, 'message' => 'Ancien mot de passe incorrect.']);
                return;
            }

            if ($this->studentModel->updatePassword($id, $newPassword)) {
                $this->json(['success' => true, 'message' => 'Mot de passe mis à jour avec succès.']);
            } else {
                $this->json(['success' => false, 'message' => 'Erreur lors de la mise à jour.']);
            }
        }
    }

    // ── Déconnexion ───────────────────────────────────────────────────────────
    public function logout() {
        unset(
            $_SESSION['student_id'],
            $_SESSION['student_name'],
            $_SESSION['student_email']
        );
        $this->redirect('index.php?action=home');
    }

    // ── Helpers ───────────────────────────────────────────────────────────────
    private function setStudentSession($student) {
        $_SESSION['student_id']    = $student['id'];
        $_SESSION['student_name']  = $student['first_name'] . ' ' . $student['last_name'];
        $_SESSION['student_email'] = $student['email'];
    }
}
