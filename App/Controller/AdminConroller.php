<?php
namespace App\Controller;

use App\Core\Validation;
use PDO;

class AdminConroller
{
    public function __construct(private PDO $pdo)
    {
        $this->createDoctorsTable();
    }

    public function addMajor(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $errors = [];

            $nameError = Validation::validate_require($name, 'Major name');
            if ($nameError) {
                $errors['name'] = $nameError;
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = [
                    'name' => $name,
                    'description' => $description,
                ];
                header('Location: index.php?page=add-major');
                return;
            }

            $statement = $this->pdo->prepare('INSERT INTO majors (name, description) VALUES (:name, :description)');
            $statement->execute([
                'name' => $name,
                'description' => $description !== '' ? $description : null,
            ]);

            unset($_SESSION['old'], $_SESSION['errors']);
            setmessage('Major added successfully.', 'success');
            header('Location: index.php?page=majors');
            exit();
        }

        require_once __DIR__ . '/../views/admin/add-major.php';
    }

    public function getMajors(): array
    {
        $statement = $this->pdo->query('SELECT id, name, description FROM majors ORDER BY id DESC');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
        private function createDoctorsTable(): void
    {
        $this->pdo->exec(
            'CREATE TABLE IF NOT EXISTS doctors (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                phone VARCHAR(20) NULL,
                major VARCHAR(255) NOT NULL,
                experience TINYINT UNSIGNED NULL,
                bio TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)'
        );
    }
    public function addDoctor(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $phone = trim($_POST['phone'] ?? '');
            $major = trim($_POST['major'] ?? '');
            $experience = trim($_POST['experience'] ?? '');
            $bio = trim($_POST['bio'] ?? '');
            $errors = [];

            // Validate inputs
            $nameError = Validation::validate_require($name, 'Full name');
            if ($nameError) {
                $errors['name'] = $nameError;
            }

            $emailError = Validation::validate_email($email);
            if ($emailError) {
                $errors['email'] = $emailError;
            }

            $passwordError = Validation::validate_password($password);
            if ($passwordError) {
                $errors['password'] = $passwordError;
            }

            $phoneError = Validation::validate_phone($phone);
            if ($phoneError) {
                $errors['phone'] = $phoneError;
            }

            if (empty($major)) {
                $errors['major'] = 'Major is required.';
            }

            $userStatement = $this->pdo->prepare(
                'SELECT id FROM users WHERE email = :email LIMIT 1'
            );
            $userStatement->execute(['email' => $email]);
            if ($userStatement->fetchColumn()) {
                $errors['email'] = 'Email is already registered.';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'major' => $major,
                    'experience' => $experience,
                    'bio' => $bio,
                ];
                header('Location: index.php?page=add-doctor');
                return;
            }
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->pdo->beginTransaction();

            $userInsert = $this->pdo->prepare(
                'INSERT INTO users (name, email, role, password, phone)
                 VALUES (:name, :email, :role, :password, :phone)'
            );
            $userInsert->execute([
                'name' => $name,
                'email' => $email,
                'role' => 'doctor',
                'password' => $hashedPassword,
                'phone' => $phone !== '' ? $phone : null,
            ]);

            $doctorInsert = $this->pdo->prepare(
                'INSERT INTO doctors (name, email, password, phone, major, experience, bio)
                 VALUES (:name, :email, :password, :phone, :major, :experience, :bio)'
            );
            $doctorInsert->execute([
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'phone' => $phone !== '' ? $phone : null,
                'major' => $major,
                'experience' => $experience !== '' ? (int) $experience : null,
                'bio' => $bio !== '' ? $bio : null,
           ]);

           $this->pdo->commit();

           unset($_SESSION['old'], $_SESSION['errors']);
           setmessage('Doctor added successfully.', 'success');
           header('Location: index.php?page=doctors');
           exit();
       }
   }

   public function getDoctors(): array
    {
        $statement = $this->pdo->query('SELECT id, name, major FROM doctors ORDER BY id DESC');
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
   

}