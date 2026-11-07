<?php

namespace App\Controller;
use App\Core\Validation;
use PDO;

class DoctorController
{
   public function createShift($pdo) {
    
      $day_of_week = trim($_POST['day_of_week'] ?? '');
      $start_time = trim($_POST['start_time'] ?? '');
      $end_time = trim($_POST['end_time'] ?? '');
      
      $userId = $_SESSION['user']['id'] ?? null;
      if (!$userId) {
         setmessage("Please login first.", "danger");
         header("Location: index.php?page=login");
         exit;
      }

      $stmt = $pdo->prepare("SELECT id FROM doctor_details WHERE user_id = ?");
      $stmt->execute([$userId]);
      $doctor = $stmt->fetch();

      if (!$doctor) {
         setmessage("You must have a doctor profile to create shifts.", "danger");
         header("Location: index.php?page=create_shift");
         exit;
      }

      $doctorId = $doctor['id'];

      $errors = [];
      if($error = Validation::validate_require($day_of_week, "Day of Week")) {
         $errors['day_of_week'] = $error;
      }
      if($error = Validation::validate_require($start_time, "Start Time")) {
         $errors['start_time'] = $error;
      }
      if($error = Validation::validate_require($end_time, "End Time")) {
         $errors['end_time'] = $error;
      }
      
      if (!empty($errors)) {
         $_SESSION['errors'] = $errors;
         $_SESSION['old'] = $_POST;
         header('Location: index.php?page=create_shift');
         exit;
      }

      $stmt = $pdo->prepare("INSERT INTO doctor_schedules (doctor_id, day_of_week, start_time, end_time) VALUES (?, ?, ?, ?)");
      $success = $stmt->execute([$doctorId, $day_of_week, $start_time, $end_time]);

      if ($success) {
         unset($_SESSION['old']);
         setmessage("Shift created successfully.", "success");
         header('Location: index.php?page=shifts');
         exit;
      }
   }
   
  /////////////////////////////////////////// 
  

     public function listShifts($pdo)
    {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            setmessage("Please login first.", "danger");
            header("Location: index.php?page=login");
            exit;
        }

        $stmt = $pdo->prepare("SELECT id FROM doctor_details WHERE user_id = ?");
        $stmt->execute([$userId]);
        $doctor = $stmt->fetch();

        if (!$doctor) {
            setmessage("You must have a doctor profile.", "danger");
            header("Location: index.php?page=home");
            exit;
        }
        $doctorId = $doctor['id'];

        $stmt = $pdo->prepare("SELECT * FROM doctor_schedules WHERE doctor_id = ?");
        $stmt->execute([$doctorId]);
        $shifts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../../views/doctor-dashboard/shifts_list.php';
    }
   //////////////////////////////////////////////
    public function editShift($pdo)
    {
        $shiftId = $_GET['shift_id'] ?? $_POST['shift_id'] ?? null;
        if (!$shiftId) {
            header("Location: index.php?page=shifts");
            exit;
        }

        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            setmessage("Please login first.", "danger");
            header("Location: index.php?page=login");
            exit;
        }

        $stmt = $pdo->prepare("SELECT id FROM doctor_details WHERE user_id = ?");
        $stmt->execute([$userId]);
        $doctor = $stmt->fetch();

        if (!$doctor) {
            setmessage("You must have a doctor profile.", "danger");
            header("Location: index.php?page=home");
            exit;
        }
        $doctorId = $doctor['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $day_of_week = trim($_POST['day_of_week'] ?? '');
            $start_time  = trim($_POST['start_time'] ?? '');
            $end_time    = trim($_POST['end_time'] ?? '');

            $errors = [];
            if ($error = Validation::validate_require($day_of_week, "Day of Week")) {
                $errors['day_of_week'] = $error;
            }
            if ($error = Validation::validate_require($start_time, "Start Time")) {
                $errors['start_time'] = $error;
            }
            if ($error = Validation::validate_require($end_time, "End Time")) {
                $errors['end_time'] = $error;
            }

            if (empty($errors['start_time']) && empty($errors['end_time']) && $end_time <= $start_time) {
                $errors['end_time'] = "End Time must be after Start Time.";
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?page=edit_shift&shift_id=' . urlencode($shiftId));
                exit;
            }

            $stmt = $pdo->prepare(
                "UPDATE doctor_schedules
                 SET day_of_week = ?, start_time = ?, end_time = ?
                 WHERE id = ? AND doctor_id = ?"
            );
            $success = $stmt->execute([$day_of_week, $start_time, $end_time, $shiftId, $doctorId]);

            if ($success) {
                unset($_SESSION['old']);
                setmessage("Shift updated successfully.", "success");
                header('Location: index.php?page=shifts');
                exit;
            }

            setmessage("Failed to update shift. Please try again.", "danger");
        }

        $stmt = $pdo->prepare("SELECT * FROM doctor_schedules WHERE id = ? AND doctor_id = ?");
        $stmt->execute([$shiftId, $doctorId]);
        $shift = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$shift) {
            setmessage("Shift not found.", "danger");
            header("Location: index.php?page=shifts");
            exit;
        }

        $old = $_SESSION['old'] ?? [];
        unset($_SESSION['old']);

        require_once __DIR__ . '/../../views/doctor-dashboard/edit_shift.php';
    }

   ///////////////////////////////////////

   public function deleteShift($pdo){
      $shiftId = $_POST['shift_id'] ?? null;

      $userId = $_SESSION['user']['id'] ?? null;
      if (!$userId) {
         setmessage("Please login first.", "danger");
         header("Location: index.php?page=login");
         exit;
      }

      $stmt = $pdo->prepare("SELECT id FROM doctor_details WHERE user_id = ?");
      $stmt->execute([$userId]);
      $doctor = $stmt->fetch();

      if (!$doctor) {
         setmessage("You must have a doctor profile to delete shifts.", "danger");
         header("Location: index.php?page=home");
         exit;
      }

      $doctorId = $doctor['id'];

      $stmt = $pdo->prepare("SELECT * FROM doctor_schedules WHERE id = ? AND doctor_id = ?");
      $stmt->execute([$shiftId, $doctorId]);
      $shift = $stmt->fetch();

      if (!$shift) {
         setmessage("Shift not found or you don't have permission to delete it.", "danger");
         header("Location: index.php?page=shifts");
         exit;
      }

      $stmt = $pdo->prepare("DELETE FROM doctor_schedules WHERE id = ?");
      $success = $stmt->execute([$shiftId]);

      if ($success) {
         setmessage("Shift deleted successfully.", "success");
         header('Location: index.php?page=shifts');
         exit;
      } else {
         setmessage("Failed to delete the shift. Please try again.", "danger");
         header('Location: index.php?page=shifts');
         exit;
      }
   }

    public function doctorPricing($pdo) {
        $userId = $_SESSION['user']['id'] ?? null;
        if (!$userId) {
            setmessage("Please login first.", "danger");
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $majorId      = (int) ($_POST['major_id'] ?? 0);
            $examination  = trim($_POST['examination_price'] ?? '');
            $consultation = trim($_POST['consultation_price'] ?? '');

            $errors = [];

            $stmt = $pdo->prepare("SELECT id FROM majors WHERE id = ?");
            $stmt->execute([$majorId]);
            if (!$stmt->fetch()) {
                $errors['major_id'] = 'Please choose a valid major.';
            }
            if ($error = Validation::validate_require($examination, "Examination Price")) {
                $errors['examination_price'] = $error;
            } elseif (!is_numeric($examination) || $examination < 0) {
                $errors['examination_price'] = 'Examination price must be a valid number.';
            }
            if ($error = Validation::validate_require($consultation, "Consultation Price")) {
                $errors['consultation_price'] = $error;
            } elseif (!is_numeric($consultation) || $consultation < 0) {
                $errors['consultation_price'] = 'Consultation price must be a valid number.';
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old'] = $_POST;
                header('Location: index.php?page=doctor_pricing');
                exit;
            }

            $stmt = $pdo->prepare("SELECT id FROM doctor_details WHERE user_id = ?");
            $stmt->execute([$userId]);

            if ($stmt->fetch()) {
                $stmt = $pdo->prepare("UPDATE doctor_details SET major_id = ?, examination_price = ?, consultation_price = ? WHERE user_id = ?");
                $success = $stmt->execute([$majorId, $examination, $consultation, $userId]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO doctor_details (user_id, major_id, examination_price, consultation_price) VALUES (?, ?, ?, ?)");
                $success = $stmt->execute([$userId, $majorId, $examination, $consultation]);
            }

            if ($success) {
                unset($_SESSION['old']);
                setmessage("Pricing saved successfully.", "success");
            } else {
                setmessage("Failed to save pricing. Please try again.", "danger");
            }
            header('Location: index.php?page=doctor_pricing');
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM doctor_details WHERE user_id = ?");
        $stmt->execute([$userId]);
        $details = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        $stmt = $pdo->query("SELECT id, name FROM majors ORDER BY name");
        $majors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        require_once __DIR__ . '/../../views/doctor-dashboard/doctor_pricing.php';
   }
    
    public function listBookings($pdo){
        
    }
  
}