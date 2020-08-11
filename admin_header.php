<?php

session_start();
require_once 'dbconnect.php';

$session_name = $_SESSION["session_username"];
$session_id = $_SESSION["session_username_id"];
$session_role = $_SESSION["session_is_admin"];
/* =============== Блок настроек =============== */
    

    if (isset($_POST['sendUpdates'])) {
            $login_change = htmlspecialchars($_POST['userEmail']);
            $password_change = htmlspecialchars($_POST['userPassword']);
            if (!empty($login_change)) {
                $update_login = mysqli_query($mysqli, "UPDATE users SET user_login = '$login_change' WHERE user_login = '$session_name'");
                session_unset();
                header("Location: index.php");
            }
        
            if (!empty(htmlspecialchars($_POST['userPhoto']))) {
                $photo_change = htmlspecialchars($_POST['userPhoto']);
                $update_photo = mysqli_query($mysqli, "UPDATE users SET student_photo = '$photo_change' WHERE user_login = '$session_name'");
                }

            if (!empty($password_change)) {
                $update_password = mysqli_query($mysqli, "UPDATE users SET user_password = '$password_change' WHERE user_login = '$session_name'");
            }

    }


if(empty($session_name)){
    header("Location: index.php");
} elseif ($session_role == 0) {
    header("Location: my_portfolio.php");
}

    extract($_SESSION);
    $query = "SELECT * FROM users WHERE user_login = '$session_name'";
    $profiles = mysqli_query($mysqli, $query);
    $profiles = mysqli_fetch_all($profiles, MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Админ меню</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tabs.css">
    <link rel="stylesheet" href="css/modal.css">
    <script src="plugins/modalAddAchievement.js"></script>
    <script src="plugins/modalEditAchievement.js"></script>
    <script src="plugins/userBlock.js"></script>
    <script src="plugins/modalSettings.js"></script>
</head>
<body>
    <header>
        <div class="main-block-header">
            <nav>
                <ul>
                    <li><a href="admin_main.php">Студенты</a></li>
                    <li><a href="admin_menu.php">Меню администратора</a></li>
                </ul>
            </nav>
            <section class="user-block">
                <div class="user">
                    <?php foreach ($profiles as $profile): ?>
                    <span class="user-name"><?php echo "$profile[lastname] $profile[name]"; ?></span>
                    <img src="data:image/jpeg;base64, <?php  $photo = base64_encode($profile['student_photo']); echo $photo; ?>" alt="user-photo" width="45px" height="45px">
                    <?php endforeach ?>
                </div>
            </section>
             <div class="user-action-block">
                <h2 class="action-block">Блок пользователя</h2>
                <hr>
                <div class="user-additional-actions">
                    <button id="settings">Настройки</button>
                </div>
                <hr>
                <a href="logout.php">Выход</a>
            </div>
        </div>
    </header>