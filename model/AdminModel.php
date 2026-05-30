<?php
require_once __DIR__ . '/Model.php';

/**
 * Modèle pour la gestion des Administrateurs
 * 
 * Pourquoi : Séparer la logique d'accès aux données (Base de données) de la 
 * logique métier (Contrôleurs). Cela permet de réutiliser le code et de 
 * centraliser les requêtes SQL.
 */
class AdminModel extends Model {
    
    /**
     * Authentifie un administrateur en vérifiant ses identifiants.
     * 
     * Comment : Récupère d'abord l'utilisateur par son 'username', puis 
     * utilise `password_verify()` pour comparer le mot de passe en texte brut 
     * avec le hachage sécurisé enregistré en base de données.
     */
    public function authenticate($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM `admins` WHERE `username` = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }

    /**
     * Récupère un administrateur par son ID.
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM `admins` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Récupère un administrateur par son nom d'utilisateur.
     * Utile pour vérifier si un 'username' est déjà pris avant une mise à jour.
     */
    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM `admins` WHERE `username` = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    /**
     * Met à jour les informations du profil administrateur.
     * 
     * Comment : Gère dynamiquement la mise à jour du mot de passe. Si le champ 
     * $password est fourni, il est haché avant l'insertion. Sinon, on met à jour 
     * uniquement le nom et l'identifiant.
     */
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
