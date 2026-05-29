<?php
// Classe Database de configuration (Automatique et résiliente)
class Database {
    private static $host = 'localhost';
    private static $user = 'root';
    private static $pass = '';
    private static $dbname = 'epi_student_db';
    private static $pdo = null;

    public static function getConnection() {
        if (self::$pdo === null) {
            try {
                // Étape 1 : Connexion initiale au serveur MySQL (sans base pour pouvoir la créer)
                $dsn = "mysql:host=" . self::$host . ";charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                
                $tempPdo = new PDO($dsn, self::$user, self::$pass, $options);
                
                // Étape 2 : Création de la base de données si elle n'existe pas
                $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `" . self::$dbname . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                $tempPdo = null; // Libère la connexion temporaire

                // Étape 3 : Connexion à la base de données spécifique
                $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8mb4";
                self::$pdo = new PDO($dsn, self::$user, self::$pass, $options);

                // Étape 4 : Initialisation des tables si elles n'existent pas
                self::setupTables();

            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$pdo;
    }

    private static function setupTables() {
        // Table des Administrateurs
        self::$pdo->exec("CREATE TABLE IF NOT EXISTS `admins` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `username` VARCHAR(50) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `name` VARCHAR(100) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;");

        // Table des Étudiants
        self::$pdo->exec("CREATE TABLE IF NOT EXISTS `students` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `student_id` VARCHAR(50) NOT NULL UNIQUE,
            `first_name` VARCHAR(100) NOT NULL,
            `last_name` VARCHAR(100) NOT NULL,
            `email` VARCHAR(100) NOT NULL UNIQUE,
            `phone` VARCHAR(20) DEFAULT NULL,
            `birth_date` DATE NOT NULL,
            `class_name` VARCHAR(50) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB;");

        // Étape 5 : Seeding (Données initiales)
        // Vérifier s'il y a des administrateurs, sinon insérer l'admin par défaut
        $stmt = self::$pdo->query("SELECT COUNT(*) FROM `admins`");
        if ($stmt->fetchColumn() == 0) {
            $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $insertAdmin = self::$pdo->prepare("INSERT INTO `admins` (`username`, `password`, `name`) VALUES (?, ?, ?)");
            $insertAdmin->execute(['admin', $defaultPassword, 'Administrateur Principal']);
        }

        // Vérifier s'il y a des étudiants, sinon insérer des données de test
        $stmt = self::$pdo->query("SELECT COUNT(*) FROM `students`");
        if ($stmt->fetchColumn() == 0) {
            $studentsData = [
                ['EPI-2026-0001', 'Amine', 'Ben Slimane', 'amine.benslimane@epi.tn', '55112233', '2003-05-15', 'Génie Logiciel 3A'],
                ['EPI-2026-0002', 'Sarah', 'Khemiri', 'sarah.khemiri@epi.tn', '98765432', '2004-09-22', 'Data Science 3B'],
                ['EPI-2026-0003', 'Yassine', 'Masmoudi', 'yassine.masmoudi@epi.tn', '22446688', '2002-12-10', 'Cybersécurité 4A'],
                ['EPI-2026-0004', 'Rania', 'Jlassi', 'rania.jlassi@epi.tn', '50607080', '2003-02-28', 'Génie Logiciel 3A'],
                ['EPI-2026-0005', 'Mohamed', 'Trabelsi', 'mohamed.trabelsi@epi.tn', '99119911', '2004-07-04', 'Réseaux & Télécoms 3A']
            ];

            $insertStudent = self::$pdo->prepare("INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `email`, `phone`, `birth_date`, `class_name`) VALUES (?, ?, ?, ?, ?, ?, ?)");
            foreach ($studentsData as $student) {
                $insertStudent->execute($student);
            }
        }
    }
}
