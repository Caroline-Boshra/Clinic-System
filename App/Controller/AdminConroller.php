<?php
namespace App\Controller;

use App\Core\Validation;
use PDO;

class AdminConroller
{
    public function __construct(private PDO $pdo)
    {
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


}
?>