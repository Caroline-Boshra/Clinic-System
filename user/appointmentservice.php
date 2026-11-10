<?php
namespace Clinic;

use PDO;

class AppointmentService
{
    public function __construct(private PDO $pdo, private DoctorRepository $doctors) {}

    public function book(int $patientId, int $doctorId, string $date, string $type): void
    {
        $doctor = $this->doctors->findById($doctorId);
        if (!$doctor) {
            echo 'Please choose a doctor.';
            return;
        }
        if (!in_array($type, Doctor::TYPES, true)) {
           echo 'Choose an appointment type.';
           return;
        }
        $ts = strtotime($date);
        if ($ts === false || $ts < strtotime('today')) {
           echo 'Choose a valid future date.';
           return;
        }

        $st = $this->pdo->prepare(
            "INSERT INTO appointment (patient_id, doctor_id, appointment_date, type, price, status)
             VALUES (?, ?, ?, ?, ?, 'pending')"
        );
        $st->execute([$patientId, $doctorId, date('Y-m-d', $ts), $type, $doctor->priceFor($type)]);
    }

    public function forPatient(int $patientId): array
    {
        $st = $this->pdo->prepare(
            'SELECT a.*, u.first_name, u.last_name, m.name AS major
             FROM appointment a
             JOIN doctor d ON d.id = a.doctor_id
             JOIN users u  ON u.id = d.user_id
             JOIN major m  ON m.id = d.speciality_id
             WHERE a.patient_id = ?
             ORDER BY a.appointment_date DESC'
        );
        $st->execute([$patientId]);
        return $st->fetchAll();
    }

    public function cancel(int $appointmentId, int $patientId): void
    {
        $st = $this->pdo->prepare('SELECT id FROM appointment WHERE id = ? AND patient_id = ?');
        $st->execute([$appointmentId, $patientId]);
        if (!$st->fetch()) {
            echo 'Appointment not found.';
            return;
        }
        $this->pdo->prepare("UPDATE appointment SET status = 'cancelled' WHERE id = ?")
                  ->execute([$appointmentId]);
    }
}