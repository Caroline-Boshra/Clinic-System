<?php
namespace Clinic;

require_once __DIR__ . '/config/db.php';

class User 
{
    public const ROLE_PATIENT = 'patient';
    public const ROLE_DOCTOR  = 'doctor';
    public const ROLE_ADMIN   = 'admin';
    public const ROLES = [self::ROLE_PATIENT, self::ROLE_DOCTOR, self::ROLE_ADMIN];

    public function __construct(
        private ?int $id,
        private string $firstName,
        private string $lastName,
        private string $email,
        private string $phone,
        private string $password,
        private string $role = self::ROLE_PATIENT,
        private ?string $birthDate = null,
        private ?string $createdAt = null,
    ) {
        $this->setRole($role);
    }

   
    public static function register(
         string $firstName,
         string $lastName,
         string $email,
         string $phone,
         string $password,
         ?string $birthDate = null
    ): self {  // create object
        return new self(null, $firstName, $lastName, $email, $phone,
            self::hash($password), self::ROLE_PATIENT, $birthDate);
    }

   // ne7ol el table l object
    public static function fromRow(array $r): self
    {
        return new self(
            (int)$r['id'], $r['first_name'], $r['last_name'], $r['email'], $r['phone'],
            $r['password'], $r['role'], $r['birth_date'] ?? null, $r['created_at'] ?? null
        );
    }

    public static function hash(string $plain): string
    {
        return password_hash($plain, PASSWORD_DEFAULT);
    }

    //Getters
    public function getId(): ?int          { return $this->id; }
    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string  { return $this->lastName; }
    public function getEmail(): string     { return $this->email; }
    public function getPhone(): string     { return $this->phone; }
    public function getRole(): string      { return $this->role; }
    public function getBirthDate(): ?string { return $this->birthDate; }
    public function getCreatedAt(): ?string { return $this->createdAt; }
    public function getPassword(): string { return $this->password; }

    public function fullName(): string { return $this->firstName . ' ' . $this->lastName; }
    public function isAdmin(): bool    { return $this->role === self::ROLE_ADMIN; }
    public function isDoctor(): bool   { return $this->role === self::ROLE_DOCTOR; }
    public function isPatient(): bool  { return $this->role === self::ROLE_PATIENT; }

    //Setters
    public function setId(int $id): self { $this->id = $id; return $this; }
    public function setFirstName(string $v): self { $this->firstName = $v; return $this; }
    public function setLastName(string $v): self  { $this->lastName = $v; return $this; }
    public function setEmail(string $v): self     { $this->email = $v; return $this; }
    public function setPhone(string $v): self     { $this->phone = $v; return $this; }
    public function setBirthDate(?string $v): self { $this->birthDate = ($v === '' ? null : $v); return $this; }

    public function setRole(string $role): self
    {
        if (!in_array($role, self::ROLES, true)) {
           echo "Invalid role";
        }
        $this->role = $role;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = self::hash($password);
        return $this;
    }
 
    //btshoof el input match el hash wala la2 built in func
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

  // ne7ol el obj l array 3shan na3ml insert
  //version mn 8er el password 3shan el display
    public function toArray(): array
    {
        return [
            'id'         => $this->id,
            'first_name' => $this->firstName,
            'last_name'  => $this->lastName,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'role'       => $this->role,
            'birth_date' => $this->birthDate,
            'created_at' => $this->createdAt,
        ];
    }
    
    public function toRow(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name'  => $this->lastName,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'password'   => $this->password,
            'role'       => $this->role,
            'birth_date' => $this->birthDate,
        ];
    }

}