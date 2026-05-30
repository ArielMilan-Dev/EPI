<?php
require_once __DIR__ . '/Model.php';

/**
 * Modèle pour la gestion des Étudiants
 * 
 * Pourquoi : Gérer toutes les opérations liées aux étudiants (CRUD : Create, Read, Update, Delete) 
 * ainsi que la recherche et l'authentification des étudiants.
 */
class StudentModel extends Model {

    /**
     * Récupère tous les étudiants.
     * 
     * Pourquoi : Utilisé principalement pour générer la liste du tableau de bord ou pour 
     * l'export Excel.
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM `students` ORDER BY `created_at` DESC");
        return $stmt->fetchAll();
    }

    /**
     * Récupérer un étudiant par ID unique de base de données.
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM `students` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Récupérer un étudiant par son identifiant étudiant (student_id).
     */
    public function getByStudentId($studentId) {
        $stmt = $this->db->prepare("SELECT * FROM `students` WHERE `student_id` = ?");
        $stmt->execute([$studentId]);
        return $stmt->fetch();
    }

    /**
     * Récupérer un étudiant par son email.
     */
    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM `students` WHERE `email` = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Recherche avancée et filtrage.
     * 
     * Comment : Construit dynamiquement la requête SQL en fonction des paramètres 
     * fournis. Utilise `LIKE %...%` pour chercher dans plusieurs colonnes (nom, email, tel) 
     * et `=` pour la classe afin d'avoir un filtrage exact.
     */
    public function search($query, $className = '') {
        $sql = "SELECT * FROM `students` WHERE 1=1";
        $params = [];

        if (!empty($query)) {
            $sql .= " AND (`student_id` LIKE ? OR `first_name` LIKE ? OR `last_name` LIKE ? OR `email` LIKE ? OR `phone` LIKE ?)";
            $searchQuery = "%" . $query . "%";
            $params = array_merge($params, [$searchQuery, $searchQuery, $searchQuery, $searchQuery, $searchQuery]);
        }

        if (!empty($className)) {
            $sql .= " AND `class_name` = ?";
            $params[] = $className;
        }

        $sql .= " ORDER BY `created_at` DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Obtenir la liste distincte de toutes les classes.
     */
    public function getClasses() {
        $stmt = $this->db->query("SELECT DISTINCT `class_name` FROM `students` WHERE `class_name` IS NOT NULL AND `class_name` != '' ORDER BY `class_name` ASC");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Créer un étudiant.
     */
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `email`, `phone`, `birth_date`, `class_name`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['student_id'],
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['birth_date'],
            $data['class_name']
        ]);
    }

    // Mettre à jour un étudiant
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE `students` SET `student_id` = ?, `first_name` = ?, `last_name` = ?, `email` = ?, `phone` = ?, `birth_date` = ?, `class_name` = ? WHERE `id` = ?");
        return $stmt->execute([
            $data['student_id'],
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['birth_date'],
            $data['class_name'],
            $id
        ]);
    }

    // Supprimer un étudiant
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM `students` WHERE `id` = ?");
        return $stmt->execute([$id]);
    }

    // Statistiques pour le tableau de bord
    public function getStatistics() {
        // Nombre total d'étudiants
        $total = $this->db->query("SELECT COUNT(*) FROM `students`")->fetchColumn();
        
        // Nombre de classes distinctes
        $classes = $this->db->query("SELECT COUNT(DISTINCT `class_name`) FROM `students`")->fetchColumn();
        
        // Nouveaux inscrits (30 derniers jours)
        $newEnrollments = $this->db->query("SELECT COUNT(*) FROM `students` WHERE `created_at` >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn();

        return [
            'total_students' => $total,
            'total_classes' => $classes,
            'new_enrollments' => $newEnrollments
        ];
    }

    // ── Authentification Étudiant (Espace Étudiant) ─────────────────────────

    // Authentifier un étudiant par email + mot de passe
    public function authenticateStudent($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM `students` WHERE `email` = ?");
        $stmt->execute([$email]);
        $student = $stmt->fetch();

        if ($student && !empty($student['password']) && password_verify($password, $student['password'])) {
            return $student;
        }
        return false;
    }

    // Créer un étudiant avec mot de passe (inscription via portail)
    public function createWithPassword($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `email`, `phone`, `birth_date`, `class_name`, `password`)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['student_id'],
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['birth_date'],
            $data['class_name'],
            password_hash($data['password'], PASSWORD_DEFAULT),
        ]);
    }
}
