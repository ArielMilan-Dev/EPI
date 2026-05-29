<?php
require_once __DIR__ . '/Model.php';

class AdminModel extends Model {
    
    // Authentifier un administrateur
    public function authenticate($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM `admins` WHERE `username` = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }

    // Récupérer un administrateur par son ID
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM `admins` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
