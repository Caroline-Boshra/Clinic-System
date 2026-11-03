<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';

    public static function getRoles(): array
    {
        return [
            self::ADMIN->value,
            self::DOCTOR->value,
            self::PATIENT->value,
        ];
    }
    
}