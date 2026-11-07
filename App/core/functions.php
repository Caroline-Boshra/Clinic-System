<?php
function isPasswordHash(string $value): bool
{
    return password_get_info($value)['algoName'] !== 'unknown';
}

function setmessage($message, $type)
{
    $_SESSION['message'] = [
        'text' => $message,
        'type' => $type
    ];
}

function showmessage($type = null, $field = null)
{
    // General message
    if ($type !== 'error' && isset($_SESSION['message'])) {
        $text = $_SESSION['message']['text'];
        $messageType = $_SESSION['message']['type'];

        if ($type === null || $messageType === $type) {
            echo "<div class='alert alert-$messageType'>$text</div>";
            unset($_SESSION['message']);
        }
    }

    // Validation errors
    if ($type === 'error' && !empty($_SESSION['errors'])) {
        if ($field === null) {
            foreach ($_SESSION['errors'] as $error) {
                echo "<div class='text-danger mt-1'>" . htmlspecialchars($error, ENT_QUOTES) . "</div>";
            }
            unset($_SESSION['errors']);
        } elseif (isset($_SESSION['errors'][$field])) {
            echo "<div class='text-danger mt-1'>" . htmlspecialchars($_SESSION['errors'][$field], ENT_QUOTES) . "</div>";
            unset($_SESSION['errors'][$field]);
        }
    }

    return "";
}

session_start();
//require_once  '../config/db.php';
// 3amlt  prepare w excute more safe zay ma 2al bashmohnds ziad 2al
function findUserById($id) {
    global $pdo;
    $st = $pdo->prepare('SELECT * FROM users WHERE id = ?');//make query
    $st->execute([$id]);// add value
    return $st->fetch();  //return row as array              
}

function findUserByEmail($email) {
    global $pdo;
    $st = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $st->execute([$email]);
    return $st->fetch();
}

function userExists($email, $phone) {
    global $pdo;
    $st = $pdo->prepare('SELECT id FROM users WHERE email = ? OR phone = ?');
    $st->execute([$email, $phone]);
    return (bool)$st->fetch();
}

function getAllUsers() {
    global $pdo;
    return $pdo->query('SELECT * FROM users ORDER BY id')->fetchAll();
}


function createUser($first, $last, $email, $phone, $password, $birth) {
    global $pdo;
    $st = $pdo->prepare(
        'INSERT INTO users (first_name, last_name, email, phone, password, birth_date)
         VALUES (?, ?, ?, ?, ?, ?)');
    $st->execute([$first, $last, $email, $phone,
                  password_hash($password, PASSWORD_DEFAULT),
                  $birth !== '' ? $birth : null]);
    return $pdo->lastInsertId();          // new user id
}

function updateUser($id, $first, $last, $phone, $birth) {
    global $pdo;
    $st = $pdo->prepare('UPDATE users SET first_name=?, last_name=?, phone=?, birth_date=? WHERE id=?');
    $st->execute([$first, $last, $phone, $birth !== '' ? $birth : null, $id]);
}

function deleteUser($id) {
    global $pdo;
    $pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
}
function requireLogin() {
    $u = currentUser();
    if (!$u) { header('Location: login.php'); exit; }
    return $u;
}

function login($userId) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $userId;
}

function currentUser() {                 
    if (empty($_SESSION['user_id'])){
       return null;
    }
    return findUserById($_SESSION['user_id']) ?: null;
}

function logout() {
    $_SESSION = [];
    session_destroy();
}
const DOCTOR_SQL = 'SELECT d.*, u.first_name, u.last_name, m.name AS major
                    FROM doctor d
                    JOIN users u ON u.id = d.user_id
                    JOIN major m ON m.id = d.speciality_id';
function findDoctorById($id) {
     global $pdo;
     $st = $pdo->prepare(DOCTOR_SQL . ' WHERE d.id = ?');
     $st->execute([$id]);
     return $st->fetch();
 }

 function getDoctors(){
    global $pdo;
     $st = $pdo->prepare(DOCTOR_SQL . ' ORDER BY m.name');
     $st->execute();
     return $st->fetchAll();
 }


function bookAppointment($patientId, $doctorId, $date, $type) {
    global $pdo;
    $doctor = findDoctorById($doctorId);
    if (!$doctor)                               return 'Please choose a doctor.';
    if (!in_array($type, ['consultation', 'examination'], true)) return 'Choose an appointment type.';
    
    $price = ($type === 'examination') ? $doctor['examination_price'] : $doctor['consultation_price'];

    $st =$pdo->prepare("INSERT INTO appointment
           (patient_id, doctor_id, schedule_id, appointment_date,  type, price, status)
         VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    $st->execute([$patientId, $doctorId,  $date, $type, $price]);
    return true;
}
 

function getPatientAppointments($patientId) {
     global $pdo;
    $st = $pdo->prepare('SELECT a.*, u.first_name, u.last_name, m.name AS major
         FROM appointment a
         JOIN doctor d ON d.id = a.doctor_id
         JOIN users u  ON u.id = d.user_id
         JOIN major m  ON m.id = d.speciality_id
         WHERE a.patient_id = ?
         ORDER BY a.appointment_date DESC');
    $st->execute([$patientId]);
    return $st->fetchAll();
       
}

function cancelAppointment($appointmentId, $patientId) {
    global $pdo;
    $a =$pdo->prepare('SELECT * FROM appointment WHERE id = ? AND patient_id = ?', [$appointmentId, $patientId]);
    $a->execute();
    $a = $a->fetch();
    if (!$a){
    return 'Appointment not found.';
    }

    $st = $pdo->prepare("UPDATE appointment SET status = 'cancelled' WHERE id = ?");
    $st->execute([$appointmentId]);
    return true;
}