<?php

namespace App\Controller;
use App\Core\Validation;

class ContactController {

    public function contactUs($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $subject = trim($_POST['subject'] ?? '');
            $message = trim($_POST['message'] ?? '');

            $errors = [];
            if ($error = Validation::validate_require($name, "Name")) {
                $errors['name'] = $error;
            }
            if ($error = Validation::validate_require($phone, "Phone")) {
                $errors['phone'] = $error;
            }
            if ($error = Validation::validate_require($email, "Email")) {
                $errors['email'] = $error;
            }
            // if ($error = Validation::validate_require($subject, "Subject")) {
            //     $errors['subject'] = $error;
            // }
            if ($error = Validation::validate_require($message, "Message")) {
                $errors['message'] = $error;
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?page=contact_us');
                exit;
            }
            $stmt = $pdo->prepare("INSERT INTO contact_us (name, phone, email, subject, message) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$name, $phone, $email, $subject, $message]);
            if($stmt->rowCount() > 0) {
                setmessage('Your message has been sent successfully.', 'success');
            } else {
                setmessage('Failed to send your message. Please try again ', 'danger');
                $_SESSION['old'] = $_POST;

            }
        }
    }
}
             

        