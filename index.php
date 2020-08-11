<?php
session_start();    
require_once("dbconnect.php");

    if(isset($_SESSION["session_username"]) && $_SESSION['session_is_admin'] == 0){
    header("Location: my_portfolio.php");
    } elseif (isset($_SESSION['session_username']) && $_SESSION['session_is_admin'] == 1) {
        header("Location: admin_main.php");
    }

if(isset($_POST["loginButton"])){


    if(!empty($_POST['loginInput']) && !empty($_POST['passwordInput'])) {
    $username=htmlspecialchars($_POST['loginInput']);
    $password=htmlspecialchars($_POST['passwordInput']);
    $query =mysqli_query($mysqli, "SELECT * FROM users");
    $numrows=mysqli_num_rows($query);
    if($numrows!=0)
 {
while($row=mysqli_fetch_assoc($query))
 {
    $dbusername = $row['user_login'];
  $dbpassword = $row['user_password'];
  $role = $row['is_admin'];
  $user_id = $row['user_id'];
 
  if($username == $dbusername && $password == $dbpassword)
 {
    // старое место расположения
    //  session_start();
     $_SESSION['session_username'] = $username;
     $_SESSION['session_username_id'] = $user_id;
     $_SESSION['session_is_admin'] = $role;
 /* Перенаправление браузера в зависимости от роли пользователя */
    
    if ($role == 1) {
        header("Location: admin_main.php");
    } else {
        header("Location: my_portfolio.php");
    }
    }
    }
    } else {
    //  $message = "Invalid username or password!";
    
    echo  "Invalid username or password!";
 }
    } else {
    $message = "All fields are required!";
    }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    
    <div class="overlay">
        <form action="#" method="POST" id="loginForm">
            <div class="autorization">
                <h2>Войти в систему</h2>
                <input type="text" name="loginInput" id="loginInput" placeholder="Введите логин">
                <input type="password" name="passwordInput" id="passwordInput" placeholder="Введите пароль">
                <div class="button-block">
                    <button type="reset" id="reset">Сбросить</button>
                    <input type="submit" id="loginButton" name="loginButton" class="loginButton" value="Войти">
                    <input type="button" name="butt" value="DNO">
                </div>
            </div>
        </form>
        <?php if (!empty($message)) {echo '<p class="error">" . "MESSAGE: ". $message . "</p>';} ?>
    </div>
</body>
</html>