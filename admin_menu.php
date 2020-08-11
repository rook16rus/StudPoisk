<?php
session_start();
require_once 'dbconnect.php';

$all_students = mysqli_query($mysqli, "SELECT user_login FROM users");

/* =============== Регистрация студента =============== */

    if (isset($_POST['addUser'])) {

        while ($row = mysqli_fetch_assoc($all_students)) {
            if ($row['user_login'] == $_POST['student-login']) {
                $message = "Такой логин уже существует!";
            }
        }
        if (empty($message)) {
            if (!empty($_POST['student-last-name']) && !empty($_POST['student-name']) && !empty($_POST['patronymic']) && !empty($_POST['birth-of-date']) && 
        !empty($_POST['profession']) && !empty($_POST['course']) && !empty($_POST['students-group']) && !empty($_POST['student-login']) && 
        !empty($_POST['student-password']) && !empty($_FILES['student_image']['tmp_name'])) {

            $last_name = htmlspecialchars($_POST['student-last-name']);
            $name = htmlspecialchars($_POST['student-name']);
            $patronymic = htmlspecialchars($_POST['patronymic']);
            $birth_of_date = htmlspecialchars($_POST['birth-of-date']);
            $age = floor((time() - strtotime($birth_of_date)) / 31556926);
            $profession = htmlspecialchars($_POST['profession']);
            $course = htmlspecialchars($_POST['course']);
            $students_group = htmlspecialchars($_POST['students-group']);
            $student_login = htmlspecialchars($_POST['student-login']);
            $student_password = htmlspecialchars($_POST['student-password']);
            $query =mysqli_query($mysqli, "SELECT * FROM users");
            $numrows=mysqli_num_rows($query);
            $photo = addslashes(file_get_contents($_FILES['student_image']['tmp_name']));

            

            //Начальный вариант
            /*$img_type = substr($_FILES['student_image']['type'], 0, 5);
            $img_size = 2*1024*1024;
            if(!empty($_FILES['student_image']['tmp_name']) && $img_type === 'image' && $img_size >= $_FILES['student_image']['size']) {
                $photo = addslashes(file_get_contents($_FILES['student_image']['tmp_name']));

            }*/

            $sql = "INSERT INTO users(lastname, name, patronymic, date_of_birth, profession, course, students_group, user_login, user_password, student_photo, age)
            VALUES('$last_name','$name', '$patronymic', '$birth_of_date', '$profession', '$course', '$students_group', '$student_login', '$student_password', '$photo', '$age')";
            $result = mysqli_query($mysqli,$sql);
        } else {
            $message = "Не все поля заполнены";
            echo $message;
        }
        }
        
    }

/* =============== Регистрация администратора =============== */

    if (isset($_POST['addAdmin'])) {
        if (!empty($_POST['admin-last-name']) && !empty($_POST['admin-name']) && !empty($_POST['admin-patronymic']) && !empty($_POST['admin-birth-of-date']) && !empty($_POST['admin-login']) && !empty($_POST['admin-password']) && !empty($_FILES['admin_image']['tmp_name'])) {
            
            $admin_last_name = htmlspecialchars($_POST['admin-last-name']);
            $admin_name = htmlspecialchars($_POST['admin-name']);
            $admin_patronymic = htmlspecialchars($_POST['admin-patronymic']);
            $admin_birth_of_date = htmlspecialchars($_POST['admin-birth-of-date']);
            $age = floor((time() - strtotime($admin_birth_of_date)) / 31556926);
            $admin_login = htmlspecialchars($_POST['admin-login']);
            $admin_password = htmlspecialchars($_POST['admin-password']);
            $query =mysqli_query($mysqli, "SELECT * FROM users");
            $numrows=mysqli_num_rows($query);
            $photo = addslashes(file_get_contents($_FILES['admin_image']['tmp_name']));

            /*$img_type = substr($_FILES['admin_image']['type'], 0, 5);
            $img_size = 2*1024*1024;
            if(!empty($_FILES['admin_image']['tmp_name']) && $img_type === 'image' && $img_size >= $_FILES['admin_image']['size']) {
                $photo = addslashes(file_get_contents($_FILES['admin_image']['tmp_name']));
            }*/

            $sql = "INSERT INTO users(lastname, name, patronymic, date_of_birth, user_login, user_password, student_photo, age, is_admin)
            VALUES('$admin_last_name','$admin_name', '$admin_patronymic', '$admin_birth_of_date', '$admin_login', '$admin_password', '$photo', '$age', 1)";
            $result = mysqli_query($mysqli,$sql);

        } else {
            echo "Нет подключения";
            echo "<br>";
            print_r($_POST);
            exit;
        }
    }

    /* =============== Дополнительные поля =============== */

    if (isset($_POST['transfer'])) {
        $from_course = htmlspecialchars($_POST['from-course']);
        $to_course = htmlspecialchars($_POST['to-course']);
        $new_group = htmlspecialchars($_POST['new-group']);
        $group = htmlspecialchars($_POST['delete-group']);

        if(!empty($from_course) && !empty($to_course)) {
            $students_course = mysqli_query($mysqli, "UPDATE users SET course = '$to_course' WHERE course = '$from_course'");
        }

        if(!empty($new_group)) {
            $add_group = mysqli_query($mysqli, "INSERT INTO groups (students_group) VALUES ('$new_group')");
        }

        if (!empty($group)) {
            $delete_group = mysqli_query($mysqli, "DELETE FROM groups WHERE students_group = '$group'");
            $delete_users = mysqli_query($mysqli, "DELETE FROM users WHERE students_group = '$group'");
        }
    }

    $groups = mysqli_query($mysqli, "SELECT students_group FROM groups");


    require_once 'admin_header.php';
?> 


    <main>
        <div class="main-block">
            <div class="tabs">
            <div class="tabs__nav">
                <a class="tabs__link tabs__link_active" href="#content-1">Студент</a>
                <a class="tabs__link" href="#content-2">Администратор</a>
            </div>
            <div class="tabs__content">
            <div class="tabs__pane tabs__pane_show" id="content-1">
            <form action="#" method="post" enctype="multipart/form-data">
                <section class="add-student">
                    <div class="add-student-block">
                        <h2>Общая информация</h2>
                        <div class="add-student-row">
                            <label for="student-last-name">Фамилия</label>
                            <input type="text" id="student-last-name" name="student-last-name" placeholder="Введите данные">
                        </div>
                        <div class="add-student-row">
                            <label for="student-name">Имя</label>
                            <input type="text" id="student-name" name="student-name" placeholder="Введите данные">
                        </div>
                        <div class="add-student-row">
                            <label for="patronymic">Отчество</label>
                            <input type="text" id="patronymic" name="patronymic" placeholder="Введите данные">
                        </div>
                        <div class="add-student-row">
                            <label for="birth-of-date">Дата рождения</label>
                            <input type="date" id="birth-of-date" name="birth-of-date">
                        </div>
                        <div class="add-student-row">
                            <label for="profession">Специальность/Профессия</label>
                            <select id="profession" name="profession">
                                <option value="IT-специалист">IT-специалист</option>
                                <option value="Web-разработчик">Web-разработчик</option>
                            </select>
                        </div>
                        <div class="add-student-row">
                            <label for="course">Курс</label>
                            <select id="course" name="course">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="add-student-row">
                            <label for="students-group">Группа</label>
                            <select id="students-group" name="students-group">
                                <?php 
                                    while ($row = mysqli_fetch_assoc($groups)) { 
                                        echo "<option value='$row[students_group]'>$row[students_group]</option>";
                                    }
                                 ?>
                            </select>
                        </div>
                        <div class="add-student-row">
                            <label for="student-login">Логин</label>
                            <input type="text" id="student-login" name="student-login" placeholder="Введите данные">
                        </div>
                        <div class="add-student-row">
                            <label for="student-password">Пароль</label>
                            <input type="password" id="student-password" name="student-password" placeholder="Введите данные">
                        </div>
                    </div>
                    <div class="add-student-block">
                        <h2>Фотография профиля</h2>
                        <h3>Загрузка и редактирование</h3>
                        <label for="downloadFile" id="download-file-label">Выбрать файл</label>
                        <input type="file" id="downloadFile" name="student_image" accept="image/*">
                        <span class="outputImage" id="outputImage">
                        </span>
                    </div>
                    <div class="button-block">
                        <form method="post">
                            <input type="submit" id="addUser" name="addUser" value="Добавить">
                        </form>
                    </div>
                </section>
            </form>
            </div>
            <div class="tabs__pane" id="content-2">
                <form action="#" method="post" enctype="multipart/form-data">
                <section class="add-student">
                    <div class="add-student-block">
                        <h2>Общая информация</h2>
                        <div class="add-student-row">
                            <label for="admin-last-name">Фамилия</label>
                            <input type="text" id="admin-last-name" name="admin-last-name" placeholder="Введите данные">
                        </div>
                        <div class="add-student-row">
                            <label for="admin-name">Имя</label>
                            <input type="text" id="admin-name" name="admin-name" placeholder="Введите данные">
                        </div>
                        <div class="add-student-row">
                            <label for="admin-patronymic">Отчество</label>
                            <input type="text" id="admin-patronymic" name="admin-patronymic" placeholder="Введите данные">
                        </div>
                        <div class="add-student-row">
                            <label for="admin-birth-of-date">Дата рождения</label>
                            <input type="date" id="admin-birth-of-date" name="admin-birth-of-date">
                        </div>
                        <div class="add-student-row">
                            <label for="admin-login">Логин</label>
                            <input type="text" id="admin-login" name="admin-login" placeholder="Введите данные">
                        </div>
                        <div class="add-student-row">
                            <label for="admin-password">Пароль</label>
                            <input type="password" id="admin-password" name="admin-password" placeholder="Введите данные">
                        </div>
                    </div>
                    <div class="add-student-block">
                        <h2>Фотография профиля</h2>
                        <h3>Загрузка и редактирование</h3>
                        <label for="downloadAdminFile" id="download-admin-file-label">Выбрать файл</label>
                        <input type="file" id="downloadAdminFile" name="admin_image" accept="image/*">
                        <span class="outputAdminImage" id="outputAdminImage">
                            
                        </span>
                    </div>
                    <div class="button-block">
                        <form method="post">
                            <input type="submit" id="addAdmin" name="addAdmin" value="Добавить">
                        </form>
                    </div>
                </section>
            </form>
            </div>
            </div>
            <?php 
                if (!empty($message)) {
                    echo $message;
                }
            ?>
            </div>
            <form action="#" method="post" id="other-updates">
                <section class="student-other">
                    <h2>Дополнительные поля</h2>
                    <h3>Перевод на другой курс</h3>
                    <input type="text" id="from-course" name="from-course" placeholder="С какого курса">
                    <input type="text" id="to-course" name="to-course" placeholder="На какой курс">
                    <h3>Добавление группы</h3>
                    <input type="text" id="new-group" name="new-group" placeholder="Введите значение">
                    <h3>Удаление группы</h3>
                    <input type="text" id="delete-group" name="delete-group" placeholder="Введите значение">
                    <div class="button-block">
                        <input type="submit" name="transfer" value="Отправить запрос">
                    </div>
                </section>
            </form>
        </div>
    </main>
    <footer>
        <div class="main-block-footer">
            Copyright 2020
        </div>
    </footer>
    <script src="libraries/admin.js"></script>
    <script src="libraries/tabs.js"></script>
</body>
</html>
