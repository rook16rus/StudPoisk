<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    // Указываем кодировку
    $server = "localhost"; /* имя хоста (уточняется у провайдера), если работаем на локальном сервере, то указываем localhost */
    $username = "root"; /* Имя пользователя БД */
    $password = ""; /* Пароль пользователя, если у пользователя нет пароля то, оставляем пустым */
    $database = "autorization_db"; /* Имя базы данных, которую создали */
     
    // Подключение к базе данный через MySQLi
    $mysqli = mysqli_connect($server, $username, $password, $database);
 
    // Проверяем, успешность соединения. 
    if (mysqli_connect_errno()) { 
        echo "<p><strong>Ошибка подключения к БД</strong>. Описание ошибки: ".mysqli_connect_error()."</p>";
        exit(); 
    }
 
    // Устанавливаем кодировку подключения
    $mysqli->set_charset('utf8');
 
    //Для удобства, добавим здесь переменную, которая будет содержать название нашего сайта
    $address_site = "http://testsite.local";
?>