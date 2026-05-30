<?php
require_once __DIR__ . '/Controller.php';

class PublicController extends Controller {

    // Page d'accueil publique
    public function home() {
        $pageTitle = "EPI - École Polytechnique Internationale";
        $this->render('public/home', ['pageTitle' => $pageTitle]);
    }

    // Page des formations
    public function formations() {
        $pageTitle = "Formations - EPI";
        $this->render('public/formations', ['pageTitle' => $pageTitle]);
    }

    // Page de contact
    public function contact() {
        $pageTitle = "Contact - EPI";
        $error   = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name    = trim($_POST['name']    ?? '');
            $email   = trim($_POST['email']   ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if (empty($name) || empty($email) || empty($subject) || empty($message)) {
                $error = "Veuillez remplir tous les champs.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Adresse email invalide.";
            } else {
                // Dans un vrai projet, on enverrait un email ici
                $success = "Merci {$name} ! Votre message a été envoyé. Nous vous répondrons dans les plus brefs délais.";
            }
        }

        $this->render('public/contact', [
            'pageTitle' => $pageTitle,
            'error'     => $error,
            'success'   => $success,
        ]);
    }
}
