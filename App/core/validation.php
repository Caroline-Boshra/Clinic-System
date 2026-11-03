<?php
namespace App\Core;

use App\Enums\RoleEnum;

class Validation
{
    public static function validate_require($data, $field_name)
    {
        if (empty($data)) {
            return "$field_name is required.";
        }

        return "";
    }

    public static function validate_email($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        }

        return "";
    }

    public static function validate_phone($phone)
    {
        if (!empty($phone) && !preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
            return "Invalid phone number format.";
        }

        return "";
    }

    public static function validate_password($password)
    {
        if (strlen($password) < 6) {
            return "Password must be at least 6 characters long.";
        }

        return "";
    }

    public static function validate_passwordmatch($password, $confirm_password)
    {
        if ($password !== $confirm_password) {
            return "Passwords do not match.";
        }

        return "";
    }

    public static function add_error(&$errors, $error)
    {
        if ($error) {
            $errors[] = $error;
        }
    }

    public static function validate_register_data($name, $email, $password, $confirm_password, $phone = null, $role = null)
    {
        $errors = [];

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'confirm_password' => $confirm_password
        ];

        foreach ($data as $field => $value) {
            if (empty($value)) {
                $errors[$field] = ucfirst(str_replace('_', ' ', $field)) . " is required.";
            }
        }

        if (!empty($phone)) {
            $error = self::validate_phone($phone);
            if ($error) {
                $errors['phone'] = $error;
            }
        }

        if (!empty($email)) {
            $error = self::validate_email($email);
            if ($error) {
                $errors['email'] = $error;
            }
        }

        if (!empty($password)) {
            $error = self::validate_password($password);
            if ($error) {
                $errors['password'] = $error;
            }
        }

        if (!empty($confirm_password) && !empty($password)) {
            $error = self::validate_passwordmatch($password, $confirm_password);
            if ($error) {
                $errors['confirm_password'] = $error;
            }
        }

        if (!empty($role)) {
            $roleErrors = self::validate_role($role);
            if (!empty($roleErrors['role'])) {
                $errors['role'] = $roleErrors['role'];
            }
        }

        return $errors;
    }

    public static function validate_registration_data($name, $email, $role, $password, $confirm_password, $phone = null)
    {
        return self::validate_register_data($name, $email, $password, $confirm_password, $phone, $role);
    }

    public static function validate_login_data($email, $password)
    {
        $errors = [];

        $data = [
            'email' => $email,
            'password' => $password,
        ];

        foreach ($data as $field => $value) {
            if (empty($value)) {
                $errors[$field] = ucfirst($field) . " is required.";
            }
        }

        if (!empty($email)) {
            $error = self::validate_email($email);
            if ($error) {
                $errors['email'] = $error;
            }
        }

        return $errors;
    }

    public static function validate_role($role)
    {
        $errors = [];
        $roles = RoleEnum::getRoles();
        if (!in_array($role, $roles)) {
            $errors['role'] = "Invalid role selected.";
        }
        return $errors;
    }
}
