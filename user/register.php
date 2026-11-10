<?php
use Clinic\{User, RegistrationValidator,Database,UserFunctions,Auth,AppointmentService};
$pdo          = Database::connection();
$users        = new UserFunctions($pdo);
$appointments = new AppointmentService($pdo, $doctors);
$auth         = new Auth($users);         
 



$errors = [];
$first = $last = $email = $phone = $birth = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = [
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name'  => trim($_POST['last_name'] ?? ''),
        'email'      => trim($_POST['email'] ?? ''),
        'phone'      => trim($_POST['phone'] ?? ''),
        'birth_date' => trim($_POST['birth_date'] ?? ''),
        'password'   => $_POST['password'] ?? '',
        'confirm'    => $_POST['confirm'] ?? '',
    ];
   /*
    $first = $input['first_name']; $last = $input['last_name'];
    $email = $input['email'];      $phone = $input['phone'];
    $birth = $input['birth_date'];
*/
    $errors = (new RegistrationValidator($users))->validate($input);

    if (!$errors) {
        $user = User::register(
            $input['first_name'], $input['last_name'], $input['email'],
            $input['phone'], $input['password'], $input['birth_date']
        );
        $id = $users->create($user);
        header('Location: Dashboard.php');
        exit;
    }
}
?>