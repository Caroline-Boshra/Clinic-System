<?php
require_once __DIR__ . '/config/db.php';
session_start();

if (isset($_SESSION["user"])) {

    echo "Name: " . $_SESSION["user"]["name"] . "<br>";
    echo "Email: " . $_SESSION["user"]["email"] . "<br>";
    echo "Phone: " . $_SESSION["user"]["phone"] . "<br>";

} else {

    echo "Please register first.";

}

?>
<!DOCTYPE html>
<html lang="eng">
    <a href="logout.php">LogOut</a>
</html>