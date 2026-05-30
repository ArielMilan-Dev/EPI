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

    // Récupérer un administrateur par son nom d'utilisateur
    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM `admins` WHERE `username` = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    // Mettre à jour les informations de l'administrateur
    public function updateCredentials($id, $username, $name, $password = null) {
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE `admins` SET `username` = ?, `name` = ?, `password` = ? WHERE `id` = ?");
            return $stmt->execute([$username, $name, $hashedPassword, $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE `admins` SET `username` = ?, `name` = ? WHERE `id` = ?");
            return $stmt->execute([$username, $name, $id]);
        }
    }
}
