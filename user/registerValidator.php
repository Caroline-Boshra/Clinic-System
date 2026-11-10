<?php
namespace Clinic;

// Holds the validation rules that were inline in register.php
class RegistrationValidator
{
    public function __construct(private UserFunctions $users) {}

    /** @return string[] list of error messages (empty = valid) */
    public function validate(array $in): array
    {
        $errors = [];

        if ($in['first_name'] === '' || $in['last_name'] === '') {
            $errors[] = 'First and last name are required.';
        }
        if ($in['email'] === '' || !filter_var($in['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Enter a valid email.';
        }
        if ($in['phone'] === '') {
            $errors[] = 'Phone is required.';
        }
        if (strlen($in['password']) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }
        if ($in['password'] !== $in['confirm']) {
            $errors[] = 'Passwords do not match.';
        }
        if (!$errors && $this->users->exists($in['email'], $in['phone'])) {
            $errors[] = 'Email or phone already registered.';
        }
        return $errors;
    }
}