<?php
// Contrôleur de base
abstract class Controller {
    
    // Rendre une vue
    protected function render($view, $data = []) {
        extract($data);
        $viewFile = __DIR__ . '/../view/' . $view . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("La vue '$view' n'existe pas.");
        }
    }

    // Retourner une réponse JSON
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // Redirection
    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
}
